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
    .appre{
        /*position: relative;*/
        text-align: center;
        /*top: 50%;*/
        /*bottom: 50%;*/
    }

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
        font-size: 10px;
    }

    .matiere-line{
        background-color: #d0d0d0;
    }

    .grey{
        background-color: #f9f9f9;
    }

    td.title{
        width: 10%;
    }
    td.desc{
        width: 50%;
        font-size: 10px;
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
    {{--style="border: grey solid 1px"--}}
    <div class="row">
        <div class="col-lg-12" >
            <div class="col-lg-2 pull-left text-center">
                <img src="{{ asset('images/2017cllogo.png') }}" width="100px" alt="">
                <br/>
                <br/>
            </div>
            <div class="col-lg-2 pull-left">
                <br>
                <p><b>Rue Dansou</b></p>
                <p><b>02 BP 20746 Lomé</b></p>
                <p><i>www.courslumiere.net</i></p>
            </div>
            <br>
            <div class="col-lg-4 pull-right">
                {{--<br>--}}
                {{--<p><b>Relevé du {{ $session->nom }}</b></p>--}}
                <p><b>{{ $eleve->nom_complet }}</b></p>
                @if($eleve->date_nsce)<p><i>Né @if($eleve->sexe=='F')e @endif le {{  $eleve->date_nsce->format('d-m-Y') ?? "" }}</p>  @endif
                <p><b>{{ $eleve->classe->nom }}</b> ({{ $eleve->classe->eleves->count() }} élèves)</p>
                <p>Enseignant: <b>{{ $prof->nom_complet ?? "" }}</b></p>
            </div>

        </div>
    </div>
    <div class="row">
        {{--<br>--}}
        {{--<br>--}}
        {{--<br>--}}
        <br>
    </div>
    <div class="row">
        <h4 class="text-center"><b>BULLETIN DU {{ $session->nom }}</b></h4>
        <h6 class="text-center"><b>Année scolaire 2018 - 2019</b></h6>
    </div>
    <div class="row">
        {{--<br>--}}
        {{--<br>--}}
        {{--<br>--}}

        <br>
    </div>
    <div class="col s12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center title-header" colspan="2">DOMAINES D'ENSEIGNEMENT</th>
                <th class="text-center moy">Moyenne <br>(sur 10)</th>
                <th class="text-center appres">Appréciation et observations</th>
            </tr>
            </thead>
            <tbody>
            @php
                $list_des_moyennes_de_matieres = [];
            $moyenneEleve = 0
            @endphp
            @foreach($matieres as $matiere)

                <tr class="matiere-line"><td colspan="4" class="text-center "><b>{{ strtoupper($matiere->intitule)  }}</b></td></tr>
                @if(count($matiere->sousMatieres)== 0)
                    <tr>
                        <td class="desc grey" colspan="2" style="font-size: 10px">{{ $matiere->description }}</td>
                        {{--@foreach($matiere->evaluations as $evaluation)
                            @for
                        @endforeach--}}
                        @php

                            $moy = 0;
                            $pas_de_note = 0;
                            $total = 0;
                            $nbre_ev = count($matiere->evaluations);
                            $notes = [];

                    foreach ($matiere->evaluations as $evaluation){

                    if($nbre_ev>0)
                        $n = $evaluation->notes[0]->note;
                        /*foreach ($evaluation->notes as $l=> $note){
                         $n = $note->note;
                        }*/

                        if (is_numeric($n)){
                        $total+=$n;
                        $notes[] = $n;
                        }
                    }
                    if(count($notes)>0){
                            $moy = $total/count($notes);
                            if(is_numeric($moy)){
                            $list_des_moyennes_de_matieres[] =  number_format($moy,2) ;

                            }

                            }

                            /*else
                            $moy = 0;*/

                        @endphp
                        <td class="text-center">{{ is_numeric($moy)? number_format($moy,2) :"" ?? ""}} </td>
                        <td class="" style="font-size: 10px">{{ $matiere->appreciations[0]->appreciation ?? ""}}</td>
                    </tr>
                @else
                    @php
                        $liste_des_moyennes_de_sm = [];
                    @endphp
                    @foreach($matiere->sousMatieres as $sousMatiere)

                        @if(count($sousMatiere->modules)==0)

                            <tr>
                                <td class="grey title text-center"><b>{{ $sousMatiere->nom }}</b></td>
                                <td class="grey desc"  style="font-size: 10px">{{ $sousMatiere->description }}</td>

                                @php
                                    $moy = null;
                                    $n=null;
                                $pas_de_note = 0;
                                $total = 0;
                                $nbre_ev = count($sousMatiere->evaluations);
                                $notes = [];
                            foreach ($sousMatiere->evaluations as $e=> $evaluation){
                            if(count($evaluation->notes)>0){$n = $evaluation->notes[0]->note;}


                               if (is_numeric($n) && $n!=null && $n!=""){
                            $total += $n;
                           $notes[] = $n;
                            }
                            }

                            if(count($notes)>0){

                            $moy = $total/count($notes);
                            if(is_numeric($moy)){
                            $liste_des_moyennes_de_sm [] =  number_format($moy,2) ;
                            }
                            }

                                /*else
                                $moy = 0;*/


                                @endphp

                                <td class="text-center">{{ is_numeric($moy)? number_format($moy,2) :"" ?? ""}} </td>
                                <td class="" style="font-size: 10px">{{ $sousMatiere->appreciations[0]->appreciation ?? ""}}</td>
                            </tr>
                        @else
                            @php
                                $liste_de_moyennnes_de_modules = [];
                            @endphp
                            <tr>
                                <td class="grey title text-center" rowspan="{{ count($sousMatiere->modules) }}"><b>{{ $sousMatiere->nom }}</b></td>
                                <td class="grey desc" style="font-size: 10px"><b>{{ $sousMatiere->modules[0]->nom }}</b> : {{ $sousMatiere->modules[0]->description }}</td>
                                @php
                                    $moy = null;
                                    $n=0;
                                $pas_de_note = 0;
                                $total = 0;
                                $nbre_ev = count($sousMatiere->modules[0]->evaluations);
                                $notes = [];
                            foreach ($sousMatiere->modules[0]->evaluations as $e=> $evaluation){
                            if($nbre_ev>0)
                            $n = $evaluation->notes[0]->note;

                               if (is_numeric($n)){
                            $total += $n;
                           $notes[] = $n;
                            }
                            }

                            if(count($notes)>0){
                            $moy = $total/count($notes);

                            if(is_numeric($moy)){

                            $liste_de_moyennnes_de_modules[] = number_format($moy,2);

                            }


                            }
                                @endphp
                                <td class="text-center">{{ is_numeric($moy)? number_format($moy,2) :"" ?? ""}}</td>
                                <td class="" style="font-size: 10px">{{ $sousMatiere->modules[0]->appreciations[0]->appreciation ?? ""}}</td>
                            </tr>
                            @foreach($sousMatiere->modules as $i=>$module)
                                @if($i==0) @continue @endif
                                <tr>
                                    <td class="grey desc " style="font-size: 10px"><b>{{ $module->nom }}</b > : {{ $module->description }}</td>
                                    @php
                                        $moy = null;
                                $pas_de_note = 0;
                                $total = 0;
                                $nbre_ev = count($module->evaluations);
                                $notes = [];
                                foreach ($module->evaluations as $e=> $evaluation){
                                    if($nbre_ev>0)
                                    $n = $evaluation->notes[0]->note;

                               if (is_numeric($n)){
                            $total += $n;
                           $notes[] = $n;
                            }

                                }
                                if(count($notes)>0){
                            $moy = $total/count($notes);
                            if(is_numeric($moy)){
                            $liste_de_moyennnes_de_modules[] = number_format($moy,2);
                            }

                            }

                                /*else
                                $moy = 0;*/

                                    @endphp
                                    <td class="text-center">{{ is_numeric($moy)? number_format($moy,2) :"" ?? ""}}</td>
                                    <td class="" style="font-size: 10px">{{ $module->appreciations[0]->appreciation ?? ""}}</td>
                                </tr>
                            @endforeach

                            @php
                                if(count($liste_de_moyennnes_de_modules)>0)
                                    $liste_des_moyennes_de_sm[] = array_sum($liste_de_moyennnes_de_modules)/count($liste_de_moyennnes_de_modules);
                            @endphp
                        @endif
                    @endforeach
                    @php

                        if(count($liste_des_moyennes_de_sm)>0)
                            $list_des_moyennes_de_matieres[] = array_sum($liste_des_moyennes_de_sm)/count($liste_des_moyennes_de_sm);



                    @endphp
                @endif
            @endforeach
            @php
                //dd($list_des_moyennes_de_matieres);
                    $moyenneEleve = array_sum($list_des_moyennes_de_matieres)/count($list_des_moyennes_de_matieres);
            @endphp
            </tbody>
        </table>

        <table class="table table-bordered">
            <tr class="grey">
                <td class="" width="50%">Nombre d'absences</td>
                {{--<td class="text-center">{{ $abs->nombre ?? "" }}</td>--}}
                <td class="text-center">{{ $conseil->absences ?? count($eleve->absences) ?? ""}}</td>
            </tr>
            <tr class="matiere-line">
                <td class="text-center" colspan="2"><b>COMPORTEMENT ET VIE SCOLAIRE</b></td>
            </tr>
            <tr>
                <td>Attention, concentration</td>
                <td>{{ $conseil->attention ?? "" }}</td>
            </tr>
            <tr>
                <td>Participation</td>
                <td>{{ $conseil->participation ?? "" }}</td>
            </tr>

            <tr class="matiere-line">
                <td class="text-center" colspan="2"><b>ATTITUDE FACE AU TRAVAIL</b></td>
            </tr>
            <tr>
                <td>Rythme de travail</td>
                <td>{{ $conseil->rythme ?? "" }}</td>
            </tr>
            <tr>
                <td>Présentation, écriture soin</td>
                <td>{{ $conseil->ecriture ?? "" }}</td>
            </tr>
            <tr>
                <td>Autonomie et initiative</td>
                <td>{{ $conseil->autonomie ?? "" }}</td>
            </tr>


        </table>

        <br>

        <table class="table table-bordered">
            {{--<tr>
                <td class="grey"><b>Moyenne de l'élève</b></td>
                <td class="text-center grey">{{ $moyenneEleve }}/10</td>

            </tr>
            <tr class="grey">
                <td><b>Moyenne de la classe</b></td>
                <td class="text-center">{{ $moyenneClasse }}/10</td>
            </tr>--}}
            <tr style="height: 100px">
                <td rowspan="2" style="height: 100px"><b>Signature de la Directrice</b></td>
                <td colspan="2"><b>OBSERVATIONS GENERALES: </b> <div style="font-size: 12px">{{ $conseil->og ?? "" }}
                        <br>
                        <br>
                    </div></td>
                <td rowspan="2"><b>Signature des Parents</b></td>
            </tr>
            <tr style="height: 100px">
                <td colspan="2"><b>Signature de(s) enseignant(s)</b>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
        </table>

    </div>
</div>
</body>
</html>