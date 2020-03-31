<?php
namespace Otus\HW11\Task1;

use Otus\HW11\Config;
use \Otus\HW11\Task1;

class MongoStorage implements Task1\IStorage
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


    public function addChannel(Task1\Channel $channel)
    {
        // TODO: Implement addChannel() method.
    }


    public function addVideo(Task1\Video $video)
    {
        // TODO: Implement addVideo() method.
    }

}