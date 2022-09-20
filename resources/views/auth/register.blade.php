<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ETShare') }}</title>
    <!-- jQuery CDN Link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .loginBtn a{
                text-decoration: none;
                color: white;
        }
        .signUpBtn a{
                text-decoration: none;
                color: white;
                border-bottom : 2px solid #ff4141;
            }
    </style>
</head>

<body>
    <div class="container">
        <div class="form">
            <div class="btn">
                <button class="loginBtn"><a href="{{ route('login') }}">{{ __('Login') }}</a></button>
                <button class="signUpBtn"><a href="{{ route('register') }}">{{ __('Register') }}</a></button>
            </div>
            <form class="signUp" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="formGroup">
                    <input type="text" id="userName" placeholder="User Name"  name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                <div class="formGroup">
                    <input type="email" placeholder="Email ID" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="formGroup">
                    <input type="password" id="password" placeholder="Password" name="password" required autocomplete="new-password">
                </div>
                <div class="formGroup">
                    <input type="password" id="confirmPassword" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="formGroup">
                    <button type="submit" class="btn2">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
