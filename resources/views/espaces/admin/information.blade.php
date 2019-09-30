@extends("default")
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>

    <style>
        .select2{
            width: 100%;
        }

    </style>

@endsection

@section('js')
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="module"></script>
    <template id="informations">
        <div class="row">

            <div class="col-lg-12 m-b-md">
                <div id="form-bp1"  role="dialog" class="modal fade colored-header colored-header-primary">
                    <div class="modal-dialog custom-width">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #34a853;">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                                <h3 class="modal-title">Ajout Information</h3>
                            </div>
                            <div class="modal-body ">
                                <div class="form-group col-md-12">
                                    <label>Titre</label>
                                    <input type="text"  v-model="newInfo.title" placeholder="Titre" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Contenu</label>
                                    <input type="text" v-model="newInfo.content" placeholder="Contenu" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Date de début : <span class="label label-info" v-if="newInfo.start_date!=''">@{{ moment(newInfo.start_date) }}</span> {{--(laissez vide si inchangé)--}}</label>

                                    <div id="start_date_create"  data-start-view="4"  data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date">
                                        <input size="16" type="text" value="" class="form-control"><span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Date de fin : <span class="label label-info" v-if="newInfo.end_date!=''">@{{ moment(newInfo.end_date) }}</span> {{--(laissez vide si inchangé)--}}</label>

                                    <div id="end_date_create"  data-start-view="4"  data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date">
                                        <input size="16" type="text" value="" class="form-control"><span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                                <button type="button" data-dismiss="modal" class="btn btn-primary md-close" style="background-color: #34a853; border-color: #34a853;" @click="addInformation">Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="form-bp2"  role="dialog" class="modal fade colored-header colored-header-primary">
                    <div class="modal-dialog custom-width">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #34a853;">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                                <h3 class="modal-title">Modification Information</h3>
                            </div>
                            <div class="modal-body ">
                                <div class="form-group col-md-12">
                                    <label>Titre</label>
                                    <input type="text"  v-model="updateInfo.title" placeholder="Titre" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Contenu</label>
                                    <input type="text" v-model="updateInfo.content" placeholder="Contenu" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Date de début : <span class="label label-info">@{{ moment(updateInfo.start_date) }}</span> {{--(laissez vide si inchangé)--}}</label>

                                    <div id="start_date_modif"  data-start-view="4"  data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date">
                                        <input size="16" type="text" value="" class="form-control"><span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Date de fin : <span class="label label-info">@{{ moment(updateInfo.end_date) }}</span> {{--(laissez vide si inchangé)--}}</label>

                                    <div id="end_date_modif" data-start-view="4"  data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date">
                                        <input size="16" type="text" value="" class="form-control"><span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default md-close left">Annuler</button>
                                <button type="button" data-dismiss="modal" class="btn btn-primary md-close right" style="background-color: #34a853; border-color: #34a853;" @click="UpdateInformation">Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="mod-success" tabindex="-1" role="dialog" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
                                    <p>Voulez </p>
                                    <div class="xs-mt-50">
                                        <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Annuler</button>
                                        <button type="button" data-dismiss="modal"   @click="del()"  class="btn btn-space btn-danger">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>

                <div id="mod-danger" tabindex="-1" role="dialog" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
                                    <h3>Attention!!!!</h3>
                                    <p>L' element sera definitivement supprimer de la Base de Donnee.</p>
                                    <div class="xs-mt-50">
                                        <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Annuler</button>
                                        <button type="button" data-dismiss="modal"   @click="del()"  class="btn btn-space btn-danger">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default" style="background-color: #03aaf50a !important;">
                    <div class="panel-heading">Informations
                        {{--<div class="tools"> <button data-toggle="modal" data-target="#form-bp1" type="button" class="btn btn-space btn-success">Ajouter</button><span class="icon mdi mdi-more-vert"></span></div>--}}
                    </div>
                    <div class="form-group col-lg-4 col-sm-12" style="margin-top: 1em !important;">
                        <div class="tools"> <button data-toggle="modal" data-target="#form-bp1" type="button" class="btn btn-space btn-success">Ajouter</button></div>
                    </div>

                    <div class="panel-body">
                        <div id="divConteneur">
                            <table class="table table-condensed table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Titre</th>
                                    <th class="text-center">Contenu</th>
                                    <th class="text-center">Validité</th>
                                    {{--<th class="text-center">Etat</th>--}}
                                    <th class="text-center">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(info,i) in informations">

                                    <td class="text-center">@{{ i+1 }}</td>
                                    <td class="text-center">@{{ info.title }}</td>
                                    <td class="text-center">@{{ info.content }}</td>
                                    <td class="text-center">@{{ moment(info.start_date) }} au @{{ moment(info.end_date) }} </td>
                                    {{--<td class="text-center" v-if="info.is_active==0 || info.is_active==null">Désactivé</td>--}}
                                    {{--<td class="text-center" v-if="info.is_active==1">Activé</td>--}}

                                    <td class="text-center">
                                        {{--<a class="btn btn-warning"  @click="activateInformation(info)" >Activer</a>--}}
                                        <a class="btn btn-default"  @click="showEditorModal(info)"  data-toggle="modal">Modifier</a>
                                        <a class="btn btn-danger" @click="showDeleteModal(info)">Supprimer</a>

                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </template>
    <script src="{{ asset('js/vues/admin/information.js') }}" type="module"></script>
    <script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

@endsection

@section('content')
    <div class="row">
        <div class="ajustement">
            <h2 class="page-head-title ban">Informations</h2>
            <ol class="breadcrumb page-head-nav">
                <li class="active">Liste des informations</li>
            </ol>
        </div>
    </div>
    <Informations></Informations>


@endsection