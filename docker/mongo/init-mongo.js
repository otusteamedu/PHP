db.createUser(
    {
        user : "youtube",
        pwd : "password",
        roles : [
            {
                role: "readWrite",
                db: "youtube"
            }
        ]
    }
);
db.createCollection("youtube-channels");

// наполним тестовыми данными
db.getCollection("youtube-channels").insertMany(
    [
        {
            "title" : "Channel-1",
            "channelId" : "channel1",
            "videos" : [
                {
                    "title" : "Video-1",
                    "videoId" : "channel1/video1",
                    "likes" : NumberInt(10),
                    "dislikes" : NumberInt(2)
                }
            ]
        },
        {
            "title" : "Channel-2",
            "channelId" : "channel2",
            "videos" : [
                {
                    "title" : "Video-1",
                    "videoId" : "channel2/video1",
                    "likes" : NumberInt(15),
                    "dislikes" : NumberInt(35)
                },
                {
                    "title" : "Video-2",
                    "videoId" : "channel2/video2",
                    "likes" : NumberInt(35),
                    "dislikes" : NumberInt(5)
                }
            ]
        },
        {
            "title" : "Channel-3",
            "channelId" : "channel3.com",
            "videos" : [
                {
                    "title" : "Video-1",
                    "videoId" : "channel3/video1",
                    "likes" : NumberInt(7),
                    "dislikes" : NumberInt(17)
                },
                {
                    "title" : "Video-2",
                    "videoId" : "channel3/video2",
                    "likes" : NumberInt(66),
                    "dislikes" : NumberInt(35)
                },
                {
                    "title" : "Video-3",
                    "videoId" : "channel3/video3",
                    "likes" : NumberInt(100),
                    "dislikes" : NumberInt(10)
                }
            ]
        },
        {
            "title" : "Channel 4",
            "channelId" : "channel4",
            "videos" : [
                {
                    "title" : "Video 1",
                    "videoId" : "channel4/video1",
                    "likes" : NumberInt(1000),
                    "dislikes" : NumberInt(15)
                },
                {
                    "title" : "Video 2",
                    "videoId" : "channel4/video2",
                    "likes" : NumberInt(33),
                    "dislikes" : NumberInt(33)
                },
                {
                    "title" : "Video 3",
                    "videoId" : "channel4/video3",
                    "likes" : NumberInt(55),
                    "dislikes" : NumberInt(55)
                }
            ]
        },
        {
            "title" : "Channel 5",
            "channelId" : "channel5",
            "videos" : [
                {
                    "title" : "Video 1",
                    "videoId" : "channel5/video1",
                    "likes" : NumberInt(3),
                    "dislikes" : NumberInt(3)
                },
                {
                    "title" : "Video 2",
                    "videoId" : "channel5/video2",
                    "likes" : NumberInt(4),
                    "dislikes" : NumberInt(4)
                },
                {
                    "title" : "Video 3",
                    "videoId" : "channel5/video3",
                    "likes" : NumberInt(77),
                    "dislikes" : NumberInt(77)
                }
            ]
        }
    ]
);

// индекс для поиска каналов с видео
db.getCollection("youtube-channels").createIndex({"videos": 1});

// индекс для выборки лайков и дислайков
db.getCollection("youtube-channels").createIndex({"videos.likes": 1, "videos.dislikes": 1});