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
        <h3 class="text-center"><u>Evaluation par compétence</u></h3>
        <h5><u>Elève: <b>{{ $eleve->nom_complet }}</b></u></h5>
        <h5><u>Classe: <b>{{ $classe->nom }}</b></u></h5>
        <h5><u>Effectif: <b>{{ sizeof($classe->eleves) }}</b></u></h5>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center" rowspan="2" colspan="2">COMPETENCES DEVANT ETRE ACQUISES EN {{ $classe->nom }}</th>
                <th class="text-center" colspan="3">{{ $classe->nom }}</th>
            </tr>
            <tr>
                <th class="text-center cpt" style="width: 5%">T1</th>
                <th class="text-center cpt" style="width: 5%">T2</th>
                <th class="text-center cpt" style="width: 5%">T3</th>
            </tr>
            </thead>

            <tbody class="table table-bordered">
            @foreach($matieres as $matiere)
                <tr><td class="text-center" colspan="5">{{ $matiere->intitule }}</td></tr>
                @foreach($matiere->domaines as $domaine)
                    <tr><td colspan="5" class="text-center">{{ $domaine->nom }}</td></tr>
                    @foreach($domaine->competences as $competence)
                        <tr>
                            <td style="width: 10%"></td>
                            <td>{{ $competence->nom }}</td>
                            @foreach($sessions as $i=>$session)
                                <td>{{ $competence->epcs[$i]->validation ?? "" }}</td>
                            @endforeach
                        </tr>
                    @endforeach

                @endforeach
            @endforeach
            </tbody>
            {{--@foreach($matieres as $matiere)
                <table class="table table-bordered">
                    <thead>
                    <tr><th class="text-center" colspan="5">{{ $matiere->intitule }}</th></tr>
                    </thead>

                    @foreach($matiere->domaines as $domaine)
                        <tbody class="">
                        <tr><td colspan="5" class="text-center">{{ $domaine->nom }}</td></tr>
                        @foreach($domaine->competences as $competence)
                            <td></td>
                            <td>{{ $competence->nom }}</td>

                        @endforeach
                        </tbody>
                    @endforeach

                </table>
            @endforeach--}}

        </table>

        <br>
        <br>
        <br>

    </div>
</div>
</body>
</html>