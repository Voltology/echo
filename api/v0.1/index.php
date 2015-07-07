<?php
header("Content-type: application/json");
require("../../.local.inc.php");
$json['social'] = array();
$json['errors'] = array();
$json['result'] = "success";
//if ($_SERVER['REQUEST_METHOD'] === "POST") {
if ($_POST['Method'] === "GetData") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND creation > " . (time() - 43200) . " ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
  $query = sprintf("SELECT * FROM social WHERE type='instagram' && authorized='1'");
  $result = mysql_query($query);
  $json['instagram_count'] = mysql_num_rows($result);
  $query = sprintf("SELECT * FROM social WHERE type='twitter' && authorized='1'");
  $result = mysql_query($query);
  $json['twitter_count'] = mysql_num_rows($result);
} else if ($_POST['Method'] === "GetPhotobooth") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND type='photobooth' AND creation > " . (time() - 43200) . " ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
} else if ($_POST['Method'] === "GetPhotos") {
  $query = sprintf("SELECT * FROM social WHERE authorized='1' AND (type='instagram' OR type='photobooth') AND creation > " . (time() - 43200) . " ORDER BY creation DESC");
  $result = mysql_query($query);
  while ($row = mysql_fetch_assoc($result)) {
    array_push($json['social'], $row);
  }
}
echo json_encode($json);
?>
