<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LEKAR</title>
        <style>
            @font-face {
                font-family: 'helvetica-neue-bold';
                src: url('{{ asset("assets/fonts/helvetica-neue/HelveticaNeueBold.ttf") }}')  format('truetype');
                font-weight: bold;
                font-style: normal;
            }
            body{
                background: #29090a;
                margin: 0px;
                background-image: url('{{ asset("assets/images/error/inspiration-geometry3.png") }}');
            }
            .container{
                text-align: center;
                padding-top: 100px;
            }
            .person{
                width: 200px;
            }
            .text{
                width: 450px;
            }
            .link{
                background: #ed1c24;
                color: #fff;
                text-decoration: none;
                padding: 14px 27px;
                font-family: 'helvetica-neue-bold';
                font-size: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img class="person" src="{{ asset('assets/images/error/icon-404.png') }}"><br>
            <img class="text" src="{{ asset('assets/images/error/icon-text404.png') }}"><br><br>
            <a class="link" href="{{ url('/') }}">Try going to our HOMEPAGE</a>
        </div>
    </body>
</html>