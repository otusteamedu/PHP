@extends('layouts.app')

@section('content')
    <home inline-template>
        <div class="row">
            <div class="col-xs-12 m-3 w-100">
                <h3>Please select the action:</h3>

                <div class="btn-group" role="group" aria-label="Actions">
                    <a href="{{ route('event.search') }}" class="btn btn-outline-primary">Search event</a>
                    <a href="{{ route('event.create') }}" class="btn btn-outline-primary">Add new event</a>
                    <button class="btn btn-outline-danger" @click="showConfirmation">
                        Clear all events
                    </button>
                </div>
            </div>

            <form ref="clearForm"
                  action="{{ route('event.clear') }}"
                  method="POST"
                  class="d-none">
                {{ csrf_field() }}
                {{ method_field('delete') }}
            </form>
        </div>
    </home>
@endsection
