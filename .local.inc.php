<?php
require("lib/Instagram.class.php");

$instagram = new Instagram(array(
  'apiKey'      => '99ddb8bb3b3646e399a1d5b512d5d4e1',
  'apiSecret'   => 'cb38d7fdd96a4899a2c45d2fcf9a1f9e',
  'apiCallback' => 'http://localhost/bma-social/echo/success.php'
));

$link = mysql_connect("localhost", "root", "IVqIc7wciAqX") or die("Could not connect to server.");
mysql_select_db("bma", $link) or die("Could not select database.");
?>
