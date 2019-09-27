@if(Auth()->user()->isAdmin())

    {{--@php return view('layouts.sidebars.admin') @endphp--}}
    @include('layouts.sidebars.admin')
    @elseif(Auth()->user()->isProf())

    @include('layouts.sidebars.prof')

    @elseif(Auth()->user()->isParent())

    @include('layouts.sidebars.parent')

    @elseif(Auth()->user()->isEleve())

    @include('layouts.sidebars.eleve')

    @elseif(Auth()->user()->isVieScolaire())

    @include('layouts.sidebars.vs')



@endif