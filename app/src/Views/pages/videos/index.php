<div class="row">
    <div class="col-12">
        <form action="/videos" method="get">
            <div class="form-group">
                <label for="videos-search">Search</label>
                <input type="text" class="form-control" name="query" id="videos-search" placeholder="Search videos"
                    value="<?= $query ?? ''?>"
                >
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="row">
            <div class="col-12 my-3">
                <?php if(empty($videos)) : ?>
                    <p>Videos not found</p>
                <?php else: ?>
                    <?php foreach ($videos as $video): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong><?= $video->getTitle() ?></strong>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><strong>Description: </strong><?= $video->getDescription() ?></p>
                                <p class="card-text"><strong>ID: </strong><?= $video->getId() ?></p>
                                <p class="card-text"><strong>Channel: </strong><?= $video->getChannel()->getTitle() ?></p>
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
