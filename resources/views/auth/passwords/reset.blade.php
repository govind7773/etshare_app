
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
    .btn2{
        width:224px;
    }
        
    </style>
</head>
<body>
    <div class="container">
    <div class="form" >
            
            <form class="login" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="formGroup">
                    <input type="email" placeholder="Email ID" name="email"  required autofocus>
                         @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror  
                </div>
                <div class="formGroup">
                                <input id="password" type="password" name="password" placeholder="Enter New password" reuired>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                </div>
                <div class="formGroup">

        
                                <input id="password-confirm" type="password"  name="password_confirmation" required placeholder="Confirm password">

                </div>
                <div class="formGroup">
                    <button type="submit" class="btn2">
                    {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
    </div>
</body>

</html>
