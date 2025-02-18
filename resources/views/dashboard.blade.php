<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h2>Welcome, <span id="username"></span></h2>
    <button id="btn_logout">Logout</button>

    <script>
        $(document).ready(function () {
            $.get('/dashboard-data', function (data) {
                if (data.success) {
                    $('#username').text(data.user.username);
                } else {
                    window.location.href = "/login";
                }
            });

            $('#btn_logout').click(function () {
                $.post('/logout', { _token: $('meta[name="csrf-token"]').attr('content') }, function () {
                    window.location.href = "/login";
                });
            });
        });
    </script>

</body>
</html>