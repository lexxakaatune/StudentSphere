<?php 
  if (empty($adminID)) {
    $error = 'Error loading admin page';
    set_flash('adminErr', $error);
    header('Location: ?page=auth&view=admin');
    exit();
  }
render('layout/header', ['adminID' => $adminID]);

  $view = filter_input(INPUT_POST, 'view', FILTER_SANITIZE_STRING);
  if (empty($view)) {
    $view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING);
    if (empty($view)) {
      $view = 'overviews';
    }
  }

  switch($view) {
    case 'overviews';
      include('view/admin/overviews.php');
      break;

    case 'students';
      include('view/admin/students.php');
      break;

    case 'settings';
      include('view/admin/settings.php');
      break;
    default:
      $error = 'admin view not available';
      set_flash('error', $error);
      include('view/error.php');
      break;
  }

render('layout/footer');
