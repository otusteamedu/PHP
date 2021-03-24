 <div class="card-body" style="justify-content: center;display: flex">
        <div class="row">
            @if(Session::has('success'))
                {{Session::get('success')}}
            @elseif(Session::has('failed'))
                {{Session::get('failed')}}
            @endif
        </div>
        <form method="POST" action="/store">
            @csrf
            <div class="row card-title" style="font-size: 18px; margin: 25px">
                <div class="col-md-12">
                    Add new event
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col-md-12">
                    <input type="text" class="form-control" name="event[event_name]" placeholder="event" required>
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col-md-12">
                    <input type="text" class="form-control" name="event[priority]" placeholder="priority" required>
                </div>
            </div>
            <div id="conditions">
                <div class="row" style="margin: 25px">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="event[conditions][1][key]" placeholder="key"
                               required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="event[conditions][1][value]" placeholder="value"
                               required>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-primary add">Add condition</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Store event</button>
                </div>
            </div>
        </form>
</div>
@once
    @push('scripts')
        <script>
            let i = 1;

            $(".add").click(function () {
                ++i;
                $("#conditions").append('<div class="row" style="margin: 25px"><div class="col-md-4">' +
                    '<input type="text" class="form-control" name="event[conditions][' + i + '][key]" placeholder="key" required>' +
                    '</div><div class="col col-md-4">' +
                    '<input type="text" class="form-control" name="event[conditions][' + i + '][value]" placeholder="value" required>' +
                    '</div></div>');
            });
            $(document).on('click', '.remove-tr', function () {
                $(this).parents('tr').remove();
            });
        </script>
    @endpush
@endonce
