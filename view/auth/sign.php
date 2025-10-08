<?php require('config/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Studentsphere sign page</title>
  <link rel="stylesheet" href="assets/style/sign.css">
  <script src="assets/script/sign.js" type="module"></script>
</head>
<body>

<section id="signupSection" class="sign visible">
  <form class="center" method="get">
    <input type="hidden" name="page" value="auth">
    <input type="hidden" name="view" value="admin">
    <p>Admins only click <button class="btn">HERE</button></p>
  </form>
  <h2 class="signup__h2">Register To SchoolSphere</h2>

  <form class="signup__form" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="page" value="auth">
    <input type="hidden" name="action" value="signup">
    <fieldset class="signup__fieldset">
      <legend class="signup__legend">Enter Your Personal Informations</legend>
      <p class="signup__p">
        <label class="offscreen" for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Name" required autofocus>
      </p>

      <p class="signup__p">
        <label class="offscreen" for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required>
      </p>

      <p class="signup__p">
        <label class="offscreen" for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" autocomplete="off" required>
      </p>

      <p class="signup__p">
        <label class="offscreen" for="department">Department</label>
        <input type="text" id="department" name="department" placeholder="Department" required>
      </p>

      <fieldset class="signup__fieldset-inna">
        <div class="signup__div">
          <label class="signup__label" for="gender">Gender</label>
          <select name="gender" id="gender">
            <option value="male">male</option>
            <option value="female">female</option>
          </select>
        </div>

        <div class="signup__div">
          <label class="signup__label" for="class">Class</label>
          <input type="text" id="class" name="class" required>
        </div>
    </fieldset>

    <p class="signup__p">
      <label class="signup__label" for="profilePhoto">Upload Your Photo</label>
      <input type="file" id="profilePhoto" name="photo" required>
    </p>

    <p class="link-switch">
      Already have an account <a href="?page=auth&view=login">Login</a>&quest;
    </p>

    <p class="signup__P center" name="signup_msg" id="Message">
      <span class="sign-error"> <?= get_flash('signup_error'); ?> </span>
    </p>
    <button class="signup__button btn">Register</button>
  </form>
</section>

<section id="loginSection" class="sign hidden">
  <form class="center" method="get">
    <input type="hidden" name="page" value="auth">
    <input type="hidden" name="view" value="admin">
    <p>Admins only click <button class="btn">HERE</button></p>
  </form>
  <h2  class="login__h2">Welcome Back</h2>
  <form class="login__form" action="?page=auth" method="post">
    <input type="hidden" name="action" value="login">
    <fieldset class="login__fieldset">
      <legend class="login__legend">
        Login With Your Personal Informations
      </legend>  
      <p class="login__p">
        <label class="offscreen" for="email2">Email</label>
        <input type="email" id="email2" name="email" placeholder="Email" required>
      </p>
      <p class="login__p">
        <label class="offscreen" for="password2">Password</label>
        <input type="password" id="password2" name="password" placeholder="Password" required autocomplete="off">
      </p>
    </fieldset>
    <p class="link-switch">
      Don't have an account <a href="?page=auth&view=signup">Register</a> now.
    </p>
    <p class="login__P center" id="Message">
      <span class="sign-error"> <?= get_flash('login_error'); ?> </span>
    </p> 
  <button class="login__button btn">Log in</button>
  </form>
</section>

<section id="adminLoginSection" class="sign hidden">
  <h2 class="login__h2">Admin Engine</h2>

  <form class="login__form" action="?page=auth" method="post">
    <input type="hidden" name="action" value="admin_login">
    <fieldset class="login__fieldset">
      <legend class="login__legend">
        Login to Your Admin Panel
      </legend>  
      <p class="login__p">
        <label class="offscreen" for="adminUsername">Username</label>
        <input type="text" id="adminUsername" name="admin_username" placeholder="Enter username" required>
      </p>

      <p class="login__p">
        <label class="offscreen" for="adminPassword">Password</label>
        <input type="password" id="adminPassword" name="admin_password" placeholder="Enter password" required autocomplete="off">
      </p>
    </fieldset>

    <p class="link-switch">
      Not an admin <a href="?page=auth&view=login">Login</a> as student.
    </p>

    <p class="login__P center" id="Message">
      <span class="sign-error"> <?= get_flash('adminErr'); ?> </span>
    </p>

  <button class="login__button btn">Log in</button>
  </form>
</section>

</body>
</html>