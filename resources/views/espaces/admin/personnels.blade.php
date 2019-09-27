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
    <template id="Personnels">
<div class="row">

        <div class="col-lg-9 m-b-md">
            <div id="form-bp1"  role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #34a853;">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Ajout Personnel</h3>
                        </div>
                        <div class="modal-body ">
                            <div class="form-group col-md-6">
                                <label>Nom</label>
                                <input type="text"  v-model="newPersonnel.nom" placeholder="Nom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Prenoms</label>
                                <input type="text" v-model="newPersonnel.prenoms" placeholder="Prenoms" class="form-control">
                            </div>



                            <div class="col-md-12">
                                <div class="col-md-2"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label xs-pt-20">Sexe</label>
                                    <div class="col-sm-6">
                                        <div class="be-radio-icon inline">
                                            <input   v-model="newPersonnel.sexe" value="F" type="radio" checked="" name="rad1" id="rad1">
                                            <label for="rad1"><span class="mdi mdi-female"></span></label>
                                        </div>
                                        <div class="be-radio-icon inline">
                                            <input type="radio" v-model="newPersonnel.sexe" name="rad1" value="M" id="rad2">
                                            <label for="rad2"><span class="mdi mdi-male-alt"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Diplome</label>
                                <input type="text"  v-model="newPersonnel.diplomes" placeholder="Diplome" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Adresse</label>
                                <input type="text" v-model="newPersonnel.adresse" placeholder="Adresse" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Quartier</label>
                                <input type="text" v-model="newPersonnel.quartier" placeholder="Quartier" class="form-control">
                            </div>


                            <div class="form-group col-md-6">
                                <label>Telephone Domicile</label>
                                <input type="text" v-model="newPersonnel.tel_domicile" placeholder="Adresse" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Telephone Mobile</label>
                                <input type="text" v-model="newPersonnel.tel_mobile" placeholder="Telephone Mobile" class="form-control">
                            </div>


                                <input type="hidden" v-model="nomComplet" placeholder="Telephone Mobile" class="form-control">

                        </div>


                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                            <button type="button" data-dismiss="modal" class="btn btn-primary md-close" style="background-color: #34a853; border-color: #34a853;" @click="addPersonnel">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="form-bp2"  role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #34a853;">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Modification Personnel</h3>
                        </div>
                        <div class="modal-body ">
                            <div class="form-group col-md-6">
                                <label>Nom</label>
                                <input type="text"  v-model="updatePersonnel.nom" placeholder="Nom" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Prenoms</label>
                                <input type="text" v-model="updatePersonnel.prenoms" placeholder="Prenoms" class="form-control">
                            </div>



                            <div class="col-md-12">
                                <div class="col-md-2"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label xs-pt-20">Sexe</label>
                                    <div class="col-sm-6">
                                        <div class="be-radio-icon inline">
                                            <input   v-model="updatePersonnel.sexe" value="F" type="radio" checked="" name="radm" id="radm">
                                            <label for="radm"><span class="mdi mdi-female"></span></label>
                                        </div>
                                        <div class="be-radio-icon inline">
                                            <input type="radio" v-model="updatePersonnel.sexe" name="radu" value="M" id="radu">
                                            <label for="radu"><span class="mdi mdi-male-alt"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Diplome</label>
                                <input type="text"  v-model="updatePersonnel.diplomes" placeholder="Diplome" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Adresse</label>
                                <input type="text" v-model="updatePersonnel.adresse" placeholder="Adresse" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Quartier</label>
                                <input type="text" v-model="updatePersonnel.quartier" placeholder="Quartier" class="form-control">
                            </div>


                            <div class="form-group col-md-6">
                                <label>Telephone Domicile</label>
                                <input type="text" v-model="updatePersonnel.tel_domicile" placeholder="Adresse" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Telephone Mobile</label>
                                <input type="text" v-model="updatePersonnel.tel_mobile" placeholder="Telephone Mobile" class="form-control">
                            </div>


                            <input type="hidden" v-model="nomComplets" placeholder="Telephone Mobile" class="form-control">

                        </div>


                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                            <button type="button" data-dismiss="modal" class="btn btn-primary md-close" style="background-color: #34a853; border-color: #34a853;" @click="updatepersonnel">Modifier</button>
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
                                <p>L' ?l?ment sera d?finitivement supprimer de la Base de Donn?e.</p>
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
                <div class="panel-heading">Personnels
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
                            <th>#</th>
                            <th class="text-center">Nom</th>

                            <th class="text-center">Prenoms</th>
                            {{--<th class="text-center">Role</th>--}}
                            <th class="text-center">Sexe</th>
                            <th class="text-center">Adresse</th>
                            <th class="text-center">Contact</th>
                            {{--<th class="text-center">Email</th>--}}
                            {{--<th class="text-center">Nom Complet</th>--}}
                            <th class="text-center">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(personnel,i) in personnels">

                            <td class="text-center">@{{ i+1 }}</td>

                            <td class="text-center">@{{ personnel.nom }}</td>
                            <td class="text-center">@{{ personnel.prenoms }}</td>
{{--                            <td class="text-center">@{{ personnel.user.role.display_name }}</td>--}}
                            <td class="text-center">@{{ personnel.sexe }}</td>
                            <td class="text-center">@{{ personnel.adresse }}</td>
                            <td class="text-center">@{{ personnel.contact }}</td>
                            {{--<td class="text-center">@{{ personnel.email }}</td>--}}
                            {{--<td class="text-center">@{{ personnel.nom_complet    }}</td>--}}
                            <td class="text-center">
                                <a class="btn btn-default"  @click="showEditorModal(personnel)"  data-toggle="modal">Modifier</a>
                                <a class="btn btn-danger" @click="showDeleteModal(personnel)">Supprimer</a>

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
    <script src="{{ asset('js/vues/admin/personnels.js') }}" type="module"></script>
    <script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="row">
<div class="ajustement">
             <h2 class="page-head-title ban">Personnels</h2>
             <ol class="breadcrumb page-head-nav">
                                 <li class="active">Liste du Personnel</li>
                             </ol>
        </div>
        </div>
    <Personnels></Personnels>


@endsection