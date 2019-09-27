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
                    <h2 class="m-t-n-sm m-b-md hidden-xs">MOT DE PASSE OUBLI&Eacute;</h2>
                    <h3 class="m-t-n-sm m-b-md hidden-lg hidden-md hidden-sm">MOT DE PASSE OUBLI&Eacute;</h3>
                    <!--<p>Entrez vos param?tres de connexion</p>-->



                    <div class="">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="">
                                <input id="email" type="email" class="form-control" placeholder="Votre e-mail" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
