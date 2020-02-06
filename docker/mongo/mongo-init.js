db.auth("root", "password");
db.createCollection("youtube-channels");

// наполним данными
db.getCollection("youtube-channels").insertMany(
    [
        {
            "title" : "Channel 1",
            "url" : "https://channel1.com",
            "videos" : [
                {
                    "title" : "Video 1",
                    "url" : "https://channel1.com/video1",
                    "likes" : NumberInt(10),
                    "dislikes" : NumberInt(5)
                }
            ]
        },
        {
            "title" : "Channel 2",
            "url" : "https://channel2.com",
            "videos" : [
                {
                    "title" : "Video 1",
                    "url" : "https://channel2.com/video1",
                    "likes" : NumberInt(9),
                    "dislikes" : NumberInt(8)
                }
            ]
        },
        {
            "title" : "Channel 3",
            "url" : "https://channel3.com",
            "videos" : [
                {
                    "title" : "Video 1",
                    "url" : "https://channel3.com/video1",
                    "likes" : NumberInt(8),
                    "dislikes" : NumberInt(18)
                },
                {
                    "title" : "Video 2",
                    "url" : "https://channel3.com/video2",
                    "likes" : NumberInt(6),
                    "dislikes" : NumberInt(2)
                },
                {
                    "title" : "Video 3",
                    "url" : "https://channel3.com/video3",
                    "likes" : NumberInt(20),
                    "dislikes" : NumberInt(15)
                }
            ]
        },
        {
            "title" : "Channel 4",
            "url" : "https://channel4.com",
            "videos" : [
                {
                    "title" : "Video 1",
                    "url" : "https://channel4.com/video1",
                    "likes" : NumberInt(10),
                    "dislikes" : NumberInt(11)
                },
                {
                    "title" : "Video 2",
                    "url" : "https://channel4.com/video2",
                    "likes" : NumberInt(5),
                    "dislikes" : NumberInt(5)
                },
                {
                    "title" : "Video 3",
                    "url" : "https://channel4.com/video3",
                    "likes" : NumberInt(15),
                    "dislikes" : NumberInt(10)
                }
            ]
        },
        {
            "title" : "Channel 5",
            "url" : "https://channel5.com",
            "videos" : [
                {
                    "title" : "Video 1",
                    "url" : "https://channel5.com/video1",
                    "likes" : NumberInt(15),
                    "dislikes" : NumberInt(1)
                },
                {
                    "title" : "Video 2",
                    "url" : "https://channel5.com/video2",
                    "likes" : NumberInt(55),
                    "dislikes" : NumberInt(55)
                },
                {
                    "title" : "Video 3",
                    "url" : "https://channel5.com/video3",
                    "likes" : NumberInt(1),
                    "dislikes" : NumberInt(1)
                }
            ]
        }
    ]
);

// индексы
db.getCollection("youtube-channels").createIndex({"videos": 1});
// поможет найти каналы, у которых вообще есть видео
// например, db.getCollection("youtube-channels").find( { "videos": { $size: 1 } } );
// или db.getCollection("youtube-channels").find( { $where: "this.videos.length > 2" } );

db.getCollection("youtube-channels").createIndex({"videos.likes": 1, "videos.dislikes": 1});
// поможет найти каналы, видео которых имеют указанное количество лайков и(или) дизлайков
// например, db.getCollection("youtube-channels").find( { "videos.likes": { $gt: 1000 }, "videos.dislikes": { $lt: 100 } } );
