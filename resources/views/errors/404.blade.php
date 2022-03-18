<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LEKAR</title>

        <script src="https://kit.fontawesome.com/31c8d4e018.js" crossorigin="anonymous"></script>
        <style>
            body{
                background: #ef9a1e;
                margin: 0px;
                position:relative;
                background-image: url('{{ asset("assets/images/error/inspiration-geometry3.png") }}');
                font-family: 'Helvetica', 'Arial', sans-serif;
                color: #fff;
            }
            .container{
                padding-top: 120px;
            }
            .panel{
                text-align: center;
                width: 100%;
                height:100%;
                margin: auto;
                border-collapse: collapse;
            }
            .panel td{
                padding: 0 20px;
            }
            i{
                font-size:70px;
                margin-bottom:5px
            }
            .title{
                margin:10px;
                font-size:20px
            }
            a{
                margin-top:20px;
                background:#fff;
                text-decoration:none;
                padding:15px 20px;
                color: #e46d10;
                border-radius:10px;
                display:inline-block
            }
        </style>
    </head>
    <body>
        <div class="container">
            <table class="panel">
                <tr>
                    <td>
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <br>
                        <div class="title">404 NOT FOUND</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>You have tried to access a page that you have no permission to view.</div>
                        <a href="{{ url('/') }}">Go Back Home</a>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>