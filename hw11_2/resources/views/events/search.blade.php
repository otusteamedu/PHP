@extends('layouts.app')

@section('content')
    <h3>Search events</h3>

    <form method="get" action="{{ route('event.search') }}">
        <div class="form-group">
            <label for="conditions">Conditions</label>
            <textarea class="form-control{{ $errors->has('conditions') ? ' is-invalid' : '' }}"
                      id="conditions"
                      name="conditions">{{ old('conditions') }}</textarea>
            <small id="emailHelp" class="form-text text-muted">Format:<br>param1 = 1<br>param2 = 2</small>
            @if ($errors->has('conditions'))
                <div class="invalid-feedback">{{ $errors->first('conditions') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Search</button>

        <hr>

        @if ($event !== null)
            <div class="mt-3">
                <h4>Result:</h4>
                @if ($event === false)
                    <p class="text text-secondary">Nothing found</p>
                @else
                    <table class="table-borderless">
                        <tr>
                            <td class="align-top pr-2">Event:</td>
                            <td class="align-top pl-2">{{ $event->getName() }}</td>
                        </tr>
                        <tr>
                            <td class="align-top pr-2">Priority:</td>
                            <td class="align-top pl-2">{{ $event->getPriority() }}</td>
                        </tr>
                        <tr>
                            <td class="align-top pr-2">Conditions:</td>
                            <td class="align-top pl-2">
                                @foreach ($event->getConditions() as $condition)
                                    {{ $condition['key'] }}: {{ $condition['value'] }}
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </table>
                @endif
            </div>
        @endif
    </form>
@endsection
