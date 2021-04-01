<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/events/create">Create Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events/flush">Delete All Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events/search">Search Events</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Events</h5>
                    </div>
                <div class="card-body">
                    <?php if($events->isEmpty()) : ?>
                        <p>Events not found</p>
                    <?php else: ?>
                        <?php foreach ($events as $event): ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Event #<?= $event->getId() ?></strong>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><strong>Name: </strong><?= $event->getName() ?></p>
                                    <p class="card-text"><strong>Priority: </strong><?= $event->getPriority() ?></p>
                                    <?php foreach ($event->getParams() as $index => $param): ?>
                                        <p class="card-text"><strong>Params <?= $index+1 ?>: </strong><?= $param ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
