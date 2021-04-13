<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5><?= isset($film) ? 'Update' : 'Create' ?>  Film Form</h5>
            </div>
            <div class="card-body">
                <form action="<?= isset($film) ? '/films/update' : '/films' ?>" method="post">
                    <?php if(optional($film)->getId()) : ?>
                        <input type="hidden" name="id" value="<?= optional($film)->getId()?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="film-name">Name</label>
                        <input type="text" class="form-control" name="name" id="film-name"
                               placeholder="Film Name"
                               value="<?= optional($film)->getName() ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="film-description">Description</label>
                        <textarea class="form-control" name="description" id="film-description"
                               placeholder="Input film description"
                        ><?= optional($film)->getDescription() ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="film-age-restrict">Age Restrict</label>
                        <input type="text" class="form-control" name="age_restrict" id="film-age-restrict"
                               placeholder="Input age restrict"
                               value="<?= optional($film)->getAgeRestrict() ?? ''?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="film-duration">Duration</label>
                        <input type="time" class="form-control" name="duration" id="film-duration"
                               placeholder="Input duration"
                               value="<?= optional($film)->getDuration() ?>"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
    </div>
</div>
