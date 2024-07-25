@extends('layout')
@section('title', 'Registration')
@section('content')
    <div class="container">
        <form id="registrationForm" class="ms-auto me-auto mt-3" style="width:500px" method="POST" action="{{route('registration.post')}}" onsubmit="return submitForm()">
            @csrf
            <!-- Step 1: Personal Information -->
            <div id="step1" class="form-step">
                <div class="mb-3">
                    <label for="full_name" class="form-label">{{ __('Full Name') }}</label>
                    <input type="text" class="form-control" id="full_name" name="full_name">
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">{{ __('Username') }}</label>
                    <input type="text" class="form-control" id="user_name" name="user_name">
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate">
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">{{ __('Next') }}</button>
                </div>
            </div>

            <!-- Step 2: Email and Password -->
            <div id="step2" class="form-step" style="display:none;">
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email address') }}</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Phone') }}</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">{{ __('Back') }}</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">{{ __('Next') }}</button>
                </div>
            </div>

            <!-- Step 3: Message Type -->
            <div id="step3" class="form-step" style="display:none;">
                <div class="mb-3">
                    <label for="user_image" class="form-label">{{ __('User Image') }}</label>
                    <input type="file" class="form-control" id="user_image" name="user_image">
                </div>
                <div class="mb-3">
                    <button type="button" id="sendEmailButton" class="btn btn-outline-info" onclick="handleButtonClick('email')">{{ __('Send Email') }}</button>
                    <button type="button" id="sendPhoneButton" class="btn btn-outline-info" onclick="handleButtonClick('phone')">{{ __('Send Phone') }}</button>
                    <button type="button" id="sendPushNotificationButton" class="btn btn-outline-info" onclick="handleButtonClick('push')">{{ __('Send PushNotification') }}</button>
                </div>
                <input type="text" class="form-control" id="messageType" name="messageType" style="display: none;">
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(3)">{{ __('Back') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="{{ URL::asset('API_Ops.js') }}"></script>
    <script>
        function nextStep(currentStep) {
            if (validateStep(currentStep)) {
                const current = document.getElementById('step' + currentStep);
                const next = document.getElementById('step' + (currentStep + 1));
                current.style.display = 'none';
                next.style.display = 'block';
            }
        }

        function prevStep(currentStep) {
            const current = document.getElementById('step' + currentStep);
            const prev = document.getElementById('step' + (currentStep - 1));
            current.style.display = 'none';
            prev.style.display = 'block';
        }

        function handleButtonClick(type) {
            const buttons = ['sendEmailButton', 'sendPhoneButton', 'sendPushNotificationButton'];
            buttons.forEach(button => document.getElementById(button).classList.remove('active'));
            document.getElementById('messageType').value = type;
            document.getElementById(`send${type.charAt(0).toUpperCase() + type.slice(1)}Button`).classList.add('active');
        }

        function validateStep(step) {
            switch (step) {
                case 1:
                    return validateStep1();
                case 2:
                    return validateStep2();
                case 3:
                    return validateStep3();
                default:
                    return false;
            }
        }

        function validateStep1() {
            const fullName = document.getElementById('full_name').value;
            const userName = document.getElementById('user_name').value;
            const birthdate = document.getElementById('birthdate').value;

            if (!fullName || !userName || !birthdate) {
                alert('Please fill in all required fields.');
                return false;
            }

            return true;
        }

        function validateStep2() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const phone = document.getElementById('phone').value;

            const emailPattern = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

            const passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
            if (!passwordPattern.test(password)) {
                alert('Password must be at least 8 characters long and contain at least 1 number and 1 special character.');
                return false;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return false;
            }

            if (!phone) {
                alert('Please enter your phone number.');
                return false;
            }

            return true;
        }

        function validateStep3() {
            const messageType = document.getElementById('messageType').value;
            if (!messageType) {
                alert('Please select a message type.');
                return false;
            }
            return true;
        }

        function submitForm() {
            const formData = new FormData(document.getElementById('registrationForm'));
            const jsonData = {};

            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            return jsonData;
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            handleButtonClick('email'); // Initialize with default selected message type
        });
    </script>

    <style>
        .btn.active {
            background-color: #629fd5;
            color: white;
        }
    </style>
@endsection
