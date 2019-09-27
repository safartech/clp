<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Dashboard</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menu</li>
                        <li class=""><a href="{{ route('home') }}"><i class="icon mdi mdi-home"></i><span>Home</span></a>
                        {{--<li class=""><a href="{{ route('parent.planning') }}"><i class="icon mdi mdi-home"></i><span>Emploi du temps</span></a></li>--}}
                        <li class="parent"><a href="#"><i class="icon mdi mdi mdi-layers"></i><span>Evaluations</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('parent.evaluations.notes') }}">Notes</a></li>
                                {{--<li><a href="{{ route('admin.evaluations.releves') }}">Relevés de notes</a></li>--}}
                                <li><a href="{{ route('parent.evaluations.bulletins') }}">Bulletins</a></li>
                                <li><a href="{{ route('parent.evaluations.epc') }}">Evalaution par compétence</a></li>
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