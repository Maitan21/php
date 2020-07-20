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
      <!-- post 전송 -->
    <form method="post" action="handler.php"> 
      <p><label>Name : <input type="text" name="name"></label></p>
      <p><label>Country : <input type="text" name="country"></label></p>
      <p><input type="submit" value="Submit"></p>
    </form>
  </body>
</html>