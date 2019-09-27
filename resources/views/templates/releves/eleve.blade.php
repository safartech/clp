<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    tr,th,td{
        padding: 0px;
        border:1px solid black;
    }

    td.note{
        width: 10%;
    }

    th.title{
        width: 50%;
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
<div class="container">
    <div class="col-lg-12">
        <div class="col-lg-2 pull-left text-center">
            <img src="{{ asset('images/2017cllogo.png') }}" width="100px" alt="">
            <br/>
            <br/>
        </div>
        <div class="col-lg-4">
            <br>
            <p><b>Rue 201, Agbalépédogan</b></p>
            <p><b>02 BP 20746 Lomé</b></p>
            <p><i>www.courslumiere.net</i></p>
        </div>
        <br>
        <div class="col-lg-2 text-center">
            <br>
            <p><b>Relevé du {{ $session->nom }}</b></p>
            <p><b>{{ $eleve->nom_complet }}</b></p>
            <p><i>Né@if($eleve->sexe=='F')e @endif le </i>{{ $eleve->date_nsce }}</p>
            <p><b>{{ $eleve->classe->nom }}</b> ({{ $eleve->classe->eleves->count() }} élèves)</p>
        </div>

    </div>
    <br>
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center title" colspan="2">Matières</th>
                <th class="text-center" colspan="{{ $count  }}">Evaluations <br>/10</th>
            </tr>
            </thead>
            <tbody>
            @foreach($matieres as  $matiere)

                @if(count($matiere->sousMatieres)==0)
                    <tr>
                        <td class="text-center title" colspan="2" style=""><b>{{$matiere->intitule }}</b></td>
                        {{--<b>{{ count($matiere->evaluations) }}</b>--}}
                        @for($i=0;$i<$count;$i++)
                            {{--@if(array_key_exists($i,$matiere->evaluations))@endif--}}
                            <td class="text-center note">{{ $matiere->evaluations[$i]->notes[0]->note ?? "" }}</td>
                        @endfor
                        {{--@foreach($matiere->evaluations as $evaluation)
                            <td>{{ $evaluation->eleves[0]->pivot->note }}</td>
                        @endforeach--}}
                    </tr>
                @else
                    <tr>
                        <td class="text-center title" colspan="2" style=""><b>{{$matiere->intitule }}</b></td>
                    </tr>
                    @foreach($matiere->sousMatieres as $sousMatiere)
                        @if(count($sousMatiere->modules)==0)
                            <tr>
                                <td>{{ $sousMatiere->nom }}</td>
                                <td></td>
                                @for($i=0;$i<$count;$i++)
{{--                                    @if(array_key_exists($i,$sousMatiere->evaluations))@endif--}}
                                    <td class="text-center note">{{ $sousMatiere->evaluations[$i]->notes[0]->note ?? "" }}</td>
                                @endfor
                                {{--@foreach($sousMatiere->evaluations as $evaluation)
                                    <td>{{ $evaluation->eleves[0]->pivot->note }}</td>
                                @endforeach--}}
                            </tr>
                        @else
                            <tr>
                                <td rowspan="{{ count($sousMatiere->modules) }}">{{ $sousMatiere->nom }}</td>
                                <td>{{ $sousMatiere->modules[0]->nom }}</td>
                                @for($i=0;$i<$count;$i++)
{{--                                    @if(array_key_exists($i,$sousMatiere->modules[0]->evaluations))--}}
                                        <td class="text-center">{{ $sousMatiere->modules[0]->evaluations[$i]->notes[0]->note ?? "" }}</td>
                                    {{--@endif--}}
                                @endfor
                            </tr>
                            @foreach($sousMatiere->modules as $i=>$module)
                                @if($i==0)  @else
                                <tr>
                                    <td>{{ $module->nom }}</td>
                                    @for($i=0;$i<$count;$i++)
{{--                                        @if(array_key_exists($i,$module->evaluations))--}}
                                            <td class="text-center note">{{ $module->evaluations[$i]->notes[0]->note ?? "" }}</td>
                                        {{--@else <td></td>--}}
                                        {{--@endif--}}
                                    @endfor
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    {{--<tr class="text-center">
                        <td rowspan="{{ count($matiere->sousMatieres) }}">{{$matiere->intitule }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td rowspan="{{ count($matiere->sousMatieres) }}">{{ $matiere->intitule }}</td>
                        @if(count($matiere->sousMatieres[0]->modules)==0)
                            <td >{{ $matiere->sousMatieres[0]->nom }}</td>
                            <td></td>
                            @else
                        @endif
                    </tr>
                    @foreach($matiere->sousMatieres as $i=> $sousMatiere)
                        @if($i==0) @continue @endif
                        @if(count($sousMatiere->modules)==0)
                            <tr>
                                <td>{{ $sousMatiere->nom }}</td>
                                <td></td>
                            </tr>
                        @else
                            <tr>
                                <td rowspan="{{ count($sousMatiere->modules) }}">{{ $sousMatiere->nom }}</td>
                                <td>{{ $sousMatiere->modules[0]->nom }}</td>
                            </tr>
                            @foreach($sousMatiere->modules as $j=> $module)
                                @if($j==0) @continue @endif
                                <tr>
                                    <td>{{ $module->nom }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach--}}
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>