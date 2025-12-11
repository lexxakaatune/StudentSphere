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
// Support both local development and Render deployment
$driver = getenv('DB_DRIVER') ?: 'mysql';
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db = getenv('DB_NAME') ?: 'studentsphere';
$port = getenv('DB_PORT') ?: ($driver === 'pgsql' ? '5432' : '3306');

try {
  if ($driver === 'pgsql') {
    // PostgreSQL connection (for Render)
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    $pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  } else {
    // MySQL connection (for local development)
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }
} catch (PDOException $e) {
  error_log("Database Connection Error: " . $e->getMessage());
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





