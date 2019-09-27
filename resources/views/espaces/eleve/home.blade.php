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
            $('.tooltipped').tooltip({});

            $( ".select2" ).select2();

        });
    </script>

    <template id="edt" type="text\template">
        <div>
            <div class="row">
            <div class="col-lg-9 m-b-md">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading panel-heading-divider">Emploi du temps<span class="panel-subtitle">Emploi du temps de la classe de <b>@{{ classe.nom }}</b></span></div>
                    {{--<div class="panel-heading">@{{ selectedEleve.nom_complet }}</div>--}}
                    <div class="tab-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#classic" data-toggle="tab"><span class="icon mdi mdi-calendar-alt"></span>Classique</a></li>
                               <li><a href="#by-day" data-toggle="tab"><span class="icon mdi mdi-calendar"></span>Jours</a></li>
                            <li><a href="#cahier-de-text" data-toggle="tab"><span class="icon mdi mdi-book"></span>Cahier de textes</a></li>
                            {{--<li><a href="#appel" data-toggle="tab"><span class="icon mdi mdi-accounts-list-alt"></span>Appels/Présence</a></li>--}}
                        </ul>
                        <div class="tab-content">
                            <div id="classic" class="tab-pane active cont">

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check9" type="checkbox" v-model="showHoraires">
                                                    <label for="check9">Horaire</label>
                                                </div>
                                                <!--       <div class="be-checkbox be-checkbox-color inline">
                                                           <input id="check10" type="checkbox" v-model="showProfs">
                                                           <label for="check10">Professeurs</label>
                                                       </div>  -->
                                                <div class="be-checkbox be-checkbox-color inline">
                                                    <input id="check11" type="checkbox" v-model="showWeekends">
                                                    <label for="check11">Week-end</label>
                                                </div>
                                                <!--   <div class="be-checkbox be-checkbox-color inline">
                                                       <input id="check12" type="checkbox" disabled>
                                                       <label for="check12">Couleur matière</label>
                                                   </div> -->
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
                                            <td class="text-center index" :class="hooveredTd(jour,h)" @mouseover="hooverCoursTd(jour,h)" v-for="jour in jours" v-show="isWeekend(jour)" @click="showCoursUpdatorModal(jour,h)" :style="{ 'backgroud-color': getCoursMatiereColor(jour.id,h.id) }">
                                                {{--<button class="btn btn-default btn-lg">@{{ getCoursMatiere(jour,h) }}</button>--}}
                                                <b >@{{ getCoursMatiere(jour,h) }}</b>
                                                <br>
                                            <!--  <span v-show="showProfs"><i>@{{ getCoursProf(jour,h) }}</i></span>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
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
                                                <!--    <div class="be-checkbox be-checkbox-color inline">
                                                        <input id="check12" type="checkbox" disabled>
                                                        <label for="check12">Couleur matière</label>
                                                    </div> -->

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <!--         <div id="accordion1" class="panel-group accordion" >

                                        <div class="panel panel-default panel-border-color panel-border-color-info" v-for=" jour in jours" v-show="isWeekend(jour)">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" :href="'#'+jour.nom" class="collapsed"><i class="icon mdi mdi-chevron-down"></i>@{{ jour.nom }}</a></h4>
                                            </div>
                                            <div :id="jour.nom" class="panel-collapse collapse">
                                                <div class="panel-body">
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
                                                            <td class="text-center"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                            <div id="cahier-de-text" class="tab-pane cont">
                                <div class="row full-calendar">
                                    <div class="col-md-12">
                                        <div class="row m-b-lg">
                                            <center>
                                                <div class="col-lg-6 m-t-md"><span class="label label-primary" style="background-color: #4080b4">Cours disponibles - Cahier de charge non rempli.</span></div>
                                                <div class="col-lg-6 m-t-md"><span class="label label-danger">Cours dispensés - Cahier de texte est rempli.</span></div>
                                            </center>
                                        </div>
                                        <div class="panel panel-default panel-fullcalendar">
                                            <div class="panel-body">
                                                <div id="divConteneur">
                                                <div id="cdt-calendar"></div>
                                            </div>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="">
                    <img class="img-responsive" src="{{asset('images/img-pub.jpg')}}"/>
                </div>
            </div>
        </div>


        {{--Modals--}}
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
                                <div id="divConteneurX">
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
                                    <input class="form-control" v-model="selectedEvent.seance.titre" type="text" placeholder="Titre">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Contenu</label>
                                    <textarea class="form-control" v-model="selectedEvent.seance.contenu" name="" id="" cols="30" rows="4" placeholder="Contenu"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="be-checkbox">
                                    <input id="check2" type="checkbox" v-model="has_dm">
                                    <label for="check2">Ajouter des devoirs de maison</label>
                                </div>
                            </div>

                            <div class="col-lg-12" v-if="has_dm">
                                <div class="form-group" >
                                    <label>Echéance</label>
                                    <input type="date" class="form-control" v-model="selectedEvent.seance.echeance">
                                </div>
                            </div>

                            <div class="col-lg-12" v-if="has_dm">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea v-model="selectedEvent.seance.desc" class="form-control" name="" id="" cols="30" rows="4" placeholder="Contenu"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <div class="col-lg-12">
                                {{--<button type="button" data-dismiss="modal" class="btn btn-dangerX md-close">Supprimer</button>--}}
                                {{--<button type="button" data-dismiss="modal" class="btn btn-primary md-close" @click="updateSeance()" v-if="cdtExists">Modifier</button>--}}
                                {{--<button type="button" data-dismiss="modal" class="btn btn-successX md-close" @click="createSeance()" v-else="cdtExists">Enregistrer</button>--}}
                                <button type="button" data-dismiss="modal" class="btn btn-defaultX md-close">Quitter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--    <div  tabindex="-1" role="dialog" class="modal fade">
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
                                    <button type="button" data-dismiss="modal" class="btn btn-space btn-defaultX">Cancel</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-space btn-primary">Proceed</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div> -->
        </div>
    </template>

    <script type="module" src="{{ asset('js/vues/eleve/planning/edt.js') }}"></script>
@endsection

@section('content')

    <edt></edt>
@endsection