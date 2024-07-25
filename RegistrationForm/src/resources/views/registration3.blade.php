@extends('layout')
@section('title', 'Registration Step 3')
@section('content')
    <div class="container">
        <form id="registrationForm" class="ms-auto me-auto mt-3" style="width:500px" method="POST" action="{{ route('registration.post3') }}" enctype="multipart/form-data" onsubmit="return saveStepData(3)">
            @csrf
            <div class="form-step">
                <div class="mb-3">
                    <label for="user_image" class="form-label">{{ __('User Image') }}</label>
                    <input type="file" class="form-control" id="user_image" name="user_image">
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('registration2') }}'">{{ __('Back') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function saveStepData(step) {
            const formData = new FormData(document.getElementById('registrationForm'));
            const jsonData = {};

            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            localStorage.setItem(`step${step}`, JSON.stringify(jsonData));
        }

        document.addEventListener('DOMContentLoaded', () => {
            const previousData = JSON.parse(localStorage.getItem('step2')) || {};
            Object.keys(previousData).forEach(key => {
                if (document.getElementById(key)) {
                    document.getElementById(key).value = previousData[key];
                }
            });
        });
    </script>
@endsection
