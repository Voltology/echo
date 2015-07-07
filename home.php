<?php
require(".local.inc.php");
session_start();
?>
<html>
  <head>
    <title>#BMA15 Echo</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <style>
    body{
      font-family: "lucida grande",tahoma,verdana;
    }
    h3 {
      margin-top: 30px;
      text-align: center;
    }
    span{
      color:#cc0000;
    }
    div {
      word-wrap: break-word;
    }
    </style>
	</head>
	<body>
    <div>
    <h3>Thank you for authorizing the BMA app!  You can now post photos to the social wall with the #BMA14 hashtag!</h3>
    <?php
    if($_GET['id']=='logout') {
      unset($_SESSION['userdetails']);
      session_destroy();
    }

    if (!empty($_SESSION['userdetails'])) {
      $data = $_SESSION['userdetails'];
      $instagram->setAccessToken($data);
    }
    $query = sprintf("SELECT id FROM instagram_users WHERE instagram_id='%s' LIMIT 1",
      mysql_real_escape_string($data->user->id));
    $result = mysql_query($query);
    if (mysql_num_rows($result) === 0) {
      $query = sprintf("INSERT INTO instagram_users SET username='%s', name='%s', instagram_id='%s', instagram_access_token='%s'",
        mysql_real_escape_string($data->user->username),
        mysql_real_escape_string($data->user->full_name),
        mysql_real_escape_string($data->user->id),
        mysql_real_escape_string($data->access_token));
      mysql_query($query);
    }
    ?>
</body>
</html>
