@extends("default")
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/lib/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/plugins/tooltip/tooltip.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/momentjs/moment.js')}}"></script>
    <script src="{{ asset('js/momentjs/moment-with-locales.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script type="module" src="{{ asset('js/vues/protected/retards.js') }}"></script>

    <template id="retard">
        <div>
            <div class="col-lg-8">
                <div class="panel panel-default panel-border-color panel-border-color-primary coll">
                    <div class="panel-heading panel-heading-divider">Retards<span class="panel-subtitle">Gestion des retards.</span></div>
                    <div class="panel-body">

                        <div class="col-lg-3">
                            <div class=""><label class="control-label">Session en cours</label></div>
                            <div class="">
                                <select id="select2-session" class="select2">
                                    <option :value="null" disabled selected  >Selectionner la session</option>
                                    <option v-for="session in sessions" :value="session.id">@{{ session.nom }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class=""><label class="control-label">Date</label></div>
                            <div id="date" data-start-view="3"  data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date">
                                <input size="16" type="text" value="" class="form-control"><span class="input-group-addon btn btn-success"><i class="icon-th mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class=""><label class="control-label">Classes</label></div>
                            <div class="">
                                <select id="select2-classe" class="select2">
                                    {{--<option :value="null" disabled selected  >Selectionner une classe</option>--}}
                                    <option :value="0" selected>Toutes les classes</option>
                                    <option v-for="classe in classes" :value="classe.id">@{{ classe.nom }}</option>
                                </select>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <img class="img-responsive" src="{{ asset('images/infos.jpg')}}"/>
            </div>

            <div class="col-sm-12" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{--Classe <b>(@{{ currentClasse.nom }})</b>--}}
                        {{--                        Effectif <b>(@{{ eleves.length }})</b>--}}
                        <div class="tools">
                            {{--<span class="icon mdi mdi-download"></span>--}}
                            <span class="icon mdi mdi-close-circle"></span>
                            <span class="icon mdi mdi-more-vert"></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="divConteneur">
                        <table id="mainTable" class="table table-condensed table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nom</th>
                                <th class="text-center">Prénoms</th>
                                <th class="text-center">Classe</th>
                                <th class="text-center">Nombre de retards</th>
                                <th class="text-center">En retard ?</th>
                                {{--<th>Action</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(eleve,i) in filteredEleves">
                                <td class="text-center">@{{ i+1 }}</td>
                                <td class="text-center">@{{ eleve.nom }}</td>
                                <td class="text-center">@{{ eleve.prenoms }}</td>
                                <td class="text-center">@{{ eleve.classe.nom }}</td>
                                <td class="text-center"><span v-if="selectedSessionId!=null">@{{ countRetardBySession(eleve) }}</span></td>
                                <td class="text-center">
                                    <div class="be-checkbox be-checkbox-color inline" v-if="isReady">
                                        <input :id="i" type="checkbox" :checked="wasLate(eleve)" @change="setRetard(eleve)">
                                        <label :for="i"></label>
                                    </div>
                                </td>
                                {{--<td></td>--}}
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

@endsection

@section('content')
    <Retard></Retard>
@endsection