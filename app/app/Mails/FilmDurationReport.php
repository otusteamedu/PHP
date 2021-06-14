<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class FilmDurationReport extends Mailable
{
    use Queueable, SerializesModels;

    protected Collection $films;

    public function __construct(Collection $films)
    {
        $this->films = $films;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.film-duration')
            ->with([
                'films' => $this->films,
            ]);
    }
}
