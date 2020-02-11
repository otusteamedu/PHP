<?php
    $resultCreateIndexIdChannelTitle = $channelsCollection->createIndex(['id' => 1]);
    $resultCreateIndexIdChannelTitle = $channelsCollection->createIndex(['title' => 1]);
    $resultCreateIndexIdChannelTitle = $channelsCollection->createIndex(['videoIds' => 1]);

    $resultCreateIndexId = $videosCollection->createIndex(['id' => 1]);
    $resultCreateIndexChannelId = $videosCollection->createIndex(['channelId' => 1]);
    $resultCreateIndexIdTitle = $videosCollection->createIndex(['title' => 1]);
    $resultCreateIndexIdChannelTitle = $videosCollection->createIndex(['channelTitle' => 1]);
