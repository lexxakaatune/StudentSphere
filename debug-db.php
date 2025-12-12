<?php
// Temporary debug endpoint to test database connectivity on the deployed host.
// Protection: requires `DEBUG_TOKEN` env var to match `?token=` query parameter.

declare(strict_types=1);

$required = getenv('DEBUG_TOKEN') ?: null;
$provided = $_GET['token'] ?? null;

if (!$required || !$provided || !hash_equals($required, $provided)) {
    http_response_code(403);
    echo "Forbidden: missing or invalid debug token.\n";
    error_log('DEBUG-DB: forbidden access attempt');
    exit;
}

header('Content-Type: text/plain');
echo "DB debug endpoint\n";

$driver = getenv('DB_DRIVER') ?: null;
$databaseUrl = getenv('DATABASE_URL') ?: getenv('DB_URL') ?: null;

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

$driver = $driver ?: (getenv('DB_DRIVER') ?: 'mysql');
$host = $host ?? (getenv('DB_HOST') ?: 'localhost');
$user = $user ?? (getenv('DB_USER') ?: 'root');
$pass = $pass ?? (getenv('DB_PASSWORD') ?: '');
$db = $db ?? (getenv('DB_NAME') ?: 'studentsphere');
$port = $port ?? (getenv('DB_PORT') ?: ($driver === 'pgsql' ? '5432' : '3306'));

if ($driver === 'mysql' && ($host === 'localhost' || $host === '')) {
    $host = '127.0.0.1';
}

echo sprintf("driver=%s\nhost=%s\nport=%s\nuser=%s\ndb=%s\n", $driver, $host, $port, $user, $db);

try {
    if ($driver === 'pgsql') {
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=require', $host, $port, $db);
    } else {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $db);
    }

    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT NOW() as now");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Connected: OK\n";
    echo "Server time: " . ($row['now'] ?? 'unknown') . "\n";
} catch (PDOException $e) {
    // Print the PDO message for debugging (do not print password)
    echo "Connection failed: " . $e->getMessage() . "\n";
    error_log('DEBUG-DB-ERROR: ' . $e->getMessage());
}

echo "\nDone. Remove this file after debugging.\n";

?>
