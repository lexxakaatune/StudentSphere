<?php
declare(strict_types=1);
require('config/config.php');
require('includes/flash.php');
require('includes/view.php');

$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_STRING); 
if (!$page) {
  $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
  if (!$page) {
    $page = 'index';
  }
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if (empty($action)) {
  $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?: 'index';
}

//ROUTE TO APPROPRIATE CONTROLLER OR VIEW
switch($page) {
  case 'error';
    render('error');
    break;

  case 'sign_admin';
    $admn = new AuthController();
    $admn->signup_admin();
    break;

  case 'auth';
    $ctrl = new AuthController();
    $ctrl->{$action}();
    break;

  case 'admin';
    $ctrl = new AdminController();
    $ctrl->{$action}(); 
    break;

  case 'profile';
    render('auth/profile', [
      'userID' => getUserSID()
    ]);
    break;

  default:
    $ctrl = new PageController();
    $ctrl->{$page}();
    break;
}