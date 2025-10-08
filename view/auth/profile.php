<?php 
render('layout/header');   
  if (empty($userID)) {
    $error = 'Error connecting profile, Try again.';
    set_flash('login_error', $error);
    header('Location: ?page=auth&view=login');
    exit;
  }
  $photo = getUserKey('Photo_Upload', $userID);
  $name = getUserKey('Name', $userID);
  $dept = getUserKey('Department', $userID);
  $class = getUserKey('Class', $userID);
  $gender = getUserKey('Gender', $userID);
  $email = getUserKey('Email', $userID);
?>
<!-- //REMEMBER TO CHANGE TO MAIN -->
<section class="profile__hero">
  <figure class="profile__hero-figure">
    <img id="userProfileImg" src="uploads/<?= $photo ?>" alt="profilephoto" title="My profile picture" width="400" height="400">
    <figcaption class="center profile__hero-figcaption">
      <?= $name ?>
    </figcaption>    
  </figure>
  <div class="profile__hero-div">
    <p class="profile__hero-p">
      Lorem ipsum dolor sit amet consectetur adipisicing elit.Labore suscipit rem magnam ad enim aspernatur.
    </p>
  </div>
</section>

<main class="main profile__main">
  <div class="profile__form_holder">
    <?php
      $activeView = $_POST['view'] ?? '';
      if(empty($activeView)) {
        $activeView = $_GET['view'] ?? 'details';
      }
    ?>
    <form class="profile__form" action="" method="post">
      <input type="hidden" name="view" value="details">
      <button class="profile__form_btn <?= ($activeView === 'details') ? 'btn' : ''; ?>">Detials</button>
    </form> 
    <form class="profile__form" action="" method="post">
      <input type="hidden" name="view" value="skills">
      <button class="profile__form_btn <?= ($activeView === 'skills') ? 'btn' : ''; ?>">Skills</button>
    </form>    
  </div>

  <?php
    $view = filter_input(INPUT_POST, 'view', FILTER_SANITIZE_STRING);
    if (!$view) {
      $view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING);
      if (!$view) {
        $view = 'details';
      }
    }
    
    switch($view) {
      case 'details';
          render('profile/details', [
            'email' => $email,
            'class' => $class,
            'gender' => $gender,
            'dept' => $dept
          ]); 
        break;
      case 'skills';
        render('profile/skills');
        break;      
      default:
        $error = 'View not available';
        set_flash('error', $error);
        render('error');
        break;
        
    }
  ?>
</main>

<?php include('view/layout/footer.php'); ?>