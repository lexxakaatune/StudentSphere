<?php
  $userID = getUserSID();
  if (isset($userID)) {
    $photo = getUserKey('Photo_Upload', $userID);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Alex Casimia">
  <meta name="description" content="This is a blank website">
  <title>LEX B</title>
  <link rel="icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
  <?php if (isset($adminID)) {?>
    <link rel="stylesheet" href="assets/style/admin.css">
  <?php } else { ?>
    <link rel="stylesheet" href="assets/style/main.css">
  <?php } ?>
  <script src="assets/script/main.js" type="module"></script>
</head>

<body>
  <header class="header">
    <?php if (!empty($adminID)) { ?>
      <a class="none" href="?page=auth&action=admin&view=overviews">
        <h1 id="headerTitle">
          StudentSphere Admin
        </h1>
      </a>
    <?php } else { ?> 
      <a class="none" href=".">
        <h1 id="headerTitle">
          StudentSphere
        </h1>
      </a>
    <?php } ?> 
    

    <?php if (!empty($adminID) && ($_GET['action'] === 'admin')) { ?>
      <details>
        <summary></summary>
          <a href="?page=index" class="none">
            <small>Go to School</small>
          </a>
      </details>
    <?php } ?>

    <?php if (!empty($adminID)) { ?>
      <nav id="headerNav" class="header__nav hidden">
        <ul class="header__ul none">
          <li class="profile__li header__li">
            <a href="?page=auth&action=admin">
              <figure class="Profile__figure">
                <img src="assets/images/woman.jpg">
              </figure>
            </a>
          </li>
          <li class="nav-note">Main Menu</li>
          <?php $links = [
              'overviews' => 'Overview',
              'students' => 'Student'
            ];
          foreach ($links as $key => $label) { ?>
            <li class='header__li'>
              <a class='none header__li_a' href='?page=auth&action=admin&view=<?=$key?>'>
                <?= $label ?>
              </a>
            </li>
          <?php } ?>  

          <li class="nav-note">Others</li>

          <?php $links = [
              'settings' => 'Settings'
            ];
          foreach ($links as $key => $label) { ?>
            <li class='header__li'>
              <a class='none header__li_a' href='?page=auth&action=admin&view=<?= $key ?>'>
                <?= $label ?>
              </a>
            </li>            
          <?php } ?>
        </ul>
      </nav>

    <?php } else if (!empty($userID)) { ?>
      <nav id="headerNav" class="header__nav hidden">
        <ul class="header__ul none">
          <li class="profile__li header__li">
            <a href="?page=auth&action=profile&view=details">
              <figure class="Profile__figure">
                <img src="uploads/<?= $photo; ?>">
              </figure>
            </a>
          </li>
          <?php $links = [
              'about' => 'About',
              'contact' => 'Contact'
            ];
          foreach ($links as $key => $label) { ?>
            <li class='header__li'>
              <a class='none header__li_a' href='?page=<?=$key?>'>
                <?= $label ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
    <?php } ?>

    <?php if (!empty($userID) || !empty($adminID)) { ?>
        <button id="headerButton" class="header__button btn">Menu</button>
    <?php } else { ?>
      <a class="link-btn nowrap" href="?page=auth&view=signup">Sign Up/In</a>
    <?php } ?>
  </header>