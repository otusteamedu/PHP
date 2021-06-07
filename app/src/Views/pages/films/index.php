<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/films/create">Create Film</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/films/report">Get Report</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Films</h5>
                    </div>
                    <div class="card-body">
                        <?php if($films->isEmpty()) : ?>
                            <p>Films not found</p>
                        <?php else: ?>
                            <?php foreach ($films as $film): ?>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <strong>
                                            <a href="/films/show?id=<?=$film->getId()?>">
                                                Films #<?= $film->getId() ?>
                                            </a>
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Name: </strong><?= $film->getName() ?></p>
                                        <p class="card-text"><strong>Description: </strong><?= $film->getDescription() ?></p>
                                        <p class="card-text"><strong>AgeRestrict: </strong><?= $film->getAgeRestrict() ?></p>
                                        <p class="card-text"><strong>Duration: </strong><?= $film->getDuration() ?></p>
                                        <p class="card-text"><strong>Created: </strong><?= $film->getCreatedAt() ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/films/show?id=<?=$film->getId()?>"> Show </a>/
                                        <a href="/films/edit?id=<?=$film->getId()?>"> Edit </a>/
                                        <a href="/films/delete?id=<?=$film->getId()?>"> Delete </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
