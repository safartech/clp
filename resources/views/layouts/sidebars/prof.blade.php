<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Dashboard</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menu</li>
                        <li class=""><a href="{{ route('home') }}"><i class="icon mdi mdi-home"></i><span>Home</span></a></li>
                        {{--<li class="parent"><a href=""><i class="icon mdi mdi-chart-donut"></i><span>Emploi du temps</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('prof.planning.classe') }}">Classe</a></li>
                                <li><a href="{{ route('profs.planning.prof') }}">Professeur</a></li>
                                --}}{{--<li><a href="{{ route('admin.planning.salles') }}">Salles</a></li>--}}{{--
                            </ul>
                        </li>--}}
                        <li class="parent"><a href="#"><i class="icon mdi mdi mdi-layers"></i><span>Evaluations</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('prof.evaluations.notes') }}">Notes</a></li>
                                {{--<li><a href="{{ route('admin.evaluations.releves') }}">Relevés de notes</a></li>--}}
                                <li><a href="{{ route('prof.evaluations.bulletins') }}">Bulletins</a></li>
                                <li><a href="{{ route('prof.evaluations.epc') }}">Evalaution par compétence</a></li>
                            </ul>
                        </li>
                        <li ><a href="{{ route('conseil') }}"><i class="icon mdi mdi-home"></i><span>Conseil</span></a>
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
        {{--<div class="progress-widget">
            <div class="progress-data"><span class="progress-value">60%</span><span class="name">Current Project</span></div>
            <div class="progress">
                <div style="width: 60%;" class="progress-bar progress-bar-primary"></div>
            </div>
        </div>--}}
    </div>
</div>