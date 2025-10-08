<section id="profileTable" class="profile-details__section">
  <table class="profile__table">
    <tr class="profile__hero-tr">
      <th class="profile__hero-th">Email:</th>
      <td class="profile__hero-td"><?= $email ?></td>
    </tr>
    <tr class="profile__hero-tr">
      <th class="profile__hero-th">Class:</th>
      <td class="profile__hero-td"><?= $class ?></td>
    </tr>
    <tr class="profile__hero-tr">
      <th class="profile__hero-th">Gender:</th>
      <td class="profile__hero-td"><?= $gender ?></td>
    </tr>
    <tr class="profile__hero-tr">
      <th class="profile__hero-th">Department:</th>
      <td class="profile__hero-td"><?= $dept ?></td>
    </tr>
    <tr class="profile__hero-tr center">
      <td>
        <button id="updateBtn" class="btn">update</button>
      </td>
      <td>
        <button id="deleteBtn" class="btn">delete</button>
      </td>
    </tr>
  </table>

  <form id="deleteForm" action="?page=auth" class="delete__form hidden" method="post">
    <input type="hidden" name="action" value="deleteDetails">
    <input type="hidden" name="email" value="<?= $user['Email'] ?>">
    <input type="password" name="password" placeholder="Enter your password">
    <button class="btn center">delete</button>
  </form>

  <section id="updateSection" class="update__section hidden" >    
    <?php
      $userInfo = ['Email', 'Class', 'gender', 'Department'];
      foreach ($userInfo as $info) { ?>
      <form class="update__form" action="?page=auth&action=updateDetails" method='POST'>
        <details>
          <summary><label for="<?=$info?>"><?=$info?></label></summary>
           <input type="hidden" name="detail2" value="<?=$info?>">
           <input type="<?=($info === 'Email') ? 'email': 'text'?>" id="<?=$info?>" name="detail" placeholder="<?=$info?>" required>
           <label class="offscreen" for="verifyPassword<?=$info?>">Update Password</label>
           <input type="password" id="verifyPassword<?=$info?>" name="pwd" placeholder="Password" required>
           <button class="btn center">update</button>
        </details>
      </form>       
    <?php } ?> 
    <p class="center sign-success"><?=get_flash('success');?></p> 
    <p class="center sign-error"><?=get_flash('error');?></p> 
    <p class="center"><?=get_flash('db');?></p> 
  </section>

  <p class="profile-details__p center">
    <a class="none btn block center" style="max-width: 50%" href="?page=auth&action=logout">Logout</a>
  </p>
</section>