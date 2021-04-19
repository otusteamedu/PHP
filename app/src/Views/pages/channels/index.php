<div class="row">
    <div class="col-12">
        <form action="/channels/search" method="get">
            <div class="form-group">
                <label for="channel-search">Search</label>
                <input type="text" class="form-control" name="query" id="channel-search" placeholder="Search channels"
                    value="<?= $query ?? ''?>"
                >
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="row">
            <div class="col-12 my-3">
                <?php if(empty($channels)) : ?>
                    <p>Channels not found</p>
                <?php else: ?>
                    <?php foreach ($channels as $channel): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong><?= $channel->getTitle() ?></strong>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Description: </strong><?= $channel->getDescription() ?></p>
                                <p class="card-text"><strong>ID: </strong><?= $channel->getId() ?></p>
                                <p class="card-text"><strong>Views: </strong><?= $channel->getViewsCount() ?></p>
                                <p class="card-text"><strong>Videos: </strong><?= $channel->getVideosCount() ?></p>
                                <p class="card-text"><strong>Subscribers: </strong><?= $channel->getSubscribersCount() ?></p>
                                <p class="card-text"><strong>Video Likes Count: </strong><?= $channel->getVideoLikeCont() ?></p>
                                <p class="card-text"><strong>Video Dislikes Count: </strong><?= $channel->getVideoDislikeCont() ?></p>
                                <p class="card-text"><strong>Video Like/Dislike Quotient: </strong><?= $channel->getVideoLikesByDislikesQuotient() ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
