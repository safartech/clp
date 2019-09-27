@extends("default")
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('js/select2/css/select2.min.css') }}"--}}
          xmlns:v-bind="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml"
          xmlns:v-bind="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml"
          xmlns:v-bind="http://www.w3.org/1999/xhtml"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>--}}

    <style>
        .select2{
            width: 100%;
        }
        /*.select2-choice{
            min-height: 150px;
            max-height: 150px;
            overflow-y: auto;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-selection__rendered {
            line-height: 32px !important;
        }

        .select2-selection {
            height: 34px !important;
        }*/

    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}"></script>
    {{--<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/lib/fuelux/js/wizard.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('assets/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>--}}


    {{--<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('js/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/tooltip/tooltip.js') }}" type="text/javascript"></script>
   {{-- <script src="{{ asset('assets/lib/fuelux/js/wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('momentjs.moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/parsley/parsley.min.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('js/plugins/editable-table/mindmup-editabletable.js') }}"></script>
    <script src="{{ asset('js/plugins/editable-table/numeric-input-example.js') }}"></script>



    <script type="text/javascript">

       $(document).ready(function(){

//           $('[data-toggle="tooltip"]').tooltip()
           $('.tooltipped').tooltip({

           })
           //initialize the javascript
           /*App.wizard();
           App.dashboard();
           App.formElements();
           $('form').parsley();*/
//           $.fn.select2.defaults.set( "theme", "bootstrap" );
           $( ".select2" ).select2();

       });
    </script>

    <template type="text\template" id="releve">
        <div>
            <div class="col-lg-8">
                <div class="panel panel-default panel-border-color panel-border-color-primary coll">
                    <div class="panel-heading panel-heading-divider">Releves<span class="panel-subtitle">Impression des relevés de notes.</span></div>
                    <div class="panel-body">

                        <div class="col-lg-3">
                            <div class=""><label class="control-label">Classes</label></div>
                            <div class="">
                                <select id="select2-classe" class="select2" v-model="currentClasseId">
                                    <option :value="null" disabled selected  >Selectionner une classe</option>
                                    <option v-for="classe in classes"  @click="onClasseChange" :value="classe.id">@{{ classe.nom }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class=""><label>Matieres</label></div>
                            <div class="">
                                <select id="select2-matiere" class="select2 " @change="onMatiereChange()" v-model="currentMatiereId">
                                    <option :value="null" disabled selected  >Selectionner une matière</option>
                                    <option v-for="matiere in currentClasse.matiere"  :value="matiere.id">@{{ matiere.intitule }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class=""><label>Sessions</label></div>
                            <div class="">
                                <select id="select2-session" class="select2 " @change="onSessionChange()" v-model="currentSessionId">
                                    <option :value="null" disabled selected  >Selectionner une session</option>
                                    <option v-for="session in sessions" :value="session.id">@{{ session.nom }}</option>
                                </select>
                            </div>


                        </div>
                        <div class="col-lg-3">
                            <div class="btn-toolbar">
                                <label>Options</label>
                                {{--<div role="group" class="btn-xl btn-group btn-group-justified xs-mb-10">
                                    <a href="#" class="btn-xl btn btn-rounded btn-default">Recharger</a>
                                    --}}{{--<a href="#" class="btn-xl btn btn-default">Imprimer</a>--}}{{--
                                    <a href="#" class="btn-xl btn btn-rounded btn-default">Services</a>
                                </div>--}}
                                <div role="" class="">
                                    <a href="#" @click="reload" class="btn-xl btn  btn-default" data-toggle="tooltip" data-placement="top" title="Recharger les données"><i class="icon mdi mdi-refresh"></i></a>
                                    {{--<a href="#" class="btn-xl btn btn-default " title="Popover on top" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="icon mdi mdi-print"></i></a>--}}
                                    {{--<a href="#" class="btn-xl btn btn-default "><i class="icon mdi mdi-print"></i></a>--}}
                                    {{--<a href="#" class="btn-xl btn  btn-default active " data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="icon mdi mdi-settings"></i></a>--}}
                                    {{--<a href="#" class="btn-xl btn  btn-default active tooltipped" ><i class="icon mdi mdi-settings"></i></a>--}}
                                </div>

                            </div>
                            {{--<div class=""><label>Options</label></div>
                            <div class="">
                                <div class="btn-toolbar">
                                    <div class="btn-group btn-space">
                                        <button  type="button"  @click="reload" class="btn btn-warning btn-xl tooltipped"><i class="icon mdi mdi-refresh"></i></button>
                                        <button type="button" class="btn btn-default btn-xl" v-show="isReady">Options</button>
                                        <button type="button" data-toggle="dropdown" v-show="isReady" class="btn btn-primary dropdown-toggle btn-xl"><span class="mdi mdi-chevron-down"></span><span class="sr-only">Toggle Dropdown</span></button>
                                        <ul role="menu" class="dropdown-menu">
                                            <li @click="showEvaluationCreateModal"><a>Nouvelle évaluation</a></li>
                                            <li class="divider"></li>
                                            <li><a>Imprimer relevé</a></li>
                                        </ul>
                                    </div>
                                    --}}{{--<div class="btn-group btn-space">
                                        <button  type="button"  @click="reload" class="btn btn-warning tooltipped"><i class="icon mdi mdi-refresh">Recherger</i></button>
                                        <button type="button" class="btn btn-primary"><i class="icon mdi mdi-plus">Nouvelle évaluation</i></button>
                                        <a type="button" class="btn btn-danger"><i class="icon mdi mdi-print">Imprimer relevé</i></a>
                                        <button type="button" class="btn btn-default"><i class="icon mdi mdi-settings"></i></button>
                                        --}}{{----}}{{--<button type="button" class="btn btn-default"><i class="icon mdi mdi-favorite-outline"></i></button>--}}{{----}}{{--
                                    </div>--}}{{--
                                </div>
                            </div>--}}


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <img class="img-responsive" src="{{ asset('images/infos.jpg')}}"/>
            </div>

            {{--<div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading-divider">Légende<span class="panel-subtitle">Identification des couleur</span></div>
                    <div class="panel-body">
                        <div id="divConteneur">
                        <table class="table ">
                            <thead>
                            <tr>
                                <td class="text-center"><span class="label label-success">Evaluations Prise en compte pour le calcul de la moyenne de classe</span></td>
                                <td class="text-center" v-for="type in types"><span class="label" :class="getTypeLabelColor(type)">@{{ type.nom }}</span></td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>--}}
            <div class="col-sm-12" >
                <div class="panel panel-default">
                    <div class="panel-heading">{{--Liste des Notes d'évaluations:
                        Classe <b>(@{{ currentClasse.nom }})</b>
                        Effectif <b>(@{{ eleves.length }})</b>
                        Nombre d'évaluations <b>(@{{ evaluations.length }})</b>--}}
                        <div class="tools"><span class="icon mdi mdi-more-vert"></span></div>
                    </div>
                    <div class="panel-body">
                        <div id="divConteneur">
                        <table id="mainTable" class="table table-condensed table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th class="text-center">Télécharger releve de notes du @{{ currentSession.nom }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(eleve,i) in eleves">
                                <td>@{{ eleve.nom }}</td>
                                <td>@{{ eleve.prenoms }}</td>
                                <td class="text-center">
                                    <a :href="eleveReleveLink(eleve)" target="_blank" v-show="isReady" class="btn btn-primary-sm">Télécharger</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            {{--Modals--}}

        </div>
    </template>

    <script type="module" src="{{ asset('js/vues/admin/evaluations/releves.js') }}"></script>
@endsection

@section('content')
    <releve></releve>
@endsection