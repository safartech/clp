<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestschool - COURS LUMIERE</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/lib/bootstrap-slider/css/bootstrap-slider.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/material-design-icons/css/material-design-iconic-font.min.css') }}"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{--<link rel="stylesheet" type="text/css" href="assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="assets/lib/jqvmap/jqvmap.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
    @yield('css')
    <style>
        .select2{
            width: 100%;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" type="text/css"/>

</head>
<body>

<div class="be-wrapper be-fixed-sidebar">
    @include('layouts.navbars.main')

    @include('layouts.sidebars.main')


    <div class="be-content">
        <div class="main-content container-fluid">


            <div id="app" >
                <div class="">
                    @yield('content')
                </div>

            </div>
            
        </div>
    </div>

    {{--Modals--}}
    <div id="loader" tabindex="-1" role="dialog" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="text-primary">
                            <img src="{{ asset('loaders/loader_seq.gif') }}" alt="">
                        </div>
                        <h3>Chargement...</h3>
                        <p>Veuillez patienter le temps que les données soit totalement chargées. Merci</p>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/momentjs/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/momentjs/moment-with-locales.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        //initialize the javascript
       function momento (date) {
           return moment(date).format('DD MMMM YYYY')
       }
        App.init();
//        App.uiNotifications();

        /*ajax request to get information*/
        var info="Aucune Information à afficher"
        $('#info_title').html(info)
        $('#info_content').html('')
        $('#info_updated_at').html('')

        var request = $.ajax({
            url: "/ajax/get_valid_information",
            type: "GET",
        });

        request.done(function(response) {
            console.log(response)
            info=response

            $('#info_title').html(info.title)
            $('#info_content').html(info.content)
            var updated_at="Modifié le "+momento(info.updated_at.split(" ")[0]);
            $('#info_updated_at').html(updated_at)

        });

        request.fail(function(jqXHR, textStatus) {
            console.log("Request failed: " + textStatus );
        });
    });
</script>

@yield('js')
</body>
</html>