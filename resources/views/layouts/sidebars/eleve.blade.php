<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Dashboard</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menu</li>
                        <li class=""><a href="{{ route('home') }}"><i class="icon mdi mdi-home"></i><span>Home</span></a>
                        {{--<li class=""><a href="{{ route('eleve.planning') }}"><i class="icon mdi mdi-home"></i><span>Emploi du temps</span></a></li>--}}
                        <li class="parent"><a href=""><i class="icon mdi mdi-chart-donut"></i><span>Evaluations</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('eleve.evaluations.notes') }}">Notes</a></li>
                                {{--<li><a href="{{ route('eleve.evaluations.releves') }}">Relevés</a></li>--}}
                                {{--<li><a href="{{ route('eleve.evaluations.bulletins') }}">Bulletins</a></li>--}}
                            </ul>
                        </li>

                        <li ><a href="{{ route('admin.blog') }}"><i class="icon mdi mdi-collection-bookmark"></i><span>Blog</span></a></li>
                        <li ><a href="{{ route('admin.accountsetting') }}" ><i class="icon mdi mdi-account"></i><span>Paramètres Compte</span></a></li>


                        <li class="active">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon mdi mdi-power"></i>
                                <span>Déconnexion</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>