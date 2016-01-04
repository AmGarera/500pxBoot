<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="js/bootstrap.js">
    <link rel="stylesheet" href="js/bootstrap.min.js">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="js/500px.js"></script>
</head>
<body>
<?php include 'Header.html' ;?>
<script>
    $(function) () {
        _500px.init({
            sdk_key: 'Put Your SDK Here'
        });

        /*JQuery to Determine Login Status*/
        _500px.on('authorization_obtained', function () {
            $('#not_logged_in').hide();
            $('#logged_in').show();

            /*Request The User ID*/
            _500px.api('/users', function (response) {
                var me = response.data.user;

                /*Get User Favorites*/
                _500px.api('/photos', { feature: 'user_favorites', user_id: me.id }, function (response) {
                    if (response.data.photos.length == 0) {
                        alert('You have no Favorites! :(');
                    }    else {
                        $.each( response.data.photos, function () {
                            $('#logged_in').append('<img src="' + this.image_url + '" />');
                            
                        });
                    }

                });
            });
        });

        _500px.on('logout', function () {
            $('#not_logged_in').show();
            $('#logged_in').hide();
            $('#logged_in').html('');
        });

        /*If the user has already logged in & authorized your application, this will fire an 'authorization_obtained' event*/
        _500px.getAuthorizationStatus();

        /*If the user clicks the login link, log them in*/
        $('#login').click(_500px.login);
    }
</script>

<h1><strong>Access your 500px favorite photos in one click!</strong></h1>

<div id="not_logged_in">
    <a href="#" id="login">Login to 500px</a>
</div>
<div id="logged_in" style="display: none;">
</div>






<?php include 'Footer.html' ;?>
</body>
</html>





