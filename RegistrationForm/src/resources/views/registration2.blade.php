@extends('layout')
@section('title', 'Registration Step 2')
@section('content')
    <div class="container">
        <form id="registrationForm" class="ms-auto me-auto mt-3" style="width:500px" method="POST" action="{{ route('registration.post2') }}" >
            @csrf
            <div class="form-step">
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email address') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $draftUser->email ?? old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" >
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Phone') }}</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $draftUser->phone ?? old('phone') }}">
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('registration') }}'">{{ __('Back') }}</button>
                    <button type="submit" class="btn btn-primary" onclick="submitForm(event)" >{{ __('Next') }}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^[0-9]{10,15}$/;
            return re.test(phone);
        }

        async function submitForm(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const phone = document.getElementById('phone').value;

            let valid = true;

            if (!validateEmail(email)) {
                alert('Please enter a valid email address.');
                valid = false;
            }

            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                valid = false;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                valid = false;
            }

            if (!validatePhone(phone)) {
                alert('Please enter a valid phone number.');
                valid = false;
            }

            if (valid) {
                const form = document.getElementById('registrationForm');
                const formData = new FormData(form);
                const jsonData = {};

                formData.forEach((value, key) => {
                    jsonData[key] = value;
                });

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                try {
                    const response = await fetch('{{ route('registration.post2') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(jsonData)
                    });

                    if (response.ok) {
                        localStorage.setItem('step1', JSON.stringify(jsonData));
                        window.location.href = '{{ route('registration3') }}';
                    } else {
                        console.error('Error:', response.statusText);
                        alert('Failed to submit the form.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to submit the form.');
                }
            }

            return false;
        }
    </script>
@endsection
