<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Search Events Form</h5>
            </div>
            <div class="card-body">
                <form action="/events/search" method="get">
                    <div class="form-group">
                        <label for="event-name">Event Name</label>
                        <input type="text" class="form-control" name="name" id="event-name"
                               placeholder="Event Name"
                               value="<?= $eventName ?? ''?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="event-priority">Params</label>
                        <input type="text" class="form-control" name="params" id="event-params"
                               placeholder="Input event params with comma separated"
                               value="<?= $eventParams ?? ''?>"
                        >
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="high-priority" name="appropriate">
                        <label class="form-check-label" for="high-priority"
                        >Get appropriate by params and the highest priority</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
