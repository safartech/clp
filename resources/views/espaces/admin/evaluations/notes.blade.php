@extends("default")
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('js/select2/css/select2.min.css') }}"--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>--}}

    <style>
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
    <template type="text\template" id="notes">
        <div>
            <div class="col-lg-8">
                <div class="panel panel-default panel-border-color panel-border-color-primary coll">
                    <div class="panel-heading panel-heading-divider">Evaluations<span class="panel-subtitle">Gestion des évaluations et des notes.</span></div>
                    <div class="panel-body">
                        <div class="col-lg-12">
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
                                <div class=""><label>Matieres</label></div>
                                <div class="">
                                    <select id="select2-matiere" class="select2 " >
                                        <option :value="null" disabled selected  >Selectionner une matière</option>
                                        {{--<option v-for="matiere in matieres"  :value="matiere.id">@{{ matiere.intitule }}</option>--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class=""><label>Sessions</label></div>
                                <div class="">
                                    <select id="select2-session" class="select2 ">
                                        <option :value="null" disabled selected  >Selectionner une session</option>
                                        <option v-for="session in sessions" :value="session.id">@{{ session.nom }}</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-3" >
                                <div class=""><label class="control-label">Sous matieres</label></div>
                                <div class="" style="width: 100%">
                                    <select id="select2-sm" :disabled="!hasSousMatiere" class="select2">
                                        <option :value="null" disabled selected  >Selectionner une sous-matière </option>
                                        {{--<option v-for="sm in sousMatieres"  :value="classe.id">@{{ sm.nom }}</option>--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3" >
                                <div class=""><label>Modules</label></div>
                                <div class="">
                                    <select id="select2-mod" class="select2" :disabled="!hasModule">
                                        <option :value="null" disabled selected  >Selectionner un module</option>
                                        {{--<option v-for="matiere in matieres"  :value="matiere.id">@{{ matiere.intitule }}</option>--}}
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
                                        <a href="#" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Nouvelle évaluation" @click="showEvaluationCreateModal()"><i class="icon mdi mdi-plus"></i></a>
                                        <a :href="link" target="_blank" v-if="ready" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Imprimer fiche de notes"><i class="icon mdi mdi-print"></i></a>
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
                        <div class="panel-heading">Liste des Notes d'évaluations:
                            Classe <b>(@{{ selectedClasse.nom }})</b>
                            Effectif <b>(@{{ selectedClasse.eleves.length }})</b>
                            Nombre d'évaluations <b>(@{{ evals.length }})</b>
                            <div class="tools">
                                {{--<span class="icon mdi mdi-download"></span>--}}
                                <span class="icon mdi mdi-close-circle" @click="closeAllInputs()"></span>
                                <span class="icon mdi mdi-more-vert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="divConteneur">
                        <table id="mainTable" class="table table-condensed table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th v-for="eval in evals" @click="selectEval(eval)">@{{ moment(eval.date).format('DD MMM YYYY') }}</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>@{{ eleves.length }} élèves </th>
                                <th>Appréciations Trimestrielles</th>
                                <th>Moyenne</th>
                                {{--<th v-for="eval in evals">Sur @{{ eval.notation }} (Coef @{{ eval.coef }})</th>--}}
                                <th v-for="eval in evals">Sur @{{ eval.notation }}</th>
                                <th class="text-center">Télécharger relevé du @{{ selectedSession.nom }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="eleve in eleves">
                                <td>@{{ eleve.nom_complet }}</td>
                                <td @click="appreciationFocus()">
                                    <span v-show="!showApprInput">@{{ eleve.appreciations[0].appreciation }}</span>
                                    <input type="text"
                                           :id="eleve.id"
                                           class="form-control"
                                           v-show="showApprInput"
                                           v-model="eleve.appreciations[0].appreciation"
                                           @blur="apprBlur(eleve)"
                                    >
                                </td>
                                <td class="text-center dark"><b style="font-size: 14px">@{{ moyCalc(eleve.evaluations) }}</b></td>
                                <td v-for="(e,i) in eleve.evaluations" @click="noteFocus(e)">
                                    <span v-show="!showNoteInput(e)">
                                        @{{ e.pivot.note }}
                                    </span>
                                    <input :id="e.pivot.id"
                                           type="number" max="10" min="0"
                                           class="form-control"
                                           v-model="e.pivot.note"
                                           v-show="showNoteInput(e)"
                                           @blur="noteBlur(eleve,e)">
                                </td>
                                <td class="text-center">
                                    <a :href="eleveReleveLink(eleve)" target="_blank" class="btn btn-default">Télécharger</a>
                                    {{--<p class="center"><a class="btn-floating waves-effect waves-light center" :href="eleveReleveLink(eleve)"><i class="mdi-action-description center"></i></a></p>--}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            {{--Modals--}}
            <div id="update-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-info">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title"><b>Modifier l'évaluation du </b><b> @{{ moment(selectedEval.date).format('YYYY-MM-DD') }} </b></h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>Date de l'évaluation
                                            <span class="label label-info">
                                                {{--<b> @{{ moment(selectedEval.date).format('YYYY-MM-DD') }} </b>--}}
                                            </span>
                                        </label>
                                        <input type="date" v-model="selectedEval.date" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Classe </label>
                                        <select class="form-control" name="" id="" v-model="selectedClasse.id">
                                            <option :value="selectedClasse.id" selected>@{{ selectedClasse.nom }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Session <span class="required-sign">*</span></label>
                                        <select class="form-control" name="" id="" v-model="selectedSession.id">
                                            <option :value="selectedSession.id" selected>@{{ selectedSession.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row no-margin-y">
                                    <div class="form-group col-lg-4">
                                        <label>Matiere <span class="required-sign">*</span></label>
                                        <select class="form-control" name="" id="" v-model="selectedMatiere.id">
                                            <option :value="selectedMatiere.id" selected>@{{ selectedMatiere.intitule }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Sous matiere </label>
                                        <select class="form-control" name="" :disabled="!hasSousMatiere" id="" v-model="selectedSousMatiere.id">
                                            <option :value="selectedSousMatiere.id" selected>@{{ selectedSousMatiere.nom }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Module </label>
                                        <select class="form-control" name="" :disabled="!hasModule" id="" v-model="selectedModule.id">
                                            <option :value="selectedModule.id" selected>@{{ selectedModule.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description/Detail/Commentaire</label>
                                <textarea placeholder="Intero / Devoir / etc..." v-model="selectedEval.commentaire"  class="form-control" name="" id="" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="deleteEvaluation()" data-dismiss="modal" class="btn btn-dangerX md-close">Supprimer l'évaluation</button>
                            <button type="button" @click="updateEvaluation()" data-dismiss="modal" class="btn btn-info md-close">Modifier l'évaluation</button>
                            <button type="button"  data-dismiss="modal" class="btn btn-defaultX md-close">Quitter</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="create-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-success">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title"><b>Nouvelle Evaluation</b></h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>Date de l'évaluation
                                            <span class="label label-info">
                                                {{--<b> @{{ moment(selectedEval.date).format('YYYY-MM-DD') }} </b>--}}
                                            </span>
                                        </label>
                                        <input type="date" v-model="evaluation.date" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Classe </label>
                                        <select class="form-control" name="" id="" v-model="selectedClasse.id">
                                            <option :value="selectedClasse.id" selected>@{{ selectedClasse.nom }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Session <span class="required-sign">*</span></label>
                                        <select class="form-control" name="" id="" v-model="selectedSession.id">
                                            <option :value="selectedSession.id" selected>@{{ selectedSession.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row no-margin-y">
                                    <div class="form-group col-lg-4">
                                        <label>Matiere <span class="required-sign">*</span></label>
                                        <select class="form-control" name="" id="" v-model="selectedMatiere.id">
                                            <option :value="selectedMatiere.id" selected>@{{ selectedMatiere.intitule }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Sous matiere </label>
                                        <select class="form-control" name="" :disabled="!hasSousMatiere" id="" v-model="selectedSousMatiere.id">
                                            <option :value="selectedSousMatiere.id" selected>@{{ selectedSousMatiere.nom }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Module </label>
                                        <select class="form-control" name="" :disabled="!hasModule" id="" v-model="selectedModule.id">
                                            <option :value="selectedModule.id" selected>@{{ selectedModule.nom }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="10" v-model="evaluation.coef">
                            <div class="form-group">
                                <label>Description/Detail/Commentaire</label>
                                <textarea placeholder="Intero / Devoir / etc..." v-model="evaluation.commentaire"  class="form-control" name="" id="" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="createEvaluation()" data-dismiss="modal" class="btn btn-info md-close">Créer l'évaluation</button>
                            <button type="button"  data-dismiss="modal" class="btn btn-defaultX md-close">Quitter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script type="module" src="{{ asset('js/vues/admin/evaluations/notes.js') }}"></script>
@endsection

@section('content')
    <notes></notes>
@endsection