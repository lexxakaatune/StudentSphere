
<?php
  $AdminModel = new AdminModel();
  $allStudent = $AdminModel->getAllStudent();
?>
<main class="main student__main">
  <h2 class="h2 center">Active Students in StudentSphere</h2>
  <table class="student__table">    
    <thead class="student__thead">
      <th class="student__th">Picture</th>
      <th class="student__th">Name</th>
      <th class="student__th">Email</th>
      <th class="student__th">Department</th>
      <th class="student__th">Gender</th>
      <th class="student__th">Class</th>
      <th class="student__th">Update</th>
      <th class="student__th">Delete</th>
    </thead>
    <tbody class="student__tbody">
      <?php foreach($allStudent as $student) { ?> 
        <tr class="student__tr">
          <td class="student__td"> 
            <img class="student__img" src="uploads/<?=$student['Photo_Upload']?>" alt="student image">
          </td>
          <td class="student__td"> <?=$student['Name']?> </td>
          <td class="student__td"> <?=$student['Email']?> </td>
          <td class="student__td"> <?=$student['Department']?> </td>
          <td class="student__td"> <?=$student['gender']?> </td>
          <td class="student__td"> <?=$student['Class']?> </td>
          <td class="student__td">
            <button class="adminUpdateBtn btn center">update</button>
          </td>
          <td class="student__td"> 
            <form action="?page=auth&action=deleteDetails" method="POST">
              <input type="hidden" name="email" value="<?=$student['Email']?>">
              <input type="hidden" name="password" value="<?=$student['Pwd']?>">
              <button class="btn center">delete</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>   
  </table>
  <section id="adminUpdateSection" class="update__section hidden" >    
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
    <p class="center sign-error"><?=get_flash('updateErr');?></p>
  </section>
</section>
</main>