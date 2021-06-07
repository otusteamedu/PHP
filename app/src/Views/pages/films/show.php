<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-12 my-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Films #<?= $film->getId() ?></strong>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Name: </strong><?= $film->getName() ?></p>
                        <p class="card-text"><strong>Description: </strong><?= $film->getDescription() ?></p>
                        <p class="card-text"><strong>AgeRestrict: </strong><?= $film->getAgeRestrict() ?></p>
                        <p class="card-text"><strong>Duration: </strong><?= $film->getDuration() ?></p>
                        <p class="card-text"><strong>Created: </strong><?= $film->getCreatedAt() ?></p
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
