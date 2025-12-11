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
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db = getenv('DB_NAME') ?: 'studentsphere';
$port = getenv('DB_PORT') ?: '5432'; // PostgreSQL default port

try {
  // Use PostgreSQL for Render, MySQL for local development
  $driver = getenv('DB_DRIVER') ?: 'mysql';
  
  if ($driver === 'pgsql') {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
  } else {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
  }
  
  $pdo = new PDO($dsn, $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Database Error: " . $e->getMessage());
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





