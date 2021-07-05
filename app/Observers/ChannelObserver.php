<?php

namespace App\Observers;


use App\Models\Channel;use App\Observers\Traits\HasIndexElasticsearch;

/**
 * Class ChannelObserver
 * @package App\Observers
 * Обсервер необходим для реагирования на события изменения баз данных.
 * Создается командой: php artisan make:observer ИмяОбсервера(ChannelObserver) --model=ИмяМодели(Channel)
 * Для связи обсервера с моделью можно в \Providers\AppServiceProvider.php в методе boot добавить
 * Channel::observe(ChannelObserver::class); где Channel - это модель, ChannelObserve - имя класса обсервера.
 *
 */
class ChannelObserver
{
    use HasIndexElasticsearch;

    public function saved(Channel $channel)
    {
        $this->onSave($channel);
    }

    /**
     * Handle the Channel "created" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function created(Channel $channel)
    {
        //
    }

    /**
     * @param Channel $channel
     */
    public function creating(Channel $channel)
    {
        // $channel->isDirty(); // - проверяет было ли изменено хоть какое-то поле
        // $channel->isDirty('field'); // - проверяет было ли изменено поле field
        // $channel->getAttribute('field'); // - возвращает текущее значение поля field
        // $channel->field; // - тоже возвращает текущее значение поля field
        // $channel->getOriginal('field'); // - возвращает начальное значение поля field
        // Чтобы запретить создание записи в базу нужно вернуть false
        // return false;
    }

    /**
     * Handle the Channel "updated" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function updated(Channel $channel)
    {
        //
    }

    /**
     * Handle the Channel "deleted" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function deleted(Channel $channel)
    {
        $this->onDelete($channel);
    }

    /**
     * Handle the Channel "restored" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function restored(Channel $channel)
    {
        //
    }

    /**
     * Handle the Channel "force deleted" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function forceDeleted(Channel $channel)
    {
        $this->onDelete($channel);
    }
}
