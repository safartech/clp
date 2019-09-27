@extends("default")
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('js/select2/css/select2.min.css') }}"--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css"/>--}}

    <style>
        td.name{
            width: 25%;
        }
        td.desc{
            width: 40%;
        }
        td.moy{
            width: 10%;
        }
        td.qual{
            width: 25%;
        }
        td.name-header{
            width: 65%;
        }
        selector{
            border: 1px black solid;
            background-color: grey;
        }
        red{
            background-color: red;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/tooltip/tooltip.js') }}" type="text/javascript"></script>



    <script type="text/javascript">

        $(document).ready(function(){

//           $('[data-toggle="tooltip"]').tooltip()
            $('.tooltipped').tooltip({

            });

            $( ".select2" ).select2();

        });
    </script>


    <template id="bulletins" type="text\template">
        <div class="">
            <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default panel-border-color panel-border-color-primary coll">
                        <div class="panel-heading panel-heading-divider">Bulletins<span class="panel-subtitle">Bulletins de notes.</span></div>
                        <div class="panel-body">

                            <div class="col-lg-12">
                                <div class="col-lg-3">
                                    <div class=""><label class="control-label">Classes</label></div>
                                    <div class="">
                                        <select id="select2-classe" class="select2">
                                            <option value="0" disabled selected  >Selectionner une classe</option>
                                            <option v-for="classe in classes" :value="classe.id">@{{ classe.nom }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class=""><label class="control-label">Sessions</label></div>
                                    <div class="">
                                        <select id="select2-session" class="select2">
                                            <option value="0" disabled selected  >Selectionner une Session</option>
                                            <option v-for="session in sessions" :value="session.id">@{{ session.nom }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class=""><label class="control-label">Elèves</label></div>
                                    <div class="">
                                        <select id="select2-eleve" class="select2">
                                            <option value="0" disabled selected  >Selectionner un élève</option>
                                            <option v-for="eleve in eleves" :value="eleve.id">@{{ eleve.nom_complet}}</option>
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
                                            <a href="#" class="btn-xl btn btn-warning" data-toggle="tooltip" data-placement="top" title="Conseils de classe" @click="showConseilSetter()" v-show="showBulletin"><i class="icon mdi mdi-layers" ></i></a>
                                            <a :href="bullLink" target="_blank" class="btn-xl btn btn-default" data-toggle="tooltip" data-placement="top" title="Imprimer bulletin" v-show="showBulletin"><i class="icon mdi mdi-print"></i></a>
                                            {{--<a href="#" class="btn-xl btn btn-default " data-toggle="tooltip" data-placement="top" title="Programmer un cours" @click="showCoursCreatorModal"><i class="icon mdi mdi-plus"></i></a>--}}
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

                {{--<div class="col-lg-4">
                    <div class="panel panel-default" v-show="showElevesList">
                        <div class="panel-heading">Elèves
                            <div class="tools"><span class="icon mdi mdi-download"></span><span class="icon mdi mdi-more-vert"></span></div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">Prénoms</th>
                                    --}}{{--<th class="text-center">Retards</th>--}}{{--
                                    --}}{{--<th class="text-center">Absences</th>--}}{{--
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(eleve,i) in eleves" @click="eleveClick(eleve)" :class="isSelected(eleve)">
                                    <td>@{{ i+1 }}</td>
                                    <td class="text-center">@{{ eleve.nom }}</td>
                                    <td class="text-center">@{{ eleve.prenoms }}</td>
                                    --}}{{--<td class="text-center" @click="showSetRetardModal(eleve)">@{{ getNbreRetard(eleve) }}</td>--}}{{--
                                    --}}{{--<td class="text-center"></td>--}}{{--
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>--}}

                <div class="col-lg-12">
                    <div class="panel panel-default" v-show="showBulletin">
                        <div class="panel-heading">Bulletin <b>@{{ getEleveName() }}</b>
                            <div class="tools">
                                <span class="icon mdi mdi-close-circle" @click="closeAllInputs()"></span>
                                {{--<a href="#"><span class="icon mdi mdi-account-add"></span></a>--}}
                                {{--<a href="#" @click="setRetard()"><span class="icon mdi mdi-run"></span></a>--}}
                                {{--<a :href="printLink(1)" target="_blank"><span class="icon mdi mdi-eye"></span></a>--}}
                                {{--<a :href="printLink(0)"><span class="icon mdi mdi-download"></span></a>--}}
                                {{--<a :href="seeLink" target="_blank"><span class="icon mdi mdi-eye"></span></a>--}}
                                <span class="icon mdi mdi-more-vert"></span></div>
                        </div>
                        <div class="panel-body">
                            <div id="divConteneur">
                            <table class="table table-condensed table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center" colspan="2">Domaines d'enseignement</th>
                                    <th class="moy text-center">Moyenne</th>
                                    <th class="qual text-center">Appréciations et observations</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>


                            <table v-for="matiere in matieres" class="table table-condensed table-hover table-bordered table-striped" :class="">
                                <tr>
                                    <td colspan="4" class="text-center" > <span class=""><b>@{{ matiere.intitule }}  (@{{ getMatiereMoy(matiere) }})</b></span></td>
                                    {{--<td colspan="4" class="text-center" > <span class=""><b>@{{ matiere.intitule }}</b></span></td>--}}
                                </tr>

                                <tbody v-for="sm in matiere.sous_matieres" v-if="!hasModule(sm)">
                                <tr>
                                    <td class="name"><b>@{{ sm.nom }}</b></td>
                                    <td class="desc" v-if="!hasModule(sm)">@{{ sm.description }}</td>
                                    {{--<td v-if="hasModule(sm)" :rowspan="nombreModules(sm) ">Modulus</td>--}}
                                    <td class="moy" >@{{ getMoyBySM(sm) }}</td>
                                    <td class="qual" @click="appreciationFocus()">
                                        <span >@{{ getSMAppreciation(sm) }}</span>
                                        {{--<span v-show="!showApprInput">@{{ getSMAppreciation(sm) }}</span>--}}
                                        {{--<input type="text"
                                               :id="sm.id"
                                               class="form-control"
                                               v-show="showApprInput"
                                               v-model="setSMAppreciation(sm)"
                                               @blur="apprBlur(sm)"
                                        >--}}
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-for="sm in matiere.sous_matieres" v-if="hasModule(sm)">
                                <tr>
                                    <td class="name" :rowspan="nombreModules(sm)+1"><b>@{{ sm.nom }}</b></td>
                                    {{--<td v-if="!hasModule(sm)">@{{ sm.description }}</td>--}}
                                </tr>
                                <tr v-for="module in sm.modules">
                                    <td class="desc"><b>@{{ module.nom }}</b> : @{{ module.description }}</td>
                                    <td class="moy">@{{ getMoyByMod(module) }}</td>
                                    <td class="qual">@{{ getModAppreciation(module) }}</td>
                                </tr>
                                </tbody>

                                <tbody v-if="!hasSousMatiere(matiere)">
                                <tr>
                                    <td class="name-header">@{{ matiere.description }}</td>
                                    <td class="moy" >@{{ getMoyByMat(matiere) }}</td>
                                    <td class="qual">@{{ getMatAppreciation(matiere) }}</td>
                                </tr>
                                </tbody>


                                {{--</tr>--}}
                            </table>

                            <table class="table table-condensed table-hover table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td class="text-center" colspan="2"><b>ATTITUDE FACE AU TRAVAIL</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 50%">Rythme de travail</td>
                                    <td class="text-center" style="width: 50%">@{{ getRythme() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 50%">Présentation, écriture soin</td>
                                    <td class="text-center" style="width: 50%">@{{ getPresentation() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 50%">Autonomie et initiative</td>
                                    <td class="text-center" style="width: 50%">@{{ getAutonomie() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" colspan="2"><b>COMPORTEMENT ET VIE SCOLAIRE</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center">Attention, concentration</td>
                                    <td class="text-center">@{{ getAttention() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Participation</td>
                                    <td class="text-center">@{{ getParticipation() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center" colspan="2"><b>OBSERVATION GENERALE</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center" colspan="2"><b>@{{ getOg() }}</b></td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                        </div>
                    </div>

                </div>


            </div>
            </div>

            <div id="conseil-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title"><b>Conseil de classe</b></h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Attention, concentration</label>
                                        <input v-model="selectedEleveConseil.attention" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Participation</label>
                                        <input v-model="selectedEleveConseil.participation" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Rythme de travail</label>
                                        <input v-model="selectedEleveConseil.rythme" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Présentation, écriture soi</label>
                                        <input v-model="selectedEleveConseil.ecriture" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Autonomie et initiative</label>
                                        <input v-model="selectedEleveConseil.autonomie" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Nombre d'absences</label>
                                        <input v-model="selectedEleveConseil.absences" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label><b>OBSERVATION GENERALE</b></label>
                                        <input v-model="selectedEleveConseil.og" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-info md-close" @click="validate()">OK</button>
                            <button type="button"  data-dismiss="modal" class="btn btn-defaultX md-close">Quitter</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </template>


    <script type="module" src="{{ asset('js/vues/admin/evaluations/bulletins.js') }}"></script>
@endsection

@section('content')

    <bulletins></bulletins>

@endsection