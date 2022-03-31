<!DOCTYPE html>
<html>
    <head>
        <?php
            $company = \Models\company::where('code','HSP')->first();
            $name = isset($company)? $company->name : 'Hadijaya Solusi Pangan';
            $logo = isset($company)? asset($company->logo) : asset('assets/images/templates/ranchdeli.png');
            $desc = isset($company->desc)? $company->desc : '';
            $favicon = isset($company->favicon)? asset(ucwords(strtolower($company->favicon))) : '';
        ?>

        <meta name="description" content="{{ $desc }}">
        <meta name="author" content="{{ $name }}">

        <meta property="og:type" content="article">
        <meta property="og:site_name" content="{{ isset($company)? $company->code : 'HSP' }}">
        <meta property="og:title" content="{{ $name }}">
        <meta property="og:image" content="{{ $favicon }}">
        <meta property="og:description" content="{{ $desc }}">

        <title>{{$name}}</title>
        <link rel="icon" href="{{ $favicon }}">

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Be right back.</div>
            </div>
        </div>
    </body>
</html>
