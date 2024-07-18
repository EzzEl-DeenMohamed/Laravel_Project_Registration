@extends('layout')
@section('title', 'Registration')
@section('content')
    <div class="container">
        <form class="ms-auto me-auto mt-3" style="width:500px" action="{{route('registration.post')}}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="mb-3">
                <label for="full_name" class="form-label">{{__('Full Name')}}</label>
                <input type="text" class="form-control" id="full_name" name="full_name" >
            </div>
            <div class="mb-3">
                <label for="user_name" class="form-label">{{__('Username')}}</label>
                <input type="text" class="form-control" id="user_name" name="user_name" >
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">{{__('Birthdate')}}</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" >
            </div>
            <div class="mb-3">
                <button type="button" id="checkActorsButton" class="btn btn-outline-info" onclick="getActorsBornToday()">{{__('Check Actors Born Today')}}</button>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">{{__('Phone')}}</label>
                <input type="text" class="form-control" id="phone" name="phone" >
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">{{__('Address')}}</label>
                <input type="text" class="form-control" id="address" name="address" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{__('Password')}}</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">{{__('Confirm Password')}}</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{__('Email address')}}</label>
                <input type="email" class="form-control" id="email" name="email" >
            </div>
            <div class="mb-3">
                <label for="user_image" class="form-label">{{__('User Image')}}</label>
                <input type="file" class="form-control" id="user_image" name="user_image">
            </div>

            <div class="mb-4">
                <button type="button" id="sendEmailButton" class="btn btn-outline-info" onclick="handleButtonClick('sendEmailButton', 'sendPhoneButton')">{{__('Send Email')}}</button>
                <button type="button" id="sendPhoneButton" class="btn btn-outline-info" onclick="handleButtonClick('sendPhoneButton', 'sendEmailButton')">{{__('Send Phone')}}</button>
            </div>

            <input type="text" class="form-control" id="messageType" name="messageType" style="display: none;">

            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
          </form>
    </div>
    {{-- <script src="API_Ops.js"></script> --}}
    {{-- <script type="text/javascript" src="{{asset('js/API_Ops.js') }}"></script> --}}
    <script type="text/javascript" src="{{ URL::asset('API_Ops.js') }}"></script>
    <script>

        function handleButtonClick(clickedButtonId, otherButtonId) {
            const clickedButton = document.getElementById(clickedButtonId);
            const otherButton = document.getElementById(otherButtonId);

            // Toggle clicked button active state
            clickedButton.classList.add('active');

            // Remove active state from the other button
            otherButton.classList.remove('active');
        }

        // Function to validate the form fields
        function validateForm() {
            var full_name = document.getElementById("full_name").value;
            var user_name = document.getElementById("user_name").value;
            var birthdate = document.getElementById("birthdate").value;
            var phone = document.getElementById("phone").value;
            var address = document.getElementById("address").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var user_image = document.getElementById("user_image").value;
            var email = document.getElementById("email").value;

            // Check if any field is empty
            if (full_name === "" || user_name === "" || birthdate === "" || phone === "" || address === "" || password === "" || confirm_password === "" || user_image === "" || email === "") {
                alert("All fields are mandatory.");
                return false;
            }

            // Check if email is valid
            var email_pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
            if (!email_pattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Check if birthdate is valid
            var birthdate_pattern = /^\d{4}-\d{2}-\d{2}$/;
            if (!birthdate_pattern.test(birthdate)) {
                alert("Please enter a valid birthdate (YYYY-MM-DD format).");
                return false;
            }

            // Check if full name contains only letters and spaces
            var full_name_pattern = /^[a-zA-Z\s]*$/;
            if (!full_name_pattern.test(full_name)) {
                alert("Please enter a valid full name (letters and spaces only).");
                return false;
            }

            // Check if password meets requirements (at least 8 characters with at least 1 number and 1 special character)
            var password_pattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
            if (!password_pattern.test(password)) {
                alert("Password must be at least 8 characters long and contain at least 1 number and 1 special character.");
                return false;
            }

            // Check if password matches confirm password
            if (password !== confirm_password) {
                alert("Passwords do not match.");
                return false;
            }

            if (!sendEmailButton.classList.contains('active') && !sendPhoneButton.classList.contains('active')) {
                alert('Please click on either "Send Email" or "Send Phone" button.');
                return false; // Prevent form submission
            }

            if(sendEmailButton.classList.contains('active'))
                document.getElementById("messageType").value = "email";
            else
                document.getElementById("messageType").value = "phone";

            // Validation passed
            return true;
        }
    </script>

    <style>
        .btn.active {
            background-color: #0d6efd;
            color: white;
        }
    </style>

@endsection
