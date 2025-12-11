<?php 
declare(strict_types=1);

//only  start session if not active
if (session_status() === PHP_SESSION_NONE) {
  session_set_cookie_params([
    'lifetime' => 0,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
  ]);
  session_name('PERFECT_IN_PROGRESS');
  ini_set('session.use_strict_mode', 1);
  session_start();
}

//DATABASE CONNECTION
// Robust DB parsing + diagnostics for Render vs local
$driver = getenv('DB_DRIVER') ?: null;
$databaseUrl = getenv('DATABASE_URL') ?: getenv('DB_URL') ?: null;

// If a full DATABASE_URL is provided (common on some hosts), parse it
if ($databaseUrl) {
  $parts = parse_url($databaseUrl);
  if ($parts !== false) {
    $scheme = $parts['scheme'] ?? null;
    if ($scheme === 'postgres' || $scheme === 'postgresql') {
      $driver = 'pgsql';
    } elseif ($scheme === 'mysql') {
      $driver = 'mysql';
    }
    $host = $parts['host'] ?? 'localhost';
    $port = $parts['port'] ?? null;
    $user = $parts['user'] ?? '';
    $pass = $parts['pass'] ?? '';
    $db = isset($parts['path']) ? ltrim($parts['path'], '/') : '';
  }
}

// Environment-only configuration (overrides defaults)
$driver = $driver ?: (getenv('DB_DRIVER') ?: 'mysql');
$host = $host ?? (getenv('DB_HOST') ?: 'localhost');
$user = $user ?? (getenv('DB_USER') ?: 'root');
$pass = $pass ?? (getenv('DB_PASSWORD') ?: '');
$db = $db ?? (getenv('DB_NAME') ?: 'studentsphere');
$port = $port ?? (getenv('DB_PORT') ?: ($driver === 'pgsql' ? '5432' : '3306'));

// Prevent accidental use of unix socket for MySQL when host is 'localhost'
if ($driver === 'mysql' && ($host === 'localhost' || $host === '')) {
  $host = '127.0.0.1';
}

// Log non-sensitive DB connection info to Render logs for debugging (no password)
error_log(sprintf("DB DEBUG: driver=%s host=%s port=%s user=%s db=%s", $driver, $host, $port, $user, $db));

try {
  if ($driver === 'pgsql') {
    // PostgreSQL connection (for Render)
    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=require', $host, $port, $db);
    $pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  } else {
    // MySQL connection (for local development)
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $db);
    $pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }
} catch (PDOException $e) {
  // Log full PDO error message (no password) for diagnosis in Render logs
  error_log(sprintf('DB CONNECTION ERROR: driver=%s host=%s port=%s user=%s db=%s message=%s', $driver, $host, $port, $user, $db, $e->getMessage()));
  die("Database Error: Unable to connect to the database. Please try again later.");
}

//SIMPLE AUTOLOADER
spl_autoload_register(function (string $className): void {
  $directories = [
    __DIR__ . '/../controllers/',
    __DIR__ . '/../models/',
  ];
  foreach ($directories as $dir) {
    $file = $dir . $className . '.php';
    if (file_exists($file)) {
      require $file;
      return;
    }
  }
});

function getUserSID() {
  if (isset($_SESSION['flash']['user-id'])) {
    $userID = $_SESSION['flash']['user-id'];
    return $userID;
  }
  return null;
}

function getAdminSID() {
  if (isset($_SESSION['flash']['admin-id'])) {
    $adminID = $_SESSION['flash']['admin-id'];
    return $adminID;
  } 
  return null;
}

function getUserKey($key, $userID) {
  $user = UserModel::getUser($userID);
  return $user[$key];
}





