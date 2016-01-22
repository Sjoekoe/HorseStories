@extends('layout.left-aside')

@section('content')
    <div id="page-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#horses" data-toggle="tab" aria-expanded="true">{{ trans('copy.titles.horses') }}</a></li>
                                <li><a href="#following" data-toggle="tab" aria-expanded="false">{{ trans('copy.titles.following') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="horses" class="tab-pane fade active in">
                                <div class="col-sm-12">
                                    <h4 class="text-thin">{{ trans('copy.titles.horses') }}</h4>
                                </div>
                                @foreach($user->horses() as $horse)
                                    <div class="col-sm-4">
                                        <a href="{{ route('horses.show', $horse->slug()) }}">
                                            <div class="panel widget panel-bordered-mint">
                                                <div class="widget-header bg-purple">
                                                    <img class="widget-bg img-responsive" src="{{ asset('/images/header.jpg') }}" alt="Image">
                                                </div>
                                                <div class="widget-body text-center">
                                                    @if ($horse->getProfilePicture())
                                                        <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
                                                    @else
                                                        <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ asset('images/eqm.png') }}">
                                                    @endif
                                                    <h4 class="mar-no">{{ $horse->name() }}</h4>
                                                    <p class="text-muted mar-btm">{{ trans('horses.breeds.' . $horse->breed()) }}</p>

                                                    <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                                        <li class="col-sm-4">
                                                            <span class="text-lg">{{ count($horse->statuses()) }}</span>
                                                            <p class="text-muted text-uppercase">
                                                                <small>{{ trans('copy.a.statuses') }}</small>
                                                            </p>
                                                        </li>
                                                        <li class="col-sm-4">
                                                            @if (Auth::user()->isFollowing($horse))
                                                                {{ Form::open(['route' => ['follows.destroy', $horse->id()], 'method' => 'DELETE']) }}
                                                                <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') . $horse->name() }}</button>
                                                                {{ Form::close() }}
                                                            @else
                                                                {{ Form::open(['route' => ['follows.store', $horse->id()]]) }}
                                                                <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') . $horse->name() }}</button>
                                                                {{ Form::close() }}
                                                            @endif
                                                        </li>
                                                        <li class="col-sm-4">
                                                            <span class="text-lg">{{ count($horse->followers()) }}</span>
                                                            <p class="text-muted text-uppercase">
                                                                <small>{{ trans('copy.a.followers') }}</small>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div id="following" class="tab-pane fade">
                                <div class="col-sm-12">
                                    <h4 class="text-thin">{{ trans('copy.titles.following') }}</h4>
                                </div>
                                @foreach($user->follows() as $follow)
                                    <div class="col-sm-4">
                                        <div class="panel widget panel-bordered-mint">
                                            <div class="widget-header bg-purple">
                                                <img class="widget-bg img-responsive" src="{{ asset('/images/header.jpg') }}" alt="Image">
                                            </div>
                                            <div class="widget-body text-center">
                                                @if ($horse->getProfilePicture())
                                                    <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ route('file.picture', $follow->getProfilePicture()->id()) }}">
                                                @else
                                                    <img alt="Profile Picture" class="widget-img img-circle img-border-light" src="{{ asset('images/eqm.png') }}">
                                                @endif
                                                <h4 class="mar-no">{{ $follow->name() }}</h4>
                                                <p class="text-muted mar-btm">{{ trans('horses.breeds.' . $follow->breed()) }}</p>

                                                <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                                    <li class="col-sm-4">
                                                        <span class="text-lg">{{ count($follow->statuses()) }}</span>
                                                        <p class="text-muted text-uppercase">
                                                            <small>{{ trans('copy.a.statuses') }}</small>
                                                        </p>
                                                    </li>
                                                    <li class="col-sm-4">
                                                        @if (auth()->user()->isFollowing($follow))
                                                            {{ Form::open(['route' => ['follows.destroy', $follow->id()], 'method' => 'DELETE']) }}
                                                            <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') . $horse->name() }}</button>
                                                            {{ Form::close() }}
                                                        @else
                                                            {{ Form::open(['route' => ['follows.store', $follow->id()]]) }}
                                                            <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') . $follow->name() }}</button>
                                                            {{ Form::close() }}
                                                        @endif
                                                    </li>
                                                    <li class="col-sm-4">
                                                        <span class="text-lg">{{ count($follow->followers()) }}</span>
                                                        <p class="text-muted text-uppercase">
                                                            <small>{{ trans('copy.a.followers') }}</small>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <aside id="aside-container">
        <div id="aside">
            <div class="nano">
                <div class="nano-content">

                    <!-- Simple profile -->
                    <div class="text-center pad-all">
                        <h4 class="text-lg text-overflow mar-no">{{ $user->fullName() }}</h4>

                        <div class="pad-ver btn-group">
                            <a title="" href="#" class="btn btn-icon btn-hover-primary fa fa-facebook icon-lg add-tooltip" data-original-title="Facebook" data-container="body"></a>
                            <a title="" href="#" class="btn btn-icon btn-hover-info fa fa-twitter icon-lg add-tooltip" data-original-title="Twitter" data-container="body"></a>
                        </div>
                        @if (auth()->user()->id() == $user->id())
                            <a href="{{ route('users.profiles.edit') }}" class="btn btn-block btn-mint">{{ trans('copy.a.edit') }}</a>
                        @else
                            <a href="{{ route('conversation.create', ['contact' => $user->id()]) }}" class="btn btn-block btn-mint">
                                {{ trans('copy.a.contact_message') }}
                            </a>
                        @endif
                    </div>
                    <hr>
                    <ul class="list-group bg-trans">

                        <!-- Profile Details -->
                        <li class="list-group-item list-item-sm">
                            <i class="fa fa-home fa-fw"></i> {{ trans('countries.' . $user->country()) }}
                        </li>
                        <li class="list-group-item list-item-sm">
                            <i class="fa fa-clock-o fa-fw"></i> Member since {{ eqm_translated_date($user->created_at)->diffForHumans() }}
                        </li>
                    </ul>
                    <hr>
                    <div class="pad-hor">
                        <h5>About Me</h5>
                        <small class="text-thin">
                            {{ $user->about() }}
                        </small>
                    </div>
                    <hr>
                    <div class="text-center clearfix">
                        <div class="col-xs-6">
                            <p class="h3">{{ count($user->horses()) }}</p>
                            <small class="text-muted">{{ trans('copy.titles.horses') }}</small>
                        </div>
                        <div class="col-xs-6">
                            <p class="h3">{{ count($user->follows()) }}</p>
                            <small class="text-muted">{{ trans('copy.titles.following') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
@stop
