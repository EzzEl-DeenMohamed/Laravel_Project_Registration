@extends('layout')
@section('title', 'Registration Step 1')
@section('content')
    <div class="container">
        <form id="registrationForm" class="ms-auto me-auto mt-3" style="width:500px" method="POST" action="{{ route('registration.post') }}" onsubmit="return submitForm(event)">
            @csrf
            <div class="form-step">
                <div class="mb-3">
                    <label for="full_name" class="form-label">{{ __('Full Name') }}</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $draftUser->full_name ?? old('full_name') }}">
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">{{ __('Username') }}</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $draftUser->user_name ?? old('user_name') }}">
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $draftUser->birthdate ?? old('birthdate') }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('Address') }}</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $draftUser->address ?? old('address') }}">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">{{ __('Next') }}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        async function submitForm(event) {
            event.preventDefault();

            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);
            const jsonData = {};

            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch('{{ route('registration.post') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(jsonData)
                });

                if (response.ok) {
                    localStorage.setItem('step1', JSON.stringify(jsonData));
                    window.location.href = '{{ route('registration2') }}';
                } else {
                    console.error('Error:', response.statusText);
                    alert('Failed to submit the form.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to submit the form.');
            }

            return false;
        }
    </script>
@endsection
