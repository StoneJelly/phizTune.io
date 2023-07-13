<?php
$searchTerm = $_GET["term"];

// Build the YouTube API request URL
$apiKey = "AIzaSyAeHqeZ4Su0q8JmlzUphGdwoI6H6tqRbMo";
$maxResults = 10;
$requestUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . urlencode($searchTerm) . "&maxResults=" . $maxResults . "&key=" . $apiKey;

// Make the request to the YouTube API
$response = file_get_contents($requestUrl);
$data = json_decode($response, true);

$results = [];
foreach ($data["items"] as $item) {
  $videoId = $item["id"]["videoId"];
  $title = $item["snippet"]["title"];
  $thumbnail = $item["snippet"]["thumbnails"]["high"]["url"];

  $results[] = [
    "videoId" => $videoId,
    "title" => $title,
    "thumbnail" => $thumbnail
  ];
}

header("Content-Type: application/json");
echo json_encode($results);
?>
