@extends("default")
@section('css')@endsection

@section('js')
    <template id="account">

        <div class="">
            <div class="">
                <div class="">
                    <div class="splash-container sign-up">
                        <div class="panel panel-default panel-border-color panel-border-color-primary">
                            <div class="panel-heading"><img src="{{ asset('images/sign-c.png')}}" alt="logo" width="150" class="logo-img"></div>
                            <div class="panel-body">
                                <span class="splash-title xs-pb-20">Paramètre de compte</span>
                                <span class="splash-description">Veuillez modifier vos paramètres de connexion</span>



                                <div class="form-group">
                                    <input type="email" v-model="seting.email"  required=""  plceholder="Email" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="password" v-model="seting.passwordold" required="" placeholder="votre ancien Password" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="password" v-model="seting.password"  placeholder="votre nouveau Password" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group xs-pt-10">
                                    <button type="submit" @click="para" class="btn btn-block btn-primary btn-xl">Enregistrer</button>
                                </div>


                                {{--<div class="form-group xs-pt-10">
                                    <div class="be-checkbox">
                                        <label for="remember">Vos identifiants seront changé selon les <a href="#">termes accords</a> </label>
                                    </div>
                                </div>--}}

                            </div>
                        </div>
                        {{--<div class="splash-footer">&copy; 2016 SAFARTECH</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </template>


    <script src="{{asset('assets/lib/summernote/summernote.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/lib/summernote/summernote-ext-beagle.js')}}" type="text/javascript"></script>
    <script src="{{('assets/lib/bootstrap-markdown/js/bootstrap-markdown.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/lib/markdown-js/markdown.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/vues/user/account.js')}}" type="module"></script>

@endsection

@section('content')

    <Account></Account>


@endsection