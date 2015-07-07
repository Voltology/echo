<?php
require(".local.inc.php");
session_start();
if (!empty($_SESSION['userdetails'])) {
  header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <style type="text/css">
      * {
        margin: 0px;
        padding: 0px;
      }
      body{
        font-family: "lucida grande",tahoma,verdana;
      }
      h2 {
        margin-top: 30px;
        text-align: center;
      }
      a.button {
        background: url(img/instagram-login-button.png) no-repeat transparent;
        cursor: pointer;
        display: block;
        height: 29px;
        margin: 50px auto;
        overflow: hidden;
        text-indent: -9999px;
        width: 200px;
      }
      a.button:hover {
        background-position: 0 -29px;
      }
    </style>
  </head>
  <body>
    <h2>#BMA15 Echo</h2>
    <?php
    $loginUrl = $instagram->getLoginUrl();
    echo "<a class=\"button\" href=\"$loginUrl\">Sign in with Instagram</a>";
    ?>
  </body>
</html>
