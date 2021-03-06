<?php
header('Content-Type: application/json');
$id = htmlspecialchars($_POST["id"]);
$name = htmlspecialchars($_POST["name"]);

// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Content-Type: text/html; charset=utf-8\r\n"
  )
);

$context = stream_context_create($opts);
if (!$id || $id == '') {
  $id_json = file_get_contents('https://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=DAE8411586FA4F067901D996D587E20A&vanityurl='.$name, false, $context);
  $id = json_decode($id_json)->response->steamid;
}

$steam_json = file_get_contents('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=DAE8411586FA4F067901D996D587E20A&steamids='.$id, false, $context);
$steam_data = json_decode($steam_json)->response->players[0];

echo json_encode($steam_data);
//echo $steam_json;
?>
