<?php
require(".local.inc.php");
require_once("lib/TwitterAPIExchange.php");

$settings = array(
  "oauth_access_token" => "16475539-ND76Lpgrx6Uas6mwMkyoKPfK6pqI2GGZ9XurXWX1A",
  "oauth_access_token_secret" => "vWsJqp37auhBwOU1L3gYpL3AleTRiMjO523gZQd4n9W3o",
  "consumer_key" => "4Mmg1lKaqcBC3Tcvhd9ggI2lu",
  "consumer_secret" => "MntZAPeR1oYfBorJaSG3Kbl6XXkTuIppWXUTVY0RqGghQvgfFW"
);
$instagram_token = "179022600.99ddb8b.82c83ec82fc14624a89de354f3048378";

$tags = ["bma15"];

foreach ($tags as $tag) {
  $url = "https://api.twitter.com/1.1/search/tweets.json";
  $getfield = "?q=#" . $tag . "&result_type=recent";
  $requestMethod = "GET";
  $twitter = new TwitterAPIExchange($settings);
  $tweets = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(), true);
  foreach ($tweets['statuses'] as $tweet) {
    $query = sprintf("SELECT id FROM social WHERE post_id='%s' LIMIT 1",
      mysql_real_escape_string($tweet['id']));
    $result = mysql_query($query);
    if (mysql_num_rows($result) === 0) {
      $query = sprintf("INSERT INTO social SET post_id='%s', type='twitter', `text`='%s', username='%s', full_name='%s', profile_image='%s', post_date='%s', authorized='0', creation='%s'",
        mysql_real_escape_string($tweet['id']),
        mysql_real_escape_string($tweet['text']),
        mysql_real_escape_string($tweet['user']['screen_name']),
        mysql_real_escape_string($tweet['user']['name']),
        mysql_real_escape_string($tweet['user']['profile_image_url']),
        mysql_real_escape_string($tweet['created_at']),
        mysql_real_escape_string(time()));
      mysql_query($query);
    }
  }

  $data = json_decode(file_get_contents("https://api.instagram.com/v1/tags/" . $tag . "/media/recent?access_token=" . $instagram_token), true);
  foreach ($data['data'] as $post) {
    $query = sprintf("SELECT id FROM social WHERE post_id='%s' LIMIT 1",
      mysql_real_escape_string($post['id']));
    $result = mysql_query($query);
    if (mysql_num_rows($result) === 0) {
      $query = sprintf("INSERT INTO social SET post_id='%s', type='instagram', `text`='%s', username='%s', full_name='%s', profile_image='%s', post_date='%s', authorized='0', creation='%s'",
        mysql_real_escape_string($post['id']),
        mysql_real_escape_string($post['images']['standard_resolution']['url']),
        mysql_real_escape_string($post['user']['username']),
        mysql_real_escape_string($post['user']['full_name']),
        mysql_real_escape_string($post['user']['profile_picture']),
        mysql_real_escape_string($post['caption']['created_time']),
        mysql_real_escape_string(time()));
      mysql_query($query);
    }
  }
}
?>
