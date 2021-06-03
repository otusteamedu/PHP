 <div class="card-body" style="justify-content: center;display: flex">
        <form method="GET" action="/get">
            @csrf
            <div class="row card-title" style="font-size: 18px; margin: 25px">
                <div class="col-md-12">
                    Put your conditions here
                </div>
            </div>
            <div id="conditions">
                <div class="row" style="margin: 25px">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="conditions[1][key]" placeholder="key"
                               required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="conditions[1][value]" placeholder="value"
                               required>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-primary add">Add condition</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col-md-12">
                @if($event)
                    Event is "{{ $event }}"
                @endif
                </div>
            </div>
            <div class="row" style="margin: 25px">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Get event</button>
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
                    '<input type="text" class="form-control" name="conditions[' + i + '][key]" placeholder="key" required>' +
                    '</div><div class="col col-md-4">' +
                    '<input type="text" class="form-control" name="conditions[' + i + '][value]" placeholder="value" required>' +
                    '</div></div>');
            });
            $(document).on('click', '.remove-tr', function () {
                $(this).parents('tr').remove();
            });
        </script>
    @endpush
@endonce
