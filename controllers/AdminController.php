<?php 
declare(strict_types=1);

class AdminController {
  public function index(): void {
    require('config/config.php');

    if (isset($_SESSION['flash']['admin-id'])) {
      $adminID = $_SESSION['flash']['admin-id'];      
      render('auth/admin');
      exit;
    } else {
      $error = 'error login admin page. AdminController';
      set_flash('adminErr', $error);
      header('Location: ?page=auth&view=admin');
    }
  }  
}