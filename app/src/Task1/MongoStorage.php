<?php
namespace Otus\HW11\Task1;

use MongoDB\Exception\Exception;
use MongoDB\Exception\InvalidArgumentException;
use Otus\HW11\Config;
use \Otus\HW11\Task1;

class MongoStorage implements Task1\IStorage, Task1\IStatistics
{
    protected $client;

    protected $db;

    public function __construct()
    {
        $this->client = new \MongoDB\Client(Config::get('mongo')['scheme'] . '://' . Config::get('mongo')['host'] . ':'. Config::get('mongo')['port']);
        $this->db = $this->client->selectDatabase('hw11');
    }


    public function init()
    {
        $this->client->dropDatabase('hw11');

        $channels = $this->db->selectCollection('channels');

        /** Insert init data */
        $channels->insertMany([
            [
                'name' => 'ПостНаука',
                'url' => 'https://www.youtube.com/user/postnauka/',
                'subscribers' => '603000',
                'videos' => [
                    [
                        'name' => 'Археи — Елизавета Бонч-Осмоловская / ПостНаука',
                        'url' => 'https://www.youtube.com/watch?v=6nZ4kJ_JLbQ',
                        'likes' => 480,
                        'dislikes' => 4
                    ],
                    [
                        'name' => 'Основные ошибки инноваторов — Александр Чулок / ПостНаука',
                        'url' => 'https://www.youtube.com/watch?v=EJzj875zak4',
                        'likes' => 257,
                        'dislikes' => 54
                    ],
                    [
                        'name' => 'Иммунитет / Что я знаю',
                        'url' => 'https://www.youtube.com/watch?v=3LI4lguV0yU',
                        'likes' => 2000,
                        'dislikes' => 94
                    ],
                ]
            ],
            [
                'name' => 'National Geographic Россия',
                'url' => 'https://www.youtube.com/channel/UC77ykkX5UdMhd5ykWknoKmw/',
                'subscribers' => '42300',
                'videos' => [
                    [
                        'name' => '06 Космическая погода, Юпитер (2013)',
                        'url' => 'https://www.youtube.com/watch?v=ZJLXC4zbTrg',
                        'likes' => 18,
                        'dislikes' => 3
                    ],
                    [
                        'name' => 'Discovery: Что скрывает Солнце (2017)',
                        'url' => 'https://www.youtube.com/watch?v=k9sxDqOaTyA',
                        'likes' => 14,
                        'dislikes' => 6
                    ],
                    [
                        'name' => 'Революция космических роботов (2016)',
                        'url' => 'https://www.youtube.com/watch?v=sX3BTnxHU64',
                        'likes' => 7,
                        'dislikes' => 0
                    ],
                    [
                        'name' => 'Квин Мэри II (2008)',
                        'url' => 'https://www.youtube.com/watch?v=LrHOfm4SQPw',
                        'likes' => 12,
                        'dislikes' => 0
                    ],
                    [
                        'name' => 'Суперсооружения: Мегамосты: Самый длинный мост в Мире (2009)',
                        'url' => 'https://www.youtube.com/watch?v=HRmaRuSo_6A',
                        'likes' => 10,
                        'dislikes' => 1
                    ],
                ]
            ],
            [
                'name' => 'KhanAcademyRussian',
                'url' => 'https://www.youtube.com/user/KhanAcademyRussian/',
                'subscribers' => '299000',
                'videos' => [
                    [
                        'name' => 'Задача на положение точки относительно окружности(видео 61) | Подобие. Геометрия | Математика',
                        'url' => 'https://www.youtube.com/watch?v=rBpFGxjrXtQ',
                        'likes' => 3,
                        'dislikes' => 0
                    ],
                    [
                        'name' => 'Доказательство.Параллельные прямые имеют одинаковый угловой коэффициент(видео 73)| Подобие.Геометрия',
                        'url' => 'https://www.youtube.com/watch?v=DoPS5XYFy9A',
                        'likes' => 16,
                        'dislikes' => 0
                    ],
                    [
                        'name' => 'Правда ли покупка дома всегда выгоднее аренды? (видео 5)| Жильё | Экономика',
                        'url' => 'https://www.youtube.com/watch?v=s8mEzEwOjaQ',
                        'likes' => 197,
                        'dislikes' => 5
                    ],
                    [
                        'name' => 'Текущая стоимость и дисконтированный денежный поток (видео 15)| Проценты и займы | Экономика',
                        'url' => 'https://www.youtube.com/watch?v=fpxtuVOBsHc',
                        'likes' => 39,
                        'dislikes' => 0
                    ],
                ]
            ],
            [
                'name' => 'Serious Science',
                'url' => 'https://www.youtube.com/user/SeriousScience/',
                'subscribers' => '57400',
                'videos' => [
                    [
                        'name' => 'Supergravity and Kaluza-Klein Theory – Hadi Godazgar',
                        'url' => 'https://www.youtube.com/watch?v=qeYd-hdhH40&list=PL4p9eGkQRuo5LedqEzQDYnShDeUvdJkRj',
                        'likes' => 107,
                        'dislikes' => 11
                    ],
                    [
                        'name' => 'Higher- Spin Gauge Theory - Xavier Bekaert',
                        'url' => 'https://www.youtube.com/watch?v=SQoTARmYFvk&list=PL4p9eGkQRuo5LedqEzQDYnShDeUvdJkRj&index=2',
                        'likes' => 82,
                        'dislikes' => 2
                    ],
                    [
                        'name' => 'Quantizing gravity - Xavier Bekaert',
                        'url' => 'https://www.youtube.com/watch?v=SsEPWRHuGX4&list=PL4p9eGkQRuo5LedqEzQDYnShDeUvdJkRj&index=3',
                        'likes' => 41,
                        'dislikes' => 3
                    ],
                    [
                        'name' => 'Atom Interferometry - David Pritchard',
                        'url' => 'https://www.youtube.com/watch?v=Ps8C_fWZmoY&list=PL4p9eGkQRuo5LedqEzQDYnShDeUvdJkRj&index=4',
                        'likes' => 64,
                        'dislikes' => 2
                    ],
                    [
                        'name' => 'Standard Model — Jonathan Butterworth / Serious Science',
                        'url' => 'https://www.youtube.com/watch?v=V_JQKSuLdXM&list=PL4p9eGkQRuo5LedqEzQDYnShDeUvdJkRj&index=10',
                        'likes' => 50,
                        'dislikes' => 0
                    ],
                ]
            ],
        ]);

    }


