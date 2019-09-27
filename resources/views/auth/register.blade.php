@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-4 col-md-offset-4">
            <div class="login-form mt-2 m-b-md">
                <div class="center cadre-auth-logo">
                    <img class="img-responsive" style="width: 300px" src="{{asset('images/logo-cl.jpg')}}"/>
                </div>
                 <div class="cadre-auth">
                       <h2 class="m-t-n-sm m-b-md">INSCRIPTION</h2>


                <div class="">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                            {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="">
                                <input placeholder="Nom" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('name') }}</strong>
                                   </span>
                               @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="">
                                <input placeholder="E-mail" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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
                                <input placeholder="Confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    S'inscrire
                                </button>
                            </div>
                        </div>


                        <hr>
                        <div class="form-group" style="margin-top: -30px">
                            <h3>Déjà inscrit ?</h3>
                            <div class="">
                                <a class="btn btn-primary" href="{{ route('login') }}">SE CONNECTER</a>
                            </div>
                        </div>
                    </form>
                </div></div>
            </div>
        </div>
    </div>
</div>


@endsection
