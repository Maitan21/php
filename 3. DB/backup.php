
<!doctype html>
<html lang="ko">
  <head>
  <meta charset="utf-8">
    <title>CheckBox Handler</title>
    <style>
      * {
        font-size: 16px;
        font-family: Consolas, sans-serif;
      }
    </style>
  </head>
  <body>
    <!-- Run PHP Script -->
    <?php
    
    if(!empty($_POST['chk'])) {
      // Counting number of checked checkboxes.
      $checked_count = count($_POST['chk']);
      // Loop to store and display values of individual checked checkbox.
      foreach($_POST['chk'] as $selected) {
          echo "<p>My Conutry is ".$selected ."</p>";
      }
    }
    else{
        echo "<b>Please Select Atleast One Option.</b>";
    }
    
   ?>
  </body>
</html>