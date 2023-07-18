@extends('layouts.settings')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Website Information</h5>
                    <div class="mb-3">
                        @if (session('success') && session('success_type') === 'info')
                            <div class="alert alert-success" id="info-success">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    document.getElementById('info-success').style.display = 'none';
                                }, 2000);
                            </script>
                        @endif
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="website_name" class="form-label">Website Name</label>
                                <input type="text" name="website_name" id="website_name" class="form-control" value="{{ config('website-settings.website_name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ config('website-settings.phone_number') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ config('website-settings.email') }}" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Logo</h5>
                    @if (session('success') && session('success_type') === 'logo')
                        <div class="alert alert-success" id="logo-success">
                            {{ session('success') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                document.getElementById('logo-success').style.display = 'none';
                            }, 2000);
                        </script>
                    @endif
                    <div class="current-logo" style="max-width: 100%;">
                        @if(config('website-settings.logo_path'))
                            <img src="{{ Storage::url(config('website-settings.logo_path')) }}" alt="Current Logo" class="logo-img" style="max-width: 30%;">
                        @else
                            <img src="{{ asset('images/default_logo.png') }}" alt="Default Logo" class="logo-img" style="max-width: 30%;">
                        @endif
                    </div>
                    <div class="mb-3">
                        <form action="{{ route('settings.update.logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="logo" id="logo" class="form-control">
                            <div class="form-check mt-3">
                                <input type="checkbox" name="remove_logo" id="remove_logo" class="form-check-input">
                                <label for="remove_logo" class="form-check-label">Remove Logo</label>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
