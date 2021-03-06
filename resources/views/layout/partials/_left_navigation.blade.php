<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header" style="padding: 0">
                <div class="profile-element">
                    <a href="{{ route('home') }}" style="padding: 0;">
                        <img src="{{ asset('images/Equimundo_Logo_long.png') }}" alt="" style="width: 100%;">
                    </a>
                </div>
                <div class="logo-element" style="padding: 0">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/Equimundo_Logo_neg.svg') }}" alt="" style="width: 100%">
                    </a>
                </div>
            </li>
            @if (auth()->check())
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-list"></i> <span class="nav-label">{{ trans('copy.a.timeline') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.profiles.show', auth()->user()->slug()) }}">
                        <i class="fa fa-user"></i> <span class="nav-label">{{ trans('copy.titles.profile') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('conversation.index') }}">
                        <i class="fa fa-envelope"></i> <span class="nav-label">{{ trans('copy.titles.messages') }}</span>
                        @if (auth()->user()->countUnreadMessages())
                            <span class="label label-warning pull-right">{{ auth()->user()->countUnreadMessages() }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">{{ trans('copy.titles.horses') }}</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @foreach (auth()->user()->horses() as $horse)
                            <li>
                                <a href="{{ route('horses.show', $horse->slug()) }}">{{ $horse->name() }}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{route('horses.create')}}">
                                {{ trans('copy.a.create_a_horse') }} <span class="label label-primary pull-right">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users"></i> <span class="nav-label">{{ trans('copy.titles.companies_groups') }}</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @foreach(auth()->user()->companies() as $company)
                            <li>
                                <a href="{{ route('companies.show', $company->slug()) }}">{{ $company->name() }}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('company.create') }}">
                                {{ trans('copy.a.create_a_group') }} <span class="label label-primary pull-right">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li {{ Active::route('wiki.*', 'active') }}>
                <a href="{{ route('wiki.index') }}">
                    <i class="fa fa-info"></i> <span class="nav-label">Wiki</span>
                </a>
            </li>
        </ul>

    </div>
</nav>
