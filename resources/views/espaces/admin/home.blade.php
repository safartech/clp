@extends("default")
@section('css')@endsection

@section('js')@endsection

@section('content')

<div class="hidden-xs">
    <img class="img-thumbnail" style="" src="{{asset('images/welcome.jpg')}}"/>
</div>

<div class="hidden-lg hidden-md hidden-sm">
    <img class="img-thumbnail" style="" src="{{asset('images/welcomex.jpg')}}"/>
</div>

<div class="m-t-lg">
<div class="row">
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 m-b-md">
            <div class="inforide">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 rideone">
                    <img class="img-responsive" style="width: 200px" src="{{asset('images/teach.png')}}"/>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 fontsty">
                    <h4>Professeurs</h4>
                    <Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;">123</h1></strong>
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 m-b-md">
            <div class="inforide">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 ridetwo">
                   <img class="img-responsive" style="width: 200px" src="{{asset('images/students.png')}}"/>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 fontsty">
                    <h4>Elèves</h4>
                    <Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;">385</h1></strong>
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 m-b-md">
            <div class="inforide">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 ridethree">
                   <img class="img-responsive" style="width: 200px" src="{{asset('images/parents.png')}}"/>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 fontsty">
                    <h4>Parents</h4>
                    <Strong><h1 style="font-weight: 600;text-align: right;margin-right: 30px;">280</h1></strong>
                </div>
              </div>
            </div>
        </div>
</div>
</div>

@endsection