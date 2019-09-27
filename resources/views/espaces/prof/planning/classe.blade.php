@extends("default")
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>--}}
        <link rel="stylesheet" type="text/css" href="{{ asset('js/select2/css/select2.min.css') }}">
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.fullcalendar/fullcalendar.min.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/fullcalendar/css/fullcalendar.css') }}"/>
    <style>
        .select2{
            width: 100%;
        }
        .index{
            cursor: pointer;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('js/select2/js/select2.js') }}" type="text/javascript"></script>--}}

    {{--<script src="{{ asset('assets/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('js/momentjs/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/momentjs/moment-with-locales.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('assets/lib/jquery.fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('js/plugins/fullcalendar/js/fullcalendar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/fullcalendar/js/locale-all.js') }}" type="text/javascript"></script>
    {{--<script src="{{ asset('js/plugins/fullcalendar/fullcalendar-script.js') }}" type="text/javascript"></script>--}}


    <script type="text/javascript">

        $(document).ready(function(){

            App.pageCalendar();
//           $('[data-toggle="tooltip"]').tooltip()
            $('.tooltipped').tooltip({

            });

            $( ".select2" ).select2();

        });
    </script>

    <template id="classes" type="text\template">
        <div>
            <div class="col-lg-8">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Emplois du temps<span class="panel-subtitle">Plannification de l'emplois du temps des classes.</span></div>
                    <div class="panel-body">

                        {{--Cycles--}}
                        {{--<div class="col-lg-3">
                            <div class=""><label>Cycles</label></div>
                            <div class="">
                                <select id="select2-cycle" class="select2 " v-model="selectedCycleId">
                                    <option :value="0" disabled selected  >Selectionner un cycle</option>
                                    <option v-for="cycle in cycles"  :value="cycle.id">@{{ cycle.nom }}</option>
                                </select>
                            </div>
                        </div>--}}

                        {{--Niveaux--}}
                        {{--<div class="col-lg-3">
                            <div class=""><label>Niveau</label></div>
                            <div class="">
                                <select id="select2-niveau" class="select2 "  v-model="selectedNiveauId">
                                    <option :value="0" disabled selected  >Selectionner une niveau</option>
                                    <option v-for="niveau in niveaux" :value="niveau.id">@{{ niveau.nom }}</option>
                                </select>
                            </div>
                        </div>--}}

                        <div class="col-lg-3 col-md-offset-6">
                            <div class=""><label class="control-label">Classes</label></div>
                            <div class="">
                                <select id="select2-classe" class="select2">
                                    <option value="0" disabled selected  >Selectionner une classe</option>
                                    <option v-for="classe in classes" :value="classe.id">@{{ classe.nom }}</option>
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
                                <div  class="" role="group">
                                    <a href="#" @click="reload" class="btn-xl btn  btn-default" data-toggle="tooltip" data-placement="top" title="Recharger les données"><i class="icon mdi mdi-refresh"></i></a>
                                    {{--<a href="#" class="btn-xl btn btn-default " title="Popover on top" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="icon mdi mdi-print"></i></a>--}}
                                    <a href="#" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Imprimer emploi du temps"><i class="icon mdi mdi-print"></i></a>
                                    {{--<a href="#" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Programmer un cours" @click="showCoursCreatorModal"><i class="icon mdi mdi-plus"></i></a>--}}
                                    {{--<a href="#" class="btn-xl btn  btn-default active " data-toggle="tooltip" data-placement="top" title="Option inactive"><i class="icon mdi mdi-settings"></i></a>--}}
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


            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="tab-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#classic" data-toggle="tab"><span class="icon mdi mdi-calendar-alt"></span>Classique</a></li>
                            <li><a href="#by-day" data-toggle="tab"><span class="icon mdi mdi-calendar"></span>Jours</a></li>
                            {{--<li><a href="#add-cours" data-toggle="tab"><span class="icon mdi mdi-calendar-check"></span>Programmer un cours</a></li>--}}
                            <li><a href="#cahier-de-text" data-toggle="tab"><span class="icon mdi mdi-book"></span>Cahier de textes</a></li>
                            {{--<li><a href="#appel" data-toggle="tab"><span class="icon mdi mdi-accounts-list-alt"></span>Appels/Présence</a></li>--}}
                        </ul>
                        <div class="tab-content">
                            <div id="classic" class="tab-pane active cont">
                                {{--<div class="panel-heading">Emploi du temps <b>@{{ selectedClasse.nom }}</b>
                                    <div class="tools">
                                        <button class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Imprimer emploi du temps"><span class="icon mdi mdi-print"></span></button>
                                        --}}{{--<button class="btn btn-default btn-xs"><span class="icon mdi mdi-more-vert"></span></button>--}}{{--
                                    </div>
                                </div>--}}
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check9" type="checkbox" v-model="showHoraires">
                                                    <label for="check9">Horaire</label>
                                                </div>
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check10" type="checkbox" v-model="showProfs">
                                                    <label for="check10">Professeurs</label>
                                                </div>
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check11" type="checkbox" v-model="showWeekends">
                                                    <label for="check11">Week-end</label>
                                                </div>
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check12" type="checkbox" disabled>
                                                    <label for="check12">Couleur matière</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="divConteneur">
                                    <table class="table table-condensed table-hover table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">HORAIRES</th>
                                            <th class="text-center" v-for="jour in jours" v-show="isWeekend(jour)">@{{ jour.nom }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="h in horaires">
                                            <td class="text-center">
                                                <b>@{{ h.nom }}</b>
                                                <br>
                                                <span v-show="showHoraires"><i>@{{ h.debut }}</i> - <i>@{{ h.fin }}</i> </span>
                                            </td>
                                            <td class="text-center index" :class="hooveredTd(jour,h)" @mouseover="hooverCoursTd(jour,h)" v-for="jour in jours" v-show="isWeekend(jour)" @click="showCoursUpdatorModal(jour,h)" :style="{ 'background-color': getCoursMatiereColor(jour,h) }">
                                                {{--<button class="btn btn-default btn-lg">@{{ getCoursMatiere(jour,h) }}</button>--}}
                                                <b >@{{ getCoursMatiere(jour,h) }}</b>
                                                <br>
                                                <span v-show="showProfs"><i>@{{ getCoursProf(jour,h) }}</i></span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div></div>
                            </div>
                            <div id="by-day" class="tab-pane cont" >
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-6">

                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check11" type="checkbox" v-model="showWeekends">
                                                    <label for="check11">Week-end</label>
                                                </div>
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check12" type="checkbox" disabled>
                                                    <label for="check12">Couleur matière</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="accordion1" class="panel-group accordion" >

                                        <div class="panel panel-default panel-border-color panel-border-color-info" v-for=" jour in jours" v-show="isWeekend(jour)">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" :href="'#'+jour.nom" class="collapsed"><i class="icon mdi mdi-chevron-down"></i>@{{ jour.nom }}</a></h4>
                                            </div>
                                            <div :id="jour.nom" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div id="divConteneur">
                                                    <table class="table table-condensed table-hover table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <td class="text-center">Heure</td>
                                                            <td class="text-center">Debut</td>
                                                            <td class="text-center">Fin</td>
                                                            <td class="text-center">Matière</td>
                                                            <td class="text-center">Professeur</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="c in getParsedCours(jour)">
                                                            <td class="text-center">@{{ c.horaire.nom }}</td>
                                                            <td class="text-center">@{{ c.horaire.debut }}</td>
                                                            <td class="text-center">@{{ c.horaire.fin }}</td>
                                                            <td class="text-center">@{{ c.matiere.intitule }}</td>
                                                            <td class="text-center">@{{ c.prof.nom_complet }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="add-cours" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <div class="row">
                                            <div class="form-group">
                                                <label>Classe</label>
                                                <select name="" class="select2" style="width: 100%" id="select2-cours-classe">
                                                    <option value="0" disabled selected>Selectionner une classe</option>
                                                    <option :value="classe.id" v-for="classe in classes" >@{{ classe.nom }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label>Jour</label>
                                                <select name="" class="select2" style="width: 100%" id="select2-cours-jour">
                                                    <option value="0" disabled selected>Selectionner le jour</option>
                                                    <option :value="jour.id" v-for="jour in jours" >@{{ jour.nom }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label>Heure</label>
                                                <select name="" class="select2" style="width: 100%" id="select2-cours-horaire">
                                                    <option value="0" disabled selected>Selectionner l'heure</option>
                                                    <option :value="horaire.id" v-for="horaire in horaires" >@{{ horaire.nom }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label>Matiere</label>
                                                <select name="" class="select2" style="width: 100%" id="select2-cours-matiere">
                                                    <option value="0" disabled selected>Selectionner une matiere</option>
                                                    <option :value="matiere.id" v-for="matiere in matieres" >@{{ matiere.intitule }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label>Professeur</label>
                                                <select name="" class="select2" style="width: 100%" id="select2-cours-prof">
                                                    <option value="0" disabled selected>Selectionner un prof</option>
                                                    <option :value="prof.id" v-for="prof in profs" >@{{ prof.nom_complet }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label>Salle</label>
                                                <select name="" class="select2" style="width: 100%" id="select2-cours-salle">
                                                    <option value="0" disabled selected>Selectionner une salle</option>
                                                    <option :value="salle.id" v-for="salle in salles" >@{{ salle.nom }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <button class="btn btn-xl btn-primary pull-right col-lg-4" @click="createNewCours()" v-show="readyToCreateCours">Créer</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="cahier-de-text" class="tab-pane cont">
                                <div class="row full-calendar">
                                    <div class="col-md-12">

                                        <table class="table ">
                                            <thead>
                                            <tr>
                                                <td class="text-center" ><span class="label label-primary">Cours disponibles - Cahier de charge non rempli.</span></td>
                                                <td class="text-center"><span class="label label-danger">Cours dispensés - Cahier de de texte est rempli.</span></td>
                                            </tr>
                                            </thead>
                                        </table>
                                        <div class="panel panel-default panel-fullcalendar">
                                            <div class="panel-body">
                                                <div id="cdt-calendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-3">
                                        <div class="panel panel-default fullcalendar-external-events">
                                            <div class="panel-heading panel-heading-divider">Draggable Events</div>
                                            <div class="panel-body">
                                                <div id="external-events">
                                                    <div class="fc-event">My Event 1</div>
                                                    <div class="fc-event">My Event 2</div>
                                                    <div class="fc-event">My Event 3</div>
                                                    <div class="fc-event">My Event 4</div>
                                                    <div class="fc-event">My Event 5</div>
                                                    <p>
                                                        <input id="drop-remove" type="checkbox">
                                                        <label for="drop-remove">remove after drop</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>
                            <div id="appel" class="tab-pane cont"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="col-lg-12" >
                <div class="panel panel-default">
                    <div class="panel-heading">Emploi du temps <b>@{{ selectedClasse.nom }}</b>
                        <div class="tools">
                            <button class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Imprimer emploi du temps"><span class="icon mdi mdi-print"></span></button>
                            --}}{{--<button class="btn btn-default btn-xs"><span class="icon mdi mdi-more-vert"></span></button>--}}{{--
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="divConteneur">
                        <table class="table table-condensed table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">HORAIRES</th>
                                <th class="text-center" v-for="jour in jours">@{{ jour.nom }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="h in horaires">
                                <td class="text-center">@{{ h.nom }}</td>
                                <td class="text-center" v-for="jour in jours" :style="{ 'backgroud-color':getCoursMatiereColor(jour,h) }">
                                    <button class="btn btn-default btn-lg">@{{ getCoursMatiere(jour,h) }}</button>
                                    <br>
                                    @{{ getCoursProf(jour,h) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>--}}

            {{--Modals--}}
            <div  tabindex="-1" role="dialog" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <div class="text-primary"><span class="modal-main-icon mdi mdi-info-outline"></span></div>
                                <h3>Information!</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br>Fusce ultrices euismod lobortis.</p>
                                <div class="xs-mt-50">
                                    <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-space btn-primary">Proceed</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>

            <div id="cdt-create-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Détails de la séance du @{{ selectedEvent.start.format("D MMMM YYYY") }}</h3>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" v-model="selectedEvent.id">
                            <div class="col-lg-12">
                                <h4>Détails de la séance du @{{ selectedEvent.start.format("D MMMM YYYY") }}</h4>
                                <div id="divConteneur">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Classe</th>
                                        <th>Matière</th>
                                        <th>Professeur</th>
                                        <th>Salle</th>
                                        <th>Horaire</th>
                                        <th>Appel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>@{{ selectedEvent.classe}}</th>
                                        <th>@{{ selectedEvent.matiere}}</th>
                                        <th>@{{ selectedEvent.prof }}</th>
                                        <th>@{{ selectedEvent.salle}}</th>
                                        <th>@{{ selectedEvent.horaire }}</th>
                                        <th></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="col-lg-12">
                                <h3>Cahier de texte</h3>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input class="form-control" v-model="selectedEvent.titre" type="text" placeholder="Titre">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Contenu</label>
                                    <textarea class="form-control" v-model="selectedEvent.contenu" name="" id="" cols="30" rows="4" placeholder="Contenu"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-lg-12">
                                {{--<button type="button" data-dismiss="modal" class="btn btn-danger md-close">Supprimer</button>--}}
                                <button type="button" data-dismiss="modal" class="btn btn-primary md-close" @click="updateSeance()" v-if="cdtExists">Modifier</button>
                                <button type="button" data-dismiss="modal" class="btn btn-success md-close" @click="createSeance()" v-else="cdtExists">Enregistrer</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default md-close">Quitter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="update-cours-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Modifier ce cours</h3>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Classe</label>
                                        <select name="" disabled class="form-control" style="width: 100%" v-model="selectedCours.classe_id">
                                            {{--<option value="0" disabled selected>Selectionner une classe</option>--}}
                                            <option :value="selectedClasse.id" selected>@{{ selectedClasse.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Jour</label>
                                        <select name="" disabled="" v-model="selectedCours.jour_id" class="form-control" style="width: 100%">
                                            {{--<option value="0" disabled selected>Selectionner le jour</option>--}}
                                            <option :value="currentJour.id" selected>@{{ currentJour.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Heure</label>
                                        <select class="form-control" v-model="selectedCours.horaire_id" disabled name="" style="width: 100%" >
                                            {{--<option value="0" disabled selected>Selectionner l'heure</option>--}}
                                            <option :value="currentHeure.id"  >@{{ currentHeure.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Matiere</label>
                                        <select name="" v-model="selectedCours.matiere_id" class="form-control" style="width: 100%">
                                            <option value="0" disabled selected>Selectionner une matiere</option>
                                            <option :value="matiere.id" v-for="matiere in matieres" >@{{ matiere.intitule }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Professeur</label>
                                        <select name="" class="form-control"  v-model="selectedCours.personnel_id" style="width: 100%" >
                                            <option value="0" disabled selected>Selectionner un prof</option>
                                            <option :value="prof.id" v-for="prof in profs" >@{{ prof.nom_complet }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Salle</label>
                                        <select name="" v-model="selectedCours.salle_id" class="form-control" style="width: 100%" >
                                            <option value="0"  disabled selected>Selectionner une salle</option>
                                            <option :value="salle.id" v-for="salle in salles" >@{{ salle.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="form-group">
                                        <button class="btn btn-xl btn-primary pull-right col-lg-4" @click="createNewCours()" v-show="readyToCreateCours">Créer</button>
                                    </div>
                                </div>--}}

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                {{--<button type="button" data-dismiss="modal" @click="deleteCours()" class="btn btn-danger md-close">Supprimer ce cours</button>--}}
                                <button type="button" data-dismiss="modal" @click="updateCours()" class="btn btn-primary md-close">Modifier ce cours</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default md-close">Quitter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="create-cours-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-success">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Programmer un cours</h3>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Classe</label>
                                        <select name="" disabled class="form-control" style="width: 100%" v-model="newCours.classe_id">
                                            {{--<option value="0" disabled selected>Selectionner une classe</option>--}}
                                            <option :value="selectedClasse.id" selected>@{{ selectedClasse.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Jour</label>
                                        <select name="" disabled="" v-model="newCours.jour_id" class="form-control" style="width: 100%">
                                            {{--<option value="0" disabled selected>Selectionner le jour</option>--}}
                                            <option :value="currentJour.id" selected>@{{ currentJour.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Heure</label>
                                        <select class="form-control" v-model="newCours.horaire_id" disabled name="" style="width: 100%" >
                                            {{--<option value="0" disabled selected>Selectionner l'heure</option>--}}
                                            <option :value="currentHeure.id"  >@{{ currentHeure.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Matiere</label>
                                        <select name="" v-model="newCours.matiere_id" class="form-control" style="width: 100%">
                                            <option value="0" disabled selected>Selectionner une matiere</option>
                                            <option :value="matiere.id" v-for="matiere in matieres" >@{{ matiere.intitule }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Professeur</label>
                                        <select name="" class="form-control"  v-model="newCours.personnel_id" style="width: 100%" >
                                            <option value="0" disabled selected>Selectionner un prof</option>
                                            <option :value="prof.id" v-for="prof in profs" >@{{ prof.nom_complet }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Salle</label>
                                        <select name="" v-model="newCours.salle_id" class="form-control" style="width: 100%" >
                                            <option value="0"  disabled selected>Selectionner une salle</option>
                                            <option :value="salle.id" v-for="salle in salles" >@{{ salle.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="form-group">
                                        <button class="btn btn-xl btn-primary pull-right col-lg-4" @click="createNewCours()" v-show="readyToCreateCours">Créer</button>
                                    </div>
                                </div>--}}

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                {{--<button type="button" data-dismiss="modal" @click="deleteCours()" class="btn btn-danger md-close">Supprimer ce cours</button>--}}
                                <button type="button" data-dismiss="modal" @click="createNewCours()" v-show="readyToCreateCours" class="btn btn-success md-close">Enregistrer ce cours</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default md-close">Quitter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </template>

    <script type="module" src="{{ asset('js/vues/admin/planning/classes.js') }}"></script>
@endsection

@section('content')

    <classes></classes>

@endsection