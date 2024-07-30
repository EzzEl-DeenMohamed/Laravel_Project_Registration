@extends('layout')
@section('title', 'Registration Step 1')
@section('content')
    <form id="registrationForm" class="ms-auto me-auto mt-3" style="width:500px" method="POST" action="{{ route('registration.post') }}">
        @csrf
        <div class="form-step">
            <div class="mb-3">
                <label for="full_name" class="form-label">{{ __('Full Name') }}</label>
                <input type="text" class="form-control" id="full_name" name="full_name">
            </div>
            <div class="mb-3">
                <label for="user_name" class="form-label">{{ __('Username') }}</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">{{ __('Address') }}</label>
                <input type="text" class="form-control" id="address" name="address" >
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">{{ __('Next') }}</button>
            </div>
        </div>
    </form>
    <div class="container">
    </div>

{{--    <script>--}}
{{--        async function submitForm(event) {--}}
{{--            event.preventDefault();--}}

{{--            const form = document.getElementById('registrationForm');--}}
{{--            const formData = new FormData(form);--}}
{{--            const jsonData = {};--}}

{{--            formData.forEach((value, key) => {--}}
{{--                jsonData[key] = value;--}}
{{--            });--}}

{{--            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');--}}

{{--            try {--}}
{{--                const response = await fetch('{{ route('registration.post') }}', {--}}
{{--                    method: 'POST',--}}
{{--                    headers: {--}}
{{--                        'Content-Type': 'application/json',--}}
{{--                        'X-CSRF-TOKEN': csrfToken--}}
{{--                    },--}}
{{--                    body: JSON.stringify(jsonData)--}}
{{--                });--}}

{{--                if (response.ok) {--}}
{{--                    const responseData = await response.json(); // Expecting JSON response--}}
{{--                    localStorage.setItem('step1', JSON.stringify(jsonData));--}}

{{--                    // Check if the response contains the ID and redirect accordingly--}}
{{--                    if (responseData.success) {--}}
{{--                        window.location.href = '{{ route('registration2') }}'; // Redirect to registration2--}}
{{--                    } else {--}}
{{--                        console.error('Error:', responseData.message);--}}
{{--                        alert('Failed to submit the form.');--}}
{{--                    }--}}
{{--                } else {--}}
{{--                    console.error('Error:', response.statusText);--}}
{{--                    alert('Failed to submit the form.');--}}
{{--                }--}}
{{--            } catch (error) {--}}
{{--                console.error('Error:', error);--}}
{{--                alert('Failed to submit the form.');--}}
{{--            }--}}

{{--            return false;--}}
{{--        }--}}
{{--    </script>--}}
@endsection
