@extends('layouts.profile')

@section('content')
    <div class="container">
        <h1>Profile Details</h1>

        <div>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <!-- Add any other profile details you want to display -->
        </div>
    </div>
@endsection
