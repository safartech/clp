<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gestschool</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background: linear-gradient(-45deg,rgba(10, 169, 229, 0.7), rgba(85, 255, 254, 0.8)),url("http://localhost/gestschool/public/imgs/bg02.jpg");background-size:cover;background-repeat:no-repeat;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                color: #fff;
            }

            .links > a {
                color: #fff;
                padding: 0 7px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .links > a:hover {
                color: #fff;
                margin-top: 5px;
                padding: 0 7px;
                font-size: 15px;
                font-weight: 900;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                transition: .2s ease .2s;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .tex{
                font-size: 35px;
                color: white;
            }

            @media(max-width: 600px){

                .title {
                    margin-top: 30px;
                    font-size: 40px;
                    color: #fff;
                    font-weight: 400;
                }
                .tex{
                    font-size: 20px;
                    color: white;
                    font-weight: 600;
                }

            }


        </style>
    </head>
    <body>
        <div id="LoginForm" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ route('voyager.dashboard') }}">Administration</a>
                    @auth
                        <a href="{{ url('/home') }}">Accueil</a>
                    @else
                        <a href="{{ route('login') }}">Se connecter</a>
                        {{--<a href="{{ route('register') }}">S'inscrire</a>--}}
                    @endauth
                </div>
            @endif

            <div class="content">
            <img class="img-responsive" style="width: 70%" src="{{asset('images/sign-c.png')}}"/>
                <div class="title m-b-md">
                    GESTSCHOOL
                </div>
                <p class="tex">Toute son école en poche !</p>
                {{--<div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>--}}
            </div>
        </div>
    </body>
</html>
