@if($isValidEmail)
    <p style="color: #69ad69;">Email is valid</p>
@else
    <p style="color: red;">Email is invalid</p>
@endif
<a href="{{ route('email.index') }}">Validate again</a>
