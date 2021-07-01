<?php

namespace App\Observers;

use App\Models\Video;
use App\Observers\Traits\HasIndexElasticsearch;

class VideoObserver
{
    use HasIndexElasticsearch;

    /**
     * @param Video $video
     */
    public function saved(Video $video)
    {
        $this->onSave($video);
    }

    /**
     * Handle the Video "created" event.
     *
     * @param Video $video
     * @return void
     */
    public function created(Video $video)
    {
        //
    }

    /**
     * Handle the Video "updated" event.
     *
     * @param Video $video
     * @return void
     */
    public function updated(Video $video)
    {
        //
    }

    /**
     * Handle the Video "deleted" event.
     *
     * @param Video $video
     * @return void
     */
    public function deleted(Video $video)
    {
        $this->onDelete($video);
    }

    /**
     * Handle the Video "restored" event.
     *
     * @param Video $video
     * @return void
     */
    public function restored(Video $video)
    {
        //
    }

    /**
     * Handle the Video "force deleted" event.
     *
     * @param Video $video
     * @return void
     */
    public function forceDeleted(Video $video)
    {
        $this->onDelete($video);
    }
}
