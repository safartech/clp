@if(Auth()->user()->isAdmin())

    {{--@php return view('layouts.sidebars.admin') @endphp--}}
    @include('layouts.navbars.admin')

    @elseif(Auth()->user()->isProf())

    @include('layouts.navbars.prof')

    @elseif(Auth()->user()->isParent())

    @include('layouts.navbars.parent')

    @elseif(Auth()->user()->isEleve())

    @include('layouts.navbars.eleve')

    @elseif(Auth()->user()->isVieScolaire())

    @include('layouts.navbars.vs')





@endif