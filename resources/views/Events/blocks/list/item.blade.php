<?php /** @var \App\Models\Event $event */ ?>
<div class="">
    <div class="alert alert-primary">

            <event class="mb-3">
                <h2>{{$event->name}}</h2>
            </event>

        <table width="100%">
            <tr>
                <td class="m-0">Приоритет: <b>{{$event->priority}}</b></td>
            </tr>
            <tr>
                <div>
                    @foreach ($event->conditions as $param => $value)
                        <span class="badge badge-light">{{$param}}={{$value}}</span>
                    @endforeach
                </div>
            </tr>
        </table>
    </div>

</div>

