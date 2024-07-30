@extends('layout')
@section('title', 'Registration Step 3')
@section('content')
    <div class="container">
        <form id="registrationForm" class="ms-auto me-auto mt-3" style="width:500px" method="POST" action="{{ route('registration.post3') }}" enctype="multipart/form-data" >
            @csrf
            <div class="form-step">
                <div class="mb-3">
                    <label for="image_url" class="form-label">{{ __('User Image') }}</label>
                    <input type="file" class="form-control" id="image_url" name="image_url">
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('registration2') }}'">{{ __('Back') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
                <div class="mb-3">
                    <button type="button" id="sendEmailButton" class="btn btn-outline-info" onclick="handleButtonClick('email')" >{{ __('Send Email') }}</button>
                    <button type="button" id="sendPhoneButton" class="btn btn-outline-info" onclick="handleButtonClick('phone')">{{ __('Send Phone') }}</button>
                    <button type="button" id="sendPushNotificationButton" class="btn btn-outline-info" onclick="handleButtonClick('push')">{{ __('Send PushNotification') }}</button>
                </div>
                <input type="text" class="form-control" id="id" name="id" value="{{ session('id') }}" style="display: none;">
                <input type="text" class="form-control" id="messageType" name="messageType" style="display: none;">
            </div>
        </form>
    </div>

    <script>
        function handleButtonClick() {
            const sendEmailButton = document.getElementById('sendEmailButton');
            const sendPhoneButton = document.getElementById('sendPhoneButton');
            const sendPushNotificationButton = document.getElementById('sendPushNotificationButton');
            const messageTypeInput = document.getElementById('messageType');

            sendEmailButton.addEventListener('click', () => {
                sendEmailButton.classList.add('active');
                sendPhoneButton.classList.remove('active');
                sendPushNotificationButton.classList.remove('active');
                messageTypeInput.value = 'email';
            });

            sendPhoneButton.addEventListener('click', () => {
                sendEmailButton.classList.remove('active');
                sendPhoneButton.classList.add('active');
                sendPushNotificationButton.classList.remove('active');
                messageTypeInput.value = 'phone';
            });

            sendPushNotificationButton.addEventListener('click', () => {
                sendEmailButton.classList.remove('active');
                sendPhoneButton.classList.remove('active');
                sendPushNotificationButton.classList.add('active');
                messageTypeInput.value = 'push';
            });
        }


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
