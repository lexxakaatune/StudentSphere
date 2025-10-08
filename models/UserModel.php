<?php 
declare(strict_types=1);
class UserModel {
  //create user
  public static function createUser(string $name, string $email, string $pwd, string $department, string $gender, string $class, string $photo): bool {
    global $pdo;
    $query = "INSERT INTO students (Name, Email, Pwd, Department, Gender, Class, Photo_Upload) VALUES (:Name, :Email,  :Pwd, :Department,  :Gender, :Class, :profile_photo);" ;
    $stmt = $pdo->prepare($query);
    $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt->bindParam(":Name", $name);
    $stmt->bindParam(":Email", $email);
    $stmt->bindParam(":Pwd", $hashedpwd);
    $stmt->bindParam(":Department", $department);
    $stmt->bindParam(":Gender", $gender);
    $stmt->bindParam(":Class", $class);
    $stmt->bindParam(":profile_photo", $photo);
     return $stmt->execute();
  }

  public static function getUser(string|int $email): array|bool {
    global $pdo;
    if (is_numeric($email)) {
     $query = "SELECT Name, Email, Department, Gender, Class, Photo_Upload FROM students WHERE ID = :ID;";
    } else if (!is_numeric($email)) {
      $query = "SELECT * FROM students WHERE Email = :Email;";
    }
    $stmt = $pdo->prepare($query);
    if (is_numeric($email)) {
      $stmt->bindParam(":ID", $email);
    } else {
      $stmt->bindParam(":Email", $email);
    }
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  public static function getUserPwd(string $Email): string|null {
    global $pdo;
    $query = "SELECT Pwd FROM students WHERE Email = :Email;" ;
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":Email", $Email);
    $stmt->execute();
    $user = $stmt->fetch();
    if (empty($user)) {
      return null;
    }
    return $user['Pwd'];
  } 

  public static function getUserId( string|int $Email): int {
    global $pdo;
    if (is_numeric($Email)) {
      $query = "SELECT ID FROM students WHERE ID = :ID;" ;
    } else if (!is_numeric($Email)) {
      $query = "SELECT ID FROM students WHERE Email = :Email;" ;
    }
    $stmt = $pdo->prepare($query);
    if (!is_numeric($Email)) {
      $stmt->bindParam(":Email", $Email);
    }
    if (is_numeric($Email)) {
      $stmt->bindParam(":ID", $Email);
    }
    $stmt->execute();
    $iD = $stmt->fetch();
    return $iD['ID'];
  }

  public static function deleteUser(string $email, string $pwd): void {
    global $pdo;
    $query = "DELETE FROM students WHERE Email = :Email AND Pwd = :Pwd;" ;
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":Email", $email);
    $stmt->bindParam(":Pwd", $pwd);
    $stmt->execute();
    $stmt->closeCursor();
  }

  public static function updateDetail(string $detail, string $detailToUpdate, int $ID): void {
    global $pdo;
    if ($detailToUpdate === 'Name') {
      $query = 'UPDATE students SET Name = :Detail WHERE ID = :ID;' ;
    }
    if ($detailToUpdate === 'Email') {
      $query = 'UPDATE students SET Email = :Detail WHERE ID = :ID;' ;
    }
    if ($detailToUpdate === 'Pwd') {
      $query = 'UPDATE students SET Pwd = :Detail WHERE ID = :ID;' ;
    }
    if ($detailToUpdate === 'Department') {
      $query = 'UPDATE students SET Department = :Detail WHERE ID = :ID;' ;
    }
    if ($detailToUpdate === 'gender') {
      $query = 'UPDATE students SET gender = :Detail WHERE ID = :ID;' ;
    }
    if ($detailToUpdate === 'Class') {
      $query = 'UPDATE students SET Class = :Detail WHERE ID = :ID;' ;
    }
    if ($detailToUpdate === 'Photo_Upload') {
      $query = 'UPDATE students SET Photo_Upload = :Detail WHERE ID = :ID;' ;
    }
    $stmt = $pdo->prepare($query);
    /* $stmt->bindValue(':getDetail', $detailToUpdate); */
    $stmt->bindValue(':Detail', $detail);
    $stmt->bindValue(':ID', $ID);
    $stmt->execute();
    $update = $stmt->fetch();
    $stmt->closeCursor();
  }
}
