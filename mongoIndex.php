<?php


  $resultCreateIndexId = $youtubeVideoCollection->createIndex(['id' => 1]);
  $resultCreateIndexChannelId = $youtubeVideoCollection->createIndex(['channelId' => 1]);
  $resultCreateIndexIdTitle = $youtubeVideoCollection->createIndex(['title' => 1]);
  $resultCreateIndexIdChannelTitle = $youtubeVideoCollection->createIndex(['channelTitle' => 1]);

  $resultCreateIndexIdChannelTitle = $collectionYoutubeChannel->createIndex(['id' => 1]);
  $resultCreateIndexIdChannelTitle = $collectionYoutubeChannel->createIndex(['title' => 1]);
  $resultCreateIndexIdChannelTitle = $collectionYoutubeChannel->createIndex(['videoId' => 1]);

