<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Create Event Form</h5>
            </div>
            <div class="card-body">
                <form action="/events" method="post">
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
            </div>
    </div>
</div>
