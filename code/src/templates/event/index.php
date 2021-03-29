<h1 class="h2 my-3">Events</h1>

<div class="alert"></div>

<div class="row mt-3">
    <div class="col-md-2">
            <h2 class="h5">Generate event</h2>
            <div class="row generate-event visually-hidden">
                <div class="col">
                    <div class="mb-3">
                        <label for="inputParam1" class="form-label">param1</label>
                        <input type="number" name="param1" class="form-control w-50" id="inputParam1"
                               aria-describedby="param1Help">
                    </div>
                    <div class="mb-3">
                        <label for="inputParam2" class="form-label">param2</label>
                        <input type="number" name="param2" class="form-control w-50" id="inputParam2"
                               aria-describedby="param2Help">
                    </div>
                    <button type="submit" id="btn-event" class="btn btn-success">Event!</button>
                </div>
            </div>
    </div>

    <div class="col-md-7">
        <h2 class="h4">Available events</h2>
        <div class="row">
            <div class="col">
                <ul class="list-group list-group-flush event-list">
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <h2 class="h5">Manage Events</h2>
        <div class="row">
            <div class="col">
                <form id="form-new-event" method="post">
                    <input type="hidden" name="add-event">
                    <div class="mb-3">
                        <label for="inputPriority" class="form-label">Priority</label>
                        <input type="number" name="priority" class="form-control" id="inputPriority">
                    </div>
                    <div class="mb-3">
                        <label for="inputParam1" class="form-label">param1</label>
                        <input type="number" name="param1" class="form-control" id="inputParam1">
                    </div>
                    <div class="mb-3">
                        <label for="inputParam2" class="form-label">param2</label>
                        <input type="number" name="param2" class="form-control" id="inputParam2">
                    </div>
                    <div class="mb-3">
                        <label for="inputEvent" class="form-label">Event</label>
                        <input type="text" name="event" class="form-control" id="inputEvent"
                               aria-describedby="param1Help">
                    </div>
                    <button type="submit" class="btn btn-primary">Create event</button>
                </form>

                <div class="mt-4 drop-event">
                    <button type="submit" id="btn-drop-events" class="btn btn-danger visually-hidden">Remove events</button>
                </div>
            </div>

        </div>
    </div>
</div>









