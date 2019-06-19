<?php

namespace Otus;

class Informer
{
    public function getTopChannelsByRate(int $count = 3)
    {
//        db.getCollection('video').aggregate([
//            {"$group" :
//                {_id: "$channelId",
//                 likes: { "$sum": { "$toInt" : "$statistics.likeCount" } },
//                 dislikes: { "$sum": { "$toInt" : "$statistics.dislikeCount" } }
//                }
//            },
//            { "$addFields": {
//                "rate": { "$divide": [ "$likes", "$dislikes" ] },
//            } },
//            { $sort:
//                {
//                    rate : -1
//                }
//            }
//        ])
        return;
    }
}