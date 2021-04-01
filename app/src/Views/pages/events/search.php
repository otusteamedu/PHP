<div class="row">
    <div class="col-12">
        <form action="/events/search" method="get">
            <h3>Create Event Form</h3>
            <div class="form-group">
                <label for="event-name">Event Name</label>
                <input type="text" class="form-control" name="name" id="event-name"
                       placeholder="Event Name"
                       value="<?= $eventName ?? ''?>"
                >
            </div>
            <div class="form-group">
                <label for="event-priority">Priority</label>
                <input type="number" class="form-control" name="priority" id="event-priority"
                       placeholder="Input event priority"
                       value="<?= $eventPriority ?? ''?>"
                >
            </div>
            <div class="form-group">
                <label for="event-priority">Params</label>
                <input type="text" class="form-control" name="params" id="event-params"
                       placeholder="Input event params with comma separated"
                       value="<?= $eventParams ?? ''?>"
                >
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="row">
            <div class="col-12 my-3">
                <?php if(empty($events)) : ?>
                    <p>Videos not found</p>
                <?php else: ?>
                    <?php foreach ($events as $event): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong><?= $event->getTitle() ?></strong>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Description: </strong><?= $video->getDescription() ?></p>
                                <p class="card-text"><strong>ID: </strong><?= $video->getId() ?></p>
                                <p class="card-text"><strong>Views: </strong><?= $video->getViewCount() ?></p>
                                <p class="card-text"><strong>Likes: </strong><?= $video->getLikeCount() ?></p>
                                <p class="card-text"><strong>Dislikes: </strong><?= $video->getDislikeCount() ?></p>
                                <p class="card-text"><strong>Favorites: </strong><?= $video->getFavoriteCount() ?></p>
                                <p class="card-text"><strong>Comments: </strong><?= $video->getCommentCount() ?></p>
                                <p class="card-text"><strong>Published: </strong><?= $video->getPublishedAt()->format('d M Y') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
