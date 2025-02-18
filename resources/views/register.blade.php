<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="box">
    <span class="borderLine"></span>
    <form id="register-form">
        <h2>Sign up</h2>

        <div id="alert-container"></div> 

        <div class="input-box">
            <input type="text" id="name" name="name" required>
            <span>Nama Lengkap</span>
            <i></i>
        </div>

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

        <div class="input-box">
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span>Ulangi Password</span>
            <i></i>
        </div>

        <input type="submit"></input>
        <br>
        <div class="link_suki">
            Already have an account?
            <a href="login">Sign in</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#register-form').submit(function (e) {
            e.preventDefault(); 

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let confirm_password = $('#confirm_password').val();

            if (password !== confirm_password) {
                $('#alert-container').html('<div class="alert alert-danger">Password tidak cocok</div>');
                return;
            }

            $.ajax({
                url: "{{ route('register') }}",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $('#alert-container').html('<div class="alert alert-success">Registrasi berhasil! Redirecting to login...</div>');
                        setTimeout(function () {
                            window.location.href = "{{ route('login') }}"; 
                        }, 1500);
                    } else {
                        $('#alert-container').html('<div class="alert alert-danger">Registrasi gagal: ' + response.message + '</div>');
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan";
                    $('#alert-container').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                }
            });
        });
    });
</script>

</body>
</html>