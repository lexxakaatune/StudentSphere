<?php 
declare(strict_types=1);
class AdminModel {
  public static function getAdmin(string $username): array {
    global $pdo;
    $query = "SELECT ID, Pwd FROM admins WHERE UserName = :UserName;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":UserName", $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    return $admin;
  }

  public static function getAdminId(int $adminID): array|false {
    global $pdo;
    $query = "SELECT * FROM admins WHERE ID = :id;" ;
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $adminID);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    return $admin;
  }

  public static function insert_admin(string $userName, string $pwd) {
    global $pdo;
    $query = "INSERT INTO admins (UserName, Pwd) VALUES (:UserName, :Pwd);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":UserName", $userName);
    $stmt->bindParam(":Pwd", $pwd);
    $stmt->execute();
  } 

  public static function getAllStudent(): array {
    global $pdo;
    $query = 'SELECT * FROM students;' ;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $allStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $allStudents;
  }

  public static function totalStudent(): int {
    global $pdo;
    $query = 'SELECT COUNT(*) FROM students;' ;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $totalStudents = $stmt->fetchColumn();
    return (int) $totalStudents;
  }
}