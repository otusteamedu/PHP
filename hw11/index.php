<?php

require_once('./config/bootstrap.php');

try {
    runApplication();
} catch (\Exception $e) {
    var_dump('Exception caught at index.php:' . $e->getMessage());
}
//        $tmp = $this->client->channels->listChannels('id,contentDetails,snippet,statistics', array('id' => $id));

//      $client = new Google\Client();
//      $client->setApplicationName("OTUS youtube spider");
//      $client->setDeveloperKey("AIzaSyAQ4_Vq1g-KgfZiuTlEEJk8JNctQklh-NA");
//
//      $service = new Google_Service_YouTube($client);

//$searchResponse = $service->channels->listChannels('id,contentDetails,snippet,statistics', array('id' => 'UCetgtvy93o3i3CvyGXKFU3g'));

//$searchResponse = $service->videos->listVideos('id,contentDetails,statistics', array('id' => 'UCetgtvy93o3i3CvyGXKFU3g'));

//var_dump($searchResponse); exit();
/*
  try {



//    var_dump(); exit();
      $searchResponse = $service->channels->listChannels('id,contentDetails,snippet,statistics', array('id' => 'UCetgtvy93o3i3CvyGXKFU3g'));
//        $searchResponse = $service->search->listSearch('id,snippet', array(
   //       'q' => '17 мгновений весны',
 //         'maxResults' => 10,
   //   ));

      $htmlBody = '';
      $videos = '';
      $channels = '';
      $playlists = '';

      var_dump($searchResponse['items'][0]->statistics->viewCount); exit();

      // Add each result to the appropriate list, and then display the lists of
      // matching videos, channels, and playlists.
      foreach ($searchResponse['items'] as $searchResult) {
          switch ($searchResult['id']['kind']) {
              case 'youtube#video':
                  $videos .= sprintf('<li>%s (%s)</li>',
                      $searchResult['snippet']['title'], $searchResult['id']['videoId']);
                  break;
              case 'youtube#channel':
                  $channels .= sprintf('<li>%s (%s)</li>',
                      $searchResult['snippet']['title'], $searchResult['id']['channelId']);
                  break;
              case 'youtube#playlist':
                  $playlists .= sprintf('<li>%s (%s)</li>',
                      $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
                  break;
          }
      }

//        var_dump($videos); exit();

      $htmlBody .= <<<END
  <h3>Videos</h3>
  <ul>$videos</ul>
  <h3>Channels</h3>
  <ul>$channels</ul>
  <h3>Playlists</h3>
  <ul>$playlists</ul>
END;

      echo $htmlBody;
  }
   catch (Google_Service_Exception $e) {
  $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
} catch (Google_Exception $e) {
  $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
}


} catch (Exception $e) {
  echo $e->getMessage();


}
*/
