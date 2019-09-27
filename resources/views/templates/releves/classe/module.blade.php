<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{--    <link href="{{ asset('assets/materialize/css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection">--}}
    {{--<link href="{{ asset('assets/materialize/css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection">--}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">

    <title>Document</title>
</head>

<style>
    table.table-bordered{
        border:1px solid black;
        margin-top:20px;
        /*padding: 0px;*/
    }
    table.table-bordered > thead > tr > th{
        border:1px solid black;
        /*padding: 0px;*/
    }
    table.table-bordered > tbody > tr > td{
        border:1px solid black;
        padding-bottom: 2px;
        padding-top: 1px;
    }

    body{
        font-size: 11px;
    }
    .grey{
        background-color: #e4e4e4;
    }

    td.title{
        width: 10%;
    }
    td.desc{
        width: 50%;
    }
    th.moy{
        width: 10%;
    }
    th.appres{
        width: 30%;
    }
    th.title-header{
        width: 60%;
    }
</style>

<body>
<br>
<br>
<div class="container">
    <div class="col s12">
        <div class="">
            <h5><u>Professeur: </u>@if(Auth()->user()->isEnseignant()) {{ Auth()->user()->personnel->nom_complet }}@else {{ Auth()->user()->name }} @endif</h5>
            <h5><u>Classe:</u> {{ $classe->nom }}</h5>
            <h5><u>Effectif:</u> {{ sizeof($eleves) }}</h5>
            <h5><u>Matiere:</u> {{ $module->sousMatiere->matiere->intitule }}</h5>
            <h5><u>Sous-matiere:</u> {{ $module->sousMatiere->nom }}</h5>
            <h5><u>Module:</u> {{ $module->nom }}</h5>
        </div>

        <h3 class="text-center"><u>Releve de Note: <b>{{ $module->nom }}</b> <i>({{ $session->nom }})</i></u></h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th></th>
                @foreach($evals as $eval)
                    <th>{{ $eval->created_at->toDateString() }}</th>
                @endforeach
            </tr>
            <tr>
                <th>{{ sizeof($eleves) }} élèves </th>
                <th>Moyenne</th>
                @foreach($evals as $eval)
                    {{--<th>Sur {{ $eval->notation }} (Coef {{ $eval->coef }})</th>--}}
                    <th>Sur {{ $eval->notation }}</th>
                @endforeach
            </tr>
            </thead>

            <tbody class="table table-bordered">
            @foreach($eleves as $eleve)
                <tr>
                    <td>{{ $eleve->nom_complet }}</td>
                    @php
                        $off = 0;
                        $total = 0;
                        $moy = 0;
                                foreach ($eleve->evaluations as $e){
                                if(!$e->pivot->note || $e->pivot->note==""){
                                $off+=1;
                                }else{
                                $total = floatval($total) + floatval($e->pivot->note);
                                }
                                }

                                if (sizeof($eleve->evaluations) == 0 ){
                                $moy = "";
                                }
                                elseif ($off == sizeof($eleve->evaluations)){
                                $moy = "";
                                }
                                else{
                                $moy = number_format((floatval($total) / (sizeof($eleve->evaluations))),2);
                                }



                    @endphp
                    <td>{{ $moy }}</td>
                    @foreach($eleve->evaluations as $e)
                        <td>{{ $e->pivot->note }}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>

        </table>

        <br>
        <br>
        <br>

    </div>
</div>
</body>
</html>