
@foreach ($films as $film)
     <p>Film: {{$film->name}}</p>
     <p>Duration: {{$film->duration}}</p>
     <p>Age Restrict: {{$film->age_restrict}}</p>
    <hr>
@endforeach
