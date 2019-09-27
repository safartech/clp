@extends("default")
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css') }}"/>
    <style>
        .select2{
            width: 100%;

        }

    </style>

@endsection

@section('js')
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}" type="module"></script>
    <template id="responsables">
<div class="row">

        <div class="col-lg-9 m-b-md">
            <div id="form-bp1"  role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #34a853;">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Ajout Responsable</h3>
                        </div>
                        <div class="modal-body ">

                            <div class="form-group col-md-6">
                                <label>Nom</label>
                                <input type="text"  v-model="newResponsable.nom" placeholder="Nom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Prenoms</label>
                                <input type="text"  v-model="newResponsable.prenoms" placeholder="Prenoms" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Profession</label>
                                <input type="text"  v-model="newResponsable.profession" placeholder="Profession" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label xs-pt-20">Sexe</label>
                                    <div class="col-sm-6">
                                        <div class="be-radio-icon inline">
                                            <input  v-model="newResponsable.sexe" type="radio" checked="" value="F" name="radu" id="radu">
                                            <label for="radu"><span class="mdi mdi-female"></span></label>
                                        </div>
                                        <div class="be-radio-icon inline">
                                            <input type="radio" v-model="newResponsable.sexe" name="radk" value="M" id="radk">
                                            <label for="radk"><span class="mdi mdi-male-alt"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Domicile</label>
                                <input type="text"   v-model="newResponsable.domicile" placeholder="Votre Domicile" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Code Postal</label>
                                <input type="text"   v-model="newResponsable.code_postal" placeholder="Code Postal" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mail</label>
                                <input type="text"  v-model="newResponsable.email" placeholder="E-mail" class="form-control">
                            </div>



                            <div class="form-group col-md-6">
                                <label>Bureau</label>
                                <input type="text"   v-model="newResponsable.bureau" placeholder="Bureau" class="form-control">
                            </div>



                            <input type="hidden" v-model="nomComplet" placeholder="Telephone Mobile" class="form-control">


                            {{--<div class="row">--}}
                            {{--<div class="form-group col-md-12">--}}
                            {{--<div class="be-checkbox">--}}
                            {{--<input id="check2" type="checkbox">--}}
                            {{--<label for="check2">Send me notifications about new products and services.</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>


                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                            <button type="button" data-dismiss="modal" class="btn btn-primary md-close" style="background-color: #34a853; border-color: #34a853;" @click="addResponsable">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>




            <div id="form-bp2"  role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #34a853;">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Modification Responsable</h3>
                        </div>
                        <div class="modal-body ">

                            <div class="form-group col-md-6">
                                <label>Nom</label>
                                <input type="text"  v-model="updateResponsable.nom" placeholder="Nom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Prenoms</label>
                                <input type="text"  v-model="updateResponsable.prenoms" placeholder="Prenoms" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-2"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label xs-pt-20">Sexe</label>
                                    <div class="col-sm-6">
                                        <div class="be-radio-icon inline">
                                            <input value="F" v-model="updateResponsable.sexe" type="radio" name="radm" id="radm">
                                            <label for="radm"><span class="mdi mdi-female"></span></label>
                                        </div>
                                        <div class="be-radio-icon inline">
                                            <input type="radio" v-model="updateResponsable.sexe" name="radn" value="M" id="radn">
                                            <label for="radn"><span class="mdi mdi-male-alt"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Domicile</label>
                                <input type="text"   v-model="updateResponsable.domicile" placeholder="Votre Domicile" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Code Postal</label>
                                <input type="text"   v-model="updateResponsable.code_postal" placeholder="Code Postal" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mail</label>
                                <input type="text"  v-model="updateResponsable.email" placeholder="E-mail" class="form-control">
                            </div>


                            <div class="form-group col-md-6">
                                <label>Bureau</label>
                                <input type="text"   v-model="updateResponsable.bureau" placeholder="Bureau" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Profession</label>
                                <input type="text"  v-model="updateResponsable.profession" placeholder="Profession" class="form-control">
                            </div>

                            <input type="hidden" v-model="nomComplet" placeholder="Telephone Mobile" class="form-control">


                            {{--<div class="row">--}}
                            {{--<div class="form-group col-md-12">--}}
                            {{--<div class="be-checkbox">--}}
                            {{--<input id="check2" type="checkbox">--}}
                            {{--<label for="check2">Send me notifications about new products and services.</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>


                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                            <button type="button"  data-dismiss="modal" class="btn btn-default md-close"  style="background-color: #34a853; border-color: #34a853;"  @click="updateresponsable">Modifier</button>
                        </div>
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
                                <h3>Attension!!!!</h3>
                                <p>L' élément sera définitivement supprimer de la Base de Donnée.</p>
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


            <div class="panel panel-default">
                <div class="panel-heading">Parents d'élèves
                    <div class="tools"> <button data-toggle="modal" data-target="#form-bp1" type="button" class="btn btn-space btn-success  ">Ajouter</button><span class="icon mdi mdi-more-vert"></span></div>
                </div>
                <div class="form-group col-lg-4 col-sm-12">
                    <div class=""><label class="control-label">Recherche</label></div>
                    <div class="">
                        <input class="form-control" type="text" v-model="search">
                    </div>
                </div>
                <div class="panel-body">
                    <div id="divConteneur">
                    <table class="table table-condensed table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nom</th>
                            <th class="text-center">Prénoms</th>
                            <th class="text-center">Profession</th>
                            <th class="text-center">Sexe</th>
                            <th class="text-center">Adresse</th>
                            {{--<th class="text-center">Mail</th>--}}
                            <th class="text-center">Contact</th>
                            <th class="text-center">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(responsable,i) in responsables">

                            <td class="text-center">@{{ i+1 }}</td>

                            <td class="text-center">@{{ responsable.nom }}</td>
                            <td class="text-center">@{{ responsable.prenoms }}</td>
                            <td class="text-center">@{{ responsable.profession }}</td>
                            <td class="text-center">@{{ responsable.sexe }}</td>
                            <td class="text-center">@{{ responsable.domicile }}</td>
                            {{--<td class="text-center">@{{ responsable.email }}</td>--}}
                            <td class="text-center">@{{ responsable.bureau }}</td>
                            <td class="text-center">
                                <a class="btn btn-default" title="Modifier" @click="showEditorModal(responsable)"  data-toggle="modal"><i class="icon mdi mdi-edit"></i></a>

                                <button data-toggle="modal" title="Supprimer" type="button" @click="showDeleteModal(responsable)" class="btn btn-danger md-close"><i class="icon mdi mdi-delete"></i></button>




                            </td>

                        </tr>

                        </tbody>
                    </table>
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


    </template>
    <script src="{{ asset('js/vues/admin/responsables.js') }}" type="module"></script>
    <script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
@endsection

@section('content')

<div class="row">
<div class="ajustement">
             <h2 class="page-head-title ban">Parents d'élèves</h2>
             <ol class="breadcrumb page-head-nav">
                                 <li class="active">Liste des parents d'élèves</li>
                             </ol>
        </div>
        </div>

    <Responsables></Responsables>


@endsection