@extends("default")
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('js/select2/css/select2.min.css') }}"--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>--}}

    <style>
        td.cpt{
            width: 10%;
        }
        th.cpt{
            width: 10%;
        }

        .select2{
            width: 100%;
        }
        .dark{
            background-color: grey;
            color: white;
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
    <script src="{{ asset('js/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/tooltip/tooltip.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/momentjs/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/momentjs/moment-with-locales.js') }}" type="text/javascript"></script>



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

    <template type="text\template" id="epc">
        <div>
            <div class="col-lg-8">
                <div class="panel panel-default panel-border-color panel-border-color-primary coll">
                    <div class="panel-heading panel-heading-divider">Evaluations<span class="panel-subtitle">Gestion des évaluations et des notes.</span></div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            {{--<div class="col-lg-3">
                                <div class=""><label>Sessions</label></div>
                                <div class="">
                                    <select id="select2-session" class="select2">
                                        <option :value="null" disabled selected  >Selectionner une session</option>
                                        <option v-for="session in sessions" :value="session.id">@{{ session.nom }}</option>
                                    </select>
                                </div>


                            </div>--}}

                            <div class="col-lg-4">
                                <div class=""><label class="control-label">Classes</label></div>
                                <div class="">
                                    <select id="select2-classe" class="select2">
                                        <option :value="null" disabled selected  >Selectionner une classe</option>
                                        <option v-for="classe in classes"  :value="classe.id">@{{ classe.nom }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class=""><label class="control-label">Elèves</label></div>
                                <div class="">
                                    <select id="select2-eleve" class="select2">
                                        <option value="0" disabled selected  >Selectionner un élève</option>
                                        <option v-for="eleve in eleves" :value="eleve.id">@{{ eleve.nom_complet}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
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
                                        <a :href="printLink" target="_blank" v-show="ready" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Imprimer fiche de notes"><i class="icon mdi mdi-print"></i></a>
                                        {{--<a href="#" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Nouvelle évaluation" @click="showEvaluationCreateModal()"><i class="icon mdi mdi-plus"></i></a>--}}
                                        {{--<a href="#" class="btn-xl btn  btn-default active " data-toggle="tooltip" data-placement="top" title="Option inactive"><i class="icon mdi mdi-settings"></i></a>--}}
                                        {{--<a href="#" class="btn-xl btn  btn-default active tooltipped" ><i class="icon mdi mdi-settings"></i></a>--}}
                                    </div>

                                </div>



                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <img class="img-responsive" src="{{ asset('images/infos.jpg')}}"/>
            </div>


            <div class="col-sm-12" >
                <div class="panel panel-default" v-if="ready">
                    <div class="panel-heading">
                        <div class="panel-heading">
                            <div class="tools">
                                <span class="icon mdi mdi-more-vert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="divConteneur">
                        <table class="table table-condensed table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" rowspan="2">COMPETENCES DEVANT ETRE ACQUISES EN @{{ classe.nom }}</th>
                                <th class="text-center" colspan="3">@{{ classe.nom }}</th>
                            </tr>
                            <tr>
                                <th class="center cpt">T1</th>
                                <th class="center cpt">T2</th>
                                <th class="center cpt">T3</th>
                            </tr>
                            </thead>
                        </table>
                        <table class="table table-condensed table-hover table-bordered table-striped" v-for="matiere in matieres">
                            <thead>
                            <tr ><th colspan="5" class="text-center">@{{ matiere.intitule }}</th></tr>
                            </thead>
                            <tbody class="table bordered" v-for="domaine in matiere.domaines">
                            <tr>
                                <td colspan="5" class="text-center">@{{ domaine.nom }}</td>
                            </tr>
                            <tr v-for="(cpt,index) in domaine.competences">
                                <td style="width: 5%"></td>
                                <td>@{{ cpt.nom }}</td>
                                {{--<td v-for="(session,z) in sessions" class="cpt"><input type="checkbox" :id="cpt.nom+z" checked><label :for="cpt.nom+z">@{{ getCpt() }}</label></td>--}}
                                <td v-for="(session,z) in sessions" class="cpt" @click="evaluate(domaine,cpt,session)">@{{ getEleveCpt(cpt,session) }}</td>
                                {{--<td class="cpt"></td>--}}
                                {{--<td class="cpt"></td>--}}
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            {{--Modals--}}

            <div id="evaluationModal1" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-info">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title"><b>Evaluation par compétence</b></h3>
                        </div>
                        <div class="modal-body">

                            <div class="" v-for="niveau in niveaux">
                                <button class="btn btn-default btn-space btn-xl" @click="selectEvalution(niveau)">@{{ niveau.designation }}</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{--<button type="button" data-dismiss="modal" class="btn btn-info md-close">OK</button>--}}
                            {{--<button type="button"  data-dismiss="modal" class="btn btn-defaultX md-close">Quitter</button>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div id="evaluationModal2" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-info">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title"><b>Evaluation par compétence</b></h3>
                        </div>
                        <div class="modal-body">

                            <div class="text-center" v-for="acqui in acquis">
                                <button class="btn btn-default btn-space btn-xl" @click="selectEvalution(acqui)">@{{ acqui.designation }}</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{--<button type="button" data-dismiss="modal" class="btn btn-info md-close">OK</button>--}}
                            {{--<button type="button"  data-dismiss="modal" class="btn btn-defaultX md-close">Quitter</button>--}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </template>

    <script type="module" src="{{ asset('js/vues/admin/evaluations/epc.js') }}"></script>
@endsection

@section('content')
    <epc></epc>
@endsection