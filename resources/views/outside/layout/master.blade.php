<!doctype html>
<html lang="en">
<head>
    <title>Pay</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
@yield('content')

<script>
    var methods = {
        sendDataToParent: function (type, data) {
            var params = {
                type: type, //РўРёРї СЃРѕР±С‹С‚РёСЏ: [РљРћРќРЎРўРђРќРўРђ]
                data: data // Р”Р°РЅРЅС‹Рµ
            };
            params = JSON.stringify(params);
            window.parent.postMessage(params, '*');
        }
    };

    jQuery(document).ready(function ($) {
        $('#closeBtn').on('click', function () {
            methods.sendDataToParent('CLOSE', true);
        });
    });
</script>

@stack('script')

</body>
</html>
