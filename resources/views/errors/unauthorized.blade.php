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
                font-family: 'lato';
                src: url('{{ asset("assets/fonts/lato/Lato-Regular.ttf") }}')  format('truetype');
                font-weight: bold;
                font-style: normal;
            }
            body{
                background: #29090a;
                margin: 0px;
                background-image: url('{{ asset("assets/images/error/inspiration-geometry3.png") }}');
                font-family: 'lato';
                color: #111111;
            }
            .container{
                padding-top: 120px;
            }
            .panel{
                text-align: center;
                background: #ffffff;
                width: 600px;
                margin: auto;
                border-collapse: collapse;
            }
            .lock{
                border-right: 1px solid #d6d6d6;
                border-bottom: 1px solid #d6d6d6;
            }
            .lock img{
                width: 80px;
            }
            .access{
                border-bottom: 1px solid #d6d6d6;
            }
            .access img{
            }
            .panel-head{
                border-bottom: 1px solid #d6d6d6;
            }
            .panel-head td{
                padding: 10px 15px;
            }
            .panel-body td{                
                padding: 30px 20px 40px 20px;
            }
            .panel-body img{
                vertical-align: middle;
            }
            .link{
                color: #d80707;
                text-decoration: none;
                font-size: 18px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <table class="panel">
                <tr class="panel-head">
                    <td class="lock" ><img src="{{ asset('assets/images/error/padlock.png') }}"></td>
                    <td class="access"><img src="{{ asset('assets/images/error/access-denied.png') }}"></td>
                </tr>
                <tr class="panel-body">
                    <td colspan="2">
                        <p>You have tried to access a page that you have no permission to view. </p>
                        <a class="link" href="{{ url('/') }}"><img width="25px" src="{{ asset('assets/images/error/back.png') }}">
                        Go Back Home</a>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>