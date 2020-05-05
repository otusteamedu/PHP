<?php


class PayCalculator
{
    private Post $post;
    /**
     * PayCalculator constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    public static function calculatePay($post) : float {
        $hourly_rate = ''; /*rate per hour in $ USA*/
        switch ($post) {
            case Post::worker: $hourly_rate = 8.5;
                break;
            case Post::hr_specialist: $hourly_rate = 9.5;
                break;
            case  Post::manager: $hourly_rate = 10;
                break;
            case Post::accountant: $hourly_rate = 10.25;
                break;
            case Post::developer: $hourly_rate = 15;
                break;
            case Post::director: $hourly_rate = 20;
                break;
        }
        return $hourly_rate*21.5*8; /*full month salary*/
    }

}