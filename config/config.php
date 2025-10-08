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

//DATABASE CONNECTIOn
$dsn = 'mysql:host=localhost;dbname=studentsphere';
$username = 'root';

try {
  $pdo = new PDO($dsn, $username);

} catch (PDOException $e) {
  $error = "Database Error: ";
  $error .= $e->getMessage();
  include('view/error.php');
  exit();
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

if (isset($_SESSION['flash']['admin-id'])) {
  $adminID = $_SESSION['flash']['admin-id'];
} else if (isset($_SESSION['flash']['user-id'])) {
  $userID = $_SESSION['flash']['user-id'];
}