    /**
     * Use in dev environment only (with dev packages)
     */
    public function showStatus()
    {
        try {
            dump( $this->client->listDatabases() );
            foreach ( $this->db->listCollections() as $collection ) {
                dump($collection);
            }

            $channels = $this->db->selectCollection('channels');

            foreach ($channels->find() as $channel) {
                dump($channel);
            }

        } catch (\Error $exception) {
            throw new \LogicException('Attempt to call dev method. Install app in dev mode');
        }
    }


    /**
     * @param Channel $channel
     * @return bool
     */
    public function addChannel(Task1\Channel $channel)
    {
        $dbChannels = $this->db->selectCollection('channels');

        $arVideos = [];

        /**
         * \DS\Vector $videos
         * Task1\Video $video
         */
        if ($channel->getVideos()->count() > 0) {

            foreach ($channel->getVideos() as $video) {
                $arVideos[] = [
                    'name' => $video->getName(),
                    'url' => $video->getUrl(),
                    'likes' => $video->getlikes(),
                    'dislikes' => $video->getDislikes()
                ];
            }

        }

        $result = $dbChannels->insertOne([
            'name' => $channel->getName(),
            'url' => $channel->getUrl(),
            'subscribers' => $channel->getSubscribers(),
            'videos' => $arVideos
        ]);

        return (bool) $result->getInsertedCount();
    }


