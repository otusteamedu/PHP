@extends('layouts.app')

@section('content')
    <h3>New event</h3>

    <form method="post" action="{{ route('event.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Event name</label>
            <input type="text"
                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                   id="name"
                   name="name"
                   autofocus
                   value="{{ old('name') }}">
            @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="priority">Priority</label>
            <input type="number"
                   class="form-control{{ $errors->has('priority') ? ' is-invalid' : '' }}"
                   id="priority"
                   name="priority"
                   value="{{ old('priority') }}">
            @if ($errors->has('priority'))
                <div class="invalid-feedback">{{ $errors->first('priority') }}</div>
            @endif
        </div>
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

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
