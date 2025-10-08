<?php 
declare(strict_types=1);

class AuthController {
  public function index(): void {
    require('config/config.php');
    /* if ($_SESSION['flash']['signup_error']) {
      $signupErr = get_flash('signup_error');
    } else if ($_SESSION['flash']['login_error']) {
      $loginErr = get_flash('login_error');
    } else {
      $signupErr = '';
      $loginErr = '';
    } */
    render('auth/sign');
  }

  public function signup(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
      $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
      $pwd = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
      $department = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING));
      $gender = trim(filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING));
      $class = trim(filter_input(INPUT_POST, 'class', FILTER_SANITIZE_STRING));
      $photo = $_FILES["photo"];
      
      try {

        // ERROR HANDLERS
        $user = UserModel::getUser($email);
        if (empty($name) || empty($email) || empty($pwd) || empty($department) || empty($gender) || empty($class)) {
          $error = "Fill in all fields!";
          set_flash('error', $error);
          header('Location: ?page=auth');
          exit;
        } 
        if (!filter_var( $email, FILTER_VALIDATE_EMAIL)) {
          $error = "The email you enter is incorrect!";
          set_flash('error', $error);
          header('Location: ?page=auth');
          exit;
        }        
        if (!empty($user)) {
          $error = "Email already registered!";
          set_flash('login_error', $error);
          header('Location: ?page=auth&view=login');
          exit;
        }
        if (strlen($pwd) < 8) {
          $error = "Password should be more than eight!";
          set_flash('error', $error);
          header('Location: ?page=auth');
          exit;
        }
        // Handle photo upload errors
        $photoFilename = null;      
        if (isset($photo) && $photo['error'] === UPLOAD_ERR_OK) {
          // Size check (2MB max)
          if ($photo['size'] > 2 * 1024 * 1024) {
            $error = 'Photo exceeds 2 MB limit.';
            set_flash('error', $error);
            exit;
          }
          //mime check
          $finfo = new finfo(FILEINFO_MIME_TYPE);
          $mimeType = $finfo->file($photo['tmp_name']);
          $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
          if (!array_key_exists($mimeType, $allowed)) {
            $error = 'Only JPEG or PNG images allowed.';
            set_flash('error', $error);
            exit;
          }
          // Generate filename
          $origName = pathinfo($photo['name'], PATHINFO_FILENAME);
          $safeBase =  preg_replace("/[^A-Za-z0-9_-]/", '', $origName);
          $ext = $allowed[$mimeType];
          $photoFilename = sprintf('%s_%s.%s', $safeBase, bin2hex(random_bytes(4)), $ext);
          // Move file to folder
          $destination = __DIR__ . '/../uploads/' . $photoFilename;
          
          if (!move_uploaded_file($photo['tmp_name'], $destination)) {
            $error = 'Failed to save uploaded photo.';
            set_flash('error', $error);
            exit;
          }
        }

        // Create User
        if (empty($user)) {
          $userCreated = UserModel::createUser($name, $email, $pwd, $department, $gender, $class, $photoFilename);
        }        
        if (!empty($userCreated)) {
          session_regenerate_id(true);
          header('Location: ?page=auth&view=login');
          exit;
        } else {
          $error = 'Failed to create user';
          set_flash('error', $error);
          header('Location: ?page=auth&view=signup');
          exit;
        }
      } catch (PDOException $e) {
        die("Query failed to register: " . $e->getMessage());        
      } 
    } else {
      header('Location: ?page=auth&view=signup');
      exit;
    }
  }

  public function login(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
      $pwd = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

      try {
        require('config/config.php');
        // ERROR HANDLERS
          //if password !empty email and password ...  
          if (!empty($email) && !empty($pwd)) {
            $userPwd = UserModel::getUserPwd($email);
            //if email is is incorrect
            if (!empty($userPwd)) {
              $pwdPass = password_verify($pwd, $userPwd);
            } else {
              $error = 'Incorrect email!';
              set_flash('login_error', $error);
              header('Location: ?page=auth&view=login');
              exit;
            }
            //if password incorrect          
            if (!empty($pwdPass)) { 
              $userID = UserModel::getUserId($email);
              set_flash('user-id', $userID);
              header('Location: ?page=profile&view=details');
              exit;
            } else {
              $error = 'Enter a correct password!';
              set_flash('login_error', $error);
              header('Location: ?page=auth&view=login');
              exit;
            }
          } else {
            $error = "Fill in all fields!";
            set_flash('login_error', $error);
            header('Location: ?page=auth&view=login');
            exit;
          }
      } catch (PDOException $e) {

        die("Query failed: " . $e->getMessage());
      }
    } else {
      header('Location: ?page=auth&view=login');
    }
  }

  public function updateDetails(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $detailToUpdate = filter_input(INPUT_POST, 'detail2', FILTER_SANITIZE_STRING);
      if ($detailToUpdate === 'Email') {
        $getDetail = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_EMAIL);
      }  else {
        $getDetail = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_STRING);
      } 
      $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);

      try {
        $userID = $_SESSION['flash']['user-id'];
        $user = UserModel::getUser($userID);
        if (!empty($user)) {
          $email = $user['Email'];
          $dbPwd  = UserModel::getUserPwd($email);
          $passPwd = password_verify($pwd, $dbPwd);
        }
        if ($passPwd) {
          $updated = UserModel::updateDetail($getDetail, $detailToUpdate, $userID);
          $success = 'successfully updated';
          set_flash('success', $success);
          header('Location: ?page=profile');
          exit;
        } else {
          $error = 'Wrong Password';
          set_flash('updateErr', $error);
          header('Location: ?page=profile');
          exit;
        }
      } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
      }
    } else {
      $error = 'error Updating user. Try again';
      set_flash('updateErr', $error);
      header('Location: ?page=profile');
      exit;
    }
  }

  public function deleteDetails(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

      try {
        require('config/config.php');        
        $dBPwd  = UserModel::getUserPwd($email);
        if (isset($_SESSION['flash']['user-id'])) {
          $passPwd = password_verify($pwd, $dBPwd);
          if (!empty($passPwd)) {
            UserModel::deleteUser($email, $dBPwd); 
            get_flash('user-id');
            header('Location: ?page=index');
            exit;
          } else {
            set_flash('updateErr', 'Invalid password');
            header('Location: ?page=profile');
            exit;
          }          
        } else if (isset($_SESSION['flash']['admin-id'])) {
          UserModel::deleteUser($email, $dBPwd);
          header("Location: ?page=admin&view=students");
          exit;
        } 
      } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
      }
    } else {
      $error = "This is not a 'POST' method. use secure means";
      set_flash('updateErr', $error);
      header('Location: ?page=error');
      exit;
    }
  }

  public function logout(): void {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ?page=auth&view=signup");
    exit;
  }

  public function signup_admin(): void {
    require('config/config.php');
    $userName = 'LexKaatune';
    $pwd = 'alexadminpass';
    $hash = password_hash($pwd,PASSWORD_DEFAULT);
    if ($hash) {
      AdminModel::insert_admin($userName, $hash);
      header('Location: ?page=auth&view=admin');
      exit;
    }
  }

  public function admin_login(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $adminUsername = filter_input(INPUT_POST, 'admin_username', FILTER_SANITIZE_STRING);
      $pwd = filter_input(INPUT_POST, 'admin_password', FILTER_SANITIZE_STRING);

      try {
        require('config/config.php');
        $record = AdminModel::getAdmin($adminUsername);

        if (!empty($record)) {
          //verify password 
          $pass = password_verify($pwd, $record['Pwd']);
          if ($pass) {
            //set session
            set_flash('admin-id', $record['ID']);
            header("Location: ?page=admin&view=overviews");
            exit;
          } else {
            $error = 'Wrong Password';
            set_flash('adminErr', $error);
            header("Location: ?page=auth&view=admin");
            exit;
          } 
        }  else {
          $error = 'Wrong Username';
          set_flash('adminErr', $error);
          header("Location: ?page=auth&view=admin");
          exit;
        }
      } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
      }
    } else {
      header("Location: ?page=auth&view=admin");
      exit;
    }
  }  
}