    public function addVideo(Task1\Video $video)
    {
        $dbChannels = $this->db->selectCollection('channels');

        // TODO: update channel
        /*$result = $dbChannels->insertOne([
            'name' => $channel->getName(),
            'url' => $channel->getUrl(),
            'subscribers' => $channel->getSubscribers(),
            'videos' => $arVideos
        ]);*/

        // TODO: return \MongoDB\UpdateResult::isAcknowledged
        // return $result->getInsertedCount();
    }


    /**
     * @param Channel $chanel
     * @return bool
     */
    public function deleteChannel(Task1\Channel $chanel)
    {
        $dbChannels = $this->db->selectCollection('channels');
        $result = $dbChannels->deleteOne([
            'url' => $chanel->getUrl()
        ]);

        return (bool) $result->getDeletedCount();
    }


    /**
     * @param Video $video
     * @return bool
     */
    public function deleteVideo(Task1\Video $video)
    {
        $dbChannels = $this->db->selectCollection('channels');

        $result = $dbChannels->updateOne(
            [
                'videos.url' => $video->getUrl()
            ],
            [
                '$pull' => [
                    "videos" => ["url" => $video->getUrl()]
                ]
            ]
        );

        return (bool) $result->getModifiedCount();
    }


    /**
     * Return statistics to channel (likes, dislikes)
     * map-reduce aggregation is used
     *
     * @param Channel $channel
     * @return mixed
     */
    public function getStatistics(Task1\Channel $channel)
    {
        $dbChannels = $this->db->selectCollection('channels');

        $map = new \MongoDB\BSON\Javascript('
            function() {
                var key = this.url;
                for (var idx = 0; idx < this.videos.length; idx++) {
                    var value = {
                        likes: this.videos[idx].likes,
                        dislikes: this.videos[idx].dislikes
                    };
                    emit(key, value);
               }
            }
        ');

        $reduce = new \MongoDB\BSON\Javascript('
            function(key, value) {
                reducedVal = {likes: 0, dislikes: 0};
                for (var idx = 0; idx < value.length; idx++) {
                    reducedVal.likes += value[idx].likes;
                    reducedVal.dislikes += value[idx].dislikes;
               }
               return reducedVal;
            }
        ');

        $options = [
            'query' => [
                'url' => $channel->getUrl()
            ]
        ];

        $result = $dbChannels->mapReduce($map, $reduce, ['inline' => 1], $options);

        return $result->getIterator()[0];
    }


    /**
     * Return top channels by relation likes / dislikes
     * map-reduce aggregation is used
     *
     * @return mixed
     */
    public function getTop()
    {
        $dbChannels = $this->db->selectCollection('channels');

        $map = new \MongoDB\BSON\Javascript('
            function() {
                var key = this.url;
                for (var idx = 0; idx < this.videos.length; idx++) {
                    var value = {
                        likes: this.videos[idx].likes,
                        dislikes: this.videos[idx].dislikes
                    };
                    emit(key, value);
               }
            }
        ');

        $reduce = new \MongoDB\BSON\Javascript('
            function(key, value) {
                reducedVal = {likes: 0, dislikes: 0};
                for (var idx = 0; idx < value.length; idx++) {
                    reducedVal.likes += value[idx].likes;
                    reducedVal.dislikes += value[idx].dislikes;
               }
               return reducedVal;
            }
        ');

        $finalize = new \MongoDB\BSON\Javascript('
            function(key, reducedVal) {
                reducedVal.index = reducedVal.likes / reducedVal.dislikes;
                return reducedVal;
            }
        ');

        $options = [
            'finalize' => $finalize,
            // 'limit' => 5 // mongo can not sorting by aggregated value
        ];

        return $dbChannels->mapReduce($map, $reduce, ['inline' => 1], $options);
    }
}
