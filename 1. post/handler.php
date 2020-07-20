<?php
  $name = $_POST['name'];
  $country = $_POST['country'];
?>

<!doctype html>
<html lang="ko">
  <head>
  <meta charset="utf-8">
    <title>HTML</title>
    <style>
      * {
        font-size: 16px;
        font-family: Consolas, sans-serif;
      }
    </style>
  </head>
  <body>
    <p>Name is <?php echo $name ?>.</p>
    <p>Your Country is <?php echo $country ?>.</p>
  </body>
</html>