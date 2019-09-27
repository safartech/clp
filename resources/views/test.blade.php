<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/lib/bootstrap-slider/css/bootstrap-slider.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/material-design-icons/css/material-design-iconic-font.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
    {{--<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>--}}

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">

    <title>Document</title>
</head>
<body>
<br>
<br>
<div class="row">
    <div class="col-lg-12">
        <button id="btn" class="btn btn-primary center-block tooltipped">Ajuster</button>
    </div>

</div>




<script src="{{ asset('assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        $('.tooltipped').tooltip({
            delay:50,
            title:"Hello",
            placement:'bottom'
        })
        $('#btn').on('click',function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Echec de suppression',
                // (string | mandatory) the text inside the notification
                text: "Une erreur s'est produite lors de la suppression.",
                class_name: 'warning',
                time: 3000,
                position: 'top-right',
                sticky: false
            });
        })
    })

</script>
</body>
</html>