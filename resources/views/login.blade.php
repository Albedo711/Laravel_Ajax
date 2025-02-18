<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="box">
    <span class="borderLine"></span>
    <form id="login-form">
        <h2>Sign in</h2>

        <div id="alert-container"></div> 

        <div class="input-box">
            <input type="text" id="email" name="email" required>
            <span>Email</span>
            <i></i>
        </div>

        <div class="input-box">
            <input type="password" id="password" name="password" required>
            <span>Password</span>
            <i></i>
        </div>

        <div class="link">
            <input type="checkbox" id="remember">
            <p>Remember me</p>
            <a href="#">Forgot Password?</a>
        </div>

        <input type="submit"></input>
        <br>
        <div class="link_suki">
            Don't have an account?
            <a href="register">Sign up</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#login-form').submit(function (e) {
            e.preventDefault(); 

            $.ajax({
                url: "{{ route('login') }}",
                type: "POST",
                data: {
                    email: $('#email').val(),
                    password: $('#password').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('#alert-container').html('<div class="alert alert-success">Login successful! Redirecting...</div>');
                        setTimeout(function () {
                            window.location.href = "{{ route('dashboard') }}"; 
                        }, 1500);
                    } else {
                        $('#alert-container').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "An error occurred";
                    $('#alert-container').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                }
            });
        });
    });
</script>

</body>
</html>