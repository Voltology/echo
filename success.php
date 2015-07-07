<?php
require(".local.inc.php");

$code = $_GET['code'];
if (true === isset($code)) {
  $data = $instagram->getOAuthToken($code);
  if(empty($data->user->username)) {
    header('Location: index.php');
  } else {
    session_start();
    $_SESSION['userdetails']=$data;
    $user=$data->user->username;
    $fullname=$data->user->full_name;
    $bio=$data->user->bio;
    $website=$data->user->website;
    $id=$data->user->id;
    $token=$data->access_token;
    echo $token;

//    $id=mysql_query("select instagram_id from users where instagram_id='$id'");

 //   if(mysql_num_rows($id) == 0) { 
 //     mysql_query("insert into users(username,name,bio,website,instagram_id,instagram_access_token) values('$user','$fullname','$bio','$website',$id,'$token')");
 //   }
    header('Location: home.php');
  }
} else {
  if (true === isset($_GET['error'])) {
      echo 'An error occurred: '.$_GET['error_description'];
  }
}

?>
