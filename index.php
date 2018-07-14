<?php

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Simple HttpErrorPages | MIT License | https://github.com/AndiDittrich/HttpErrorPages -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verkeerde configuratie | 501 - Not Implemented</title>
    <link rel="stylesheet" href="%s/style.css">
</head>
<body>
    <div class="cover">
        <h1>Not Implemented <small>Error 501</small></h1>
        <p class="lead">This website is not supposed to be user-visible.</p>
        <p>
            Admins: Please verify the Site URL is pointed to the Corcel webpage,
            and not to the WordPress installation.
        </p>
    </div>
    <footer>
        <p>© Gumbo Millennium %d. All Rights Reserved</p>
    </footer>
</body>
</html>
HTML;

vprintf($html, [
    get_template_directory_uri(),
    date('Y', strtotime('+30 days'))
]);
