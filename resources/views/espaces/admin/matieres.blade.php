@extends("default")
@section('css')@endsection

@section('js')
    <template id="matieres">
        <div class="row">
            <div class="col-lg-9 m-b-md">
            <div id="form-bp1"  role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #34a853;">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Ajout Matiere</h3>
                        </div>
                        <div class="modal-body ">
                            <div class="form-group col-md-12">
                                <label>Nom Matiere</label>
                                <input type="text"  v-model="newMatiere.intitule" placeholder="Nom Matiere" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Indice Couleur</label>
                                <input type="text" v-model="newMatiere.couleur" placeholder="Indice Couleur" class="form-control">
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                            <button type="button" data-dismiss="modal" class="btn btn-primary md-close" style="background-color: #34a853; border-color: #34a853;" @click="addMatiere"><i style="color:white;" class="icon mdi mdi-plus-circle-o"></i> Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="form-bp2"  role="dialog" class="modal fade colored-header colored-header-primary">
                <div class="modal-dialog custom-width">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
                            <h3 class="modal-title">Modification Matiere</h3>
                        </div>
                        <div class="modal-body ">
                            <div class="form-group col-md-12">
                                <label>Nom Matiere</label>
                                <input type="text"  v-model="updateMatiere.intitule" placeholder="Nom Matiere" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Indice Couleur</label>
                                <input type="text" v-model="updateMatiere.couleur" placeholder="Indice Couleur" class="form-control">
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Annuler</button>
                            <button type="button" data-dismiss="modal" class="btn btn-primary md-close" @click="updatematiere" ><i style="color:white;" class="icon mdi mdi-plus-circle-o"></i> Modifier</button>
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
                                <h3>Attention!!!!</h3>
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
                <div class="panel-heading">Matieres
                    <div class="tools"> <button data-toggle="modal" data-target="#form-bp1" type="button" class="btn btn-space btn-success  "><i style="color:white;" class="icon mdi mdi-plus-circle-o"></i> Ajouter</button><span class="icon mdi mdi-more-vert"></span></div>
                </div>
                <div class="panel-body">
                    <div id="divConteneur">
                    <table class="table table-condensed table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Couleur</th>
                            <th class="text-center">Nom Matiere</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(matiere,i) in matieres">

                            <td class="text-center">@{{ i+1 }}</td>
                            <td class="text-center" :style="{'background-color': matiere.couleur}"></td>
                            <td class="text-center">@{{ matiere.intitule }}</td>
                            <td class="text-center">

                                <a class="btn btn-default"  @click="showEditorModal(matiere)" data-toggle="modal">Modifier</a>
                                <a class="btn btn-danger"  @click="showDeleteModal(matiere)">Supprimer</a>
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
    <script src="{{ asset('js/vues/admin/matieres.js') }}" type="module"></script>
@endsection

@section('content')

<div class="row">
<div class="ajustement">
             <h2 class="page-head-title ban">Matières</h2>
             <ol class="breadcrumb page-head-nav">
                                 <li class="active">Liste des matières</li>
                             </ol>
        </div>
        </div>
        <Matieres></Matieres>


@endsection