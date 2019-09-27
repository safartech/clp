@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-form mt-2">
                <div class="center cadre-auth-logo">
                    <img class="img-responsive" style="width: 300px" src="{{asset('images/logo-cl.jpg')}}"/>
                </div>

                 <div class="cadre-auth">
                       <h2 class="m-t-n-sm m-b-md hidden-xs">AUTHENTIFICATION</h2>
                       <h3 class="m-t-n-sm m-b-md hidden-lg hidden-md hidden-sm">AUTHENTIFICATION</h3>
                       <!--<p>Entrez vos param?tres de connexion</p>-->



                <div class="">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="">
                                <input placeholder="E-mail" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="">
                                <input placeholder="Mot de passe" id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Se rappeler de moi
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="" >
                                <button type="submit" class="btn btn-primary">
                                    Se connecter
                                </button>
                                    <br>
                                {{--<a class="btn btn-link" href="{{ route('password.request') }}">
                                    Mot de passe oublié?
                                </a>--}}
                            </div>
                        </div>
                        <hr>
                        {{--<div class="form-group" style="margin-top: -30px">
                            <h3>Pas de compte existant ?</h3>
                            <div class="">
                                <a class="btn btn-primary" href="{{ route('register') }}">S'INSCRIRE </a>
                            </div>
                        </div>--}}
                    </form>
                </div></div>
            </div>
        </div>
    </div>
</div>

@endsection
