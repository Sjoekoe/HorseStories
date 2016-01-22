<header id="navbar">
    <div id="navbar-container" class="boxed">
        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="brand-title">
                    <span class="brand-text">Equimundo</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->

        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">
                <div class="searchbox padding-large-top">
                    <div class="input-group custom-search-form mar-top">
                        {{ Form::open(['route' => 'search']) }}
                            {{ Form::text('search', null, ['placeholder' => trans('forms.placeholders.search') . '...', 'class' => 'form-control text-light']) }}
                        {{ Form::close() }}
                        <span class="input-group-btn">
                            <button class="text-muted" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </ul>
            <ul class="nav navbar-top-links pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('copy.titles.horses') }} <b class="caret"></b></a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow">
                        <div class="pad-all bord-btm">
                            <p class="text-lg text-muted text-thin mar-no">You have {{ count(auth()->user()->horses()) }} Horses</p>
                        </div>
                        <div class="nano scrollable">
                            <div class="nano-content">
                                <ul class="head-list">
                                    @foreach(Auth::user()->horses() as $horse)
                                        <li>
                                            <a href="{{ route('horses.show', $horse->slug()) }}" class="media">
                                                <div class="media-left">
                                                    @if ($horse->getProfilePicture())
                                                        <img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="img-circle img-sm">
                                                    @else
                                                        <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="img-circle img-sm">
                                                    @endif
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">{{ $horse->name() }}</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                    <div class="pad-all bord-top">
                                        <a href="{{ route('horses.create') }}" class="btn-link text-dark box-block">
                                            <i class="fa fa-plus-square-o fa-lg pull-right"></i>{{ trans('copy.a.create_a_horse') }}
                                        </a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <!--Messages Dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-envelope fa-lg"></i>
                        @if (Auth::user()->countUnreadNotifications())
                            <span class="badge badge-header badge-dark">{{ Auth::user()->countUnreadNotifications() }}</span>
                        @endif
                    </a>

                    <!--Message dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow">
                        <div class="pad-all bord-btm">
                            <p class="text-lg text-muted text-thin mar-no">You have 3 messages.</p>
                        </div>
                        <div class="nano scrollable">
                            <div class="nano-content">
                                <ul class="head-list">

                                    <!-- Dropdown list-->
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left">
                                                <img src="img/av2.png" alt="Profile Picture" class="img-circle img-sm">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Andy sent you a message</div>
                                                <small class="text-muted">15 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Dropdown list-->
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left">
                                                <img src="img/av4.png" alt="Profile Picture" class="img-circle img-sm">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Lucy sent you a message</div>
                                                <small class="text-muted">30 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Dropdown list-->
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left">
                                                <img src="img/av3.png" alt="Profile Picture" class="img-circle img-sm">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Jackson sent you a message</div>
                                                <small class="text-muted">40 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Dropdown list-->
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left">
                                                <img src="img/av6.png" alt="Profile Picture" class="img-circle img-sm">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Donna sent you a message</div>
                                                <small class="text-muted">5 hours ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Dropdown list-->
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left">
                                                <img src="img/av4.png" alt="Profile Picture" class="img-circle img-sm">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Lucy sent you a message</div>
                                                <small class="text-muted">Yesterday</small>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Dropdown list-->
                                    <li>
                                        <a href="#" class="media">
                                            <div class="media-left">
                                                <img src="img/av3.png" alt="Profile Picture" class="img-circle img-sm">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Jackson sent you a message</div>
                                                <small class="text-muted">Yesterday</small>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--Dropdown footer-->
                        <div class="pad-all bord-top">
                            <a href="#" class="btn-link text-dark box-block">
                                <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Messages
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End message dropdown-->

                <!--Notification dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="fa fa-bell fa-lg"></i>
                        @if (Auth::user()->hasUnreadNotifications())
                            <span class="badge badge-header badge-danger">{{ Auth::user()->countUnreadNotifications() }}</span>
                        @endif
                    </a>

                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow">
                        <div class="nano scrollable">
                            <div class="nano-content">
                                <ul class="head-list">
                                    <!-- Dropdown list-->
                                    @foreach (auth()->user()->notifications() as $notification)
                                        <li>
                                            <a href="{{ route('notifications.show', $notification->id()) }}" class="media">
                                                <div class="media-left">
														<span class="icon-wrap icon-circle bg-primary">
															<i class="fa {{ \EQM\Models\Notifications\Notification::ICONS[$notification->type()] }} fa-lg"></i>
														</span>
                                                </div>
                                                <div class="media-body">
                                                    <div>{{ trans('notifications.' . $notification->type(), json_decode($notification->data(), true)) }}</div>
                                                    <small class="text-muted">{{ eqm_translated_date($notification->created_at)->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!--Dropdown footer-->
                        <div class="pad-all bord-top">
                            <a href="{{ route('notifications.index') }}" class="btn-link text-dark box-block">
                                <i class="fa fa-angle-right fa-lg pull-right"></i>{{ trans('copy.a.show_all_notifications') }}
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End notifications dropdown-->

                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <div class="username hidden-xs">{{ auth()->user()->fullName() }}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <li>
                                <a href="{{ route('users.profiles.show', Auth::user()->id) }}">
                                    <i class="fa fa-user fa-fw fa-lg"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('conversation.index') }}">
                                    @if (Auth::user()->countUnreadNotifications())
                                        <span class="badge badge-mint pull-right">{{ Auth::user()->countUnreadNotifications() }}</span>
                                    @endif
                                    <i class="fa fa-envelope fa-fw fa-lg"></i> Messages
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">
                                    <i class="fa fa-gear fa-fw fa-lg"></i> {{ trans('copy.a.settings') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">
                                    <i class="fa fa-sign-out fa-fw fa-lg"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->

            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>

{{--<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand navbar-brand-centered">Equimundo</a>
        </div>
        <div class="nav navbar-nav navbar-left">
            @if (auth()->check())
                {{ Form::open(['route' => 'search']) }}
                    {{ Form::text('search', null, ['placeholder' => trans('forms.placeholders.search') . '...', 'class' => 'form-control']) }}
                {{ Form::close() }}
            @endif
        </div>
        <div class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <ul class="navbar-nav nav">
                    <li><a href="{{ route('login') }}">{{ trans('copy.a.sign_in') }}</a></li>
                    <li><a href="{{ route('register') }}">{{ trans('copy.a.sign_up') }}</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('conversation.index') }}">
                            {{ trans('copy.a.messages') }}

                            @if (Auth::user()->hasUnreadMessages())
                                <span class="badge badge-normal">{{ Auth::user()->countUnreadMessages() }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a href="{{ route('notifications.index') }}" class="collection-item grey lighten-3">
                            {{ trans('copy.a.notifications') }}
                            @if (Auth::user()->hasUnreadNotifications())
                                <span class="new badge">{{ Auth::user()->countUnreadNotifications() }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('copy.titles.horses') }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('horses.index', Auth::user()->id) }}">{{ trans('copy.a.my_horses') }}</a>
                            </li>
                            <li class="divider"></li>
                            @foreach(Auth::user()->horses() as $horse)
                                <li>
                                    <a href="{{ route('horses.show', $horse->slug()) }}">{{ $horse->name }}</a>
                                </li>
                            @endforeach

                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('horses.create') }}">
                                    {{ trans('copy.a.create_a_horse') }} <span class="badge badge-info"><i class="fa fa-plus-square-o"></i></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth()->user()->fullName() }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('users.profiles.show', Auth::user()->id) }}">
                                    <span class="fa fa-user"></span> {{ Auth::user()->fullName() }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">
                                    {{ trans('copy.a.settings') }}
                                </a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.dashboard') }}">
                                        Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}">
                                    {{ trans('copy.a.logout') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>--}}
