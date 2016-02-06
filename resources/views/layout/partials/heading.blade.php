<div class="panel mar-no">
    <div class="panel-bg-cover">
        <img src="{{ asset('images/header.jpg') }}" alt="{{ $horse->name() }}" class="img-responsive">
    </div>
    <div class="panel-media mar-btm pad-no" style="padding-bottom: 0px;">
        @if ($horse->getProfilePicture())
            <img src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}" alt="{{ $horse->name() }}" class="panel-media-img img-circle img-border-light">
        @else
            <img src="{{ asset('images/eqm.png') }}" alt="{{ $horse->name() }}" class="panel-media-img img-circle img-border-light">
        @endif
        <div class="row mar-btm">
            <div class="col-lg-7">
                <h3 class="panel-media-heading text-mint">{{ $horse->name() }}</h3>
                <p>{{ trans('horses.breeds.' . $horse->breed()) }}</p>
                <p>{{ $horse->father() ? $horse->father()->name() : '' }} <bold>X</bold> {{ $horse->father() && $horse->mothersFather() ? $horse->mothersFather()->name() : '' }}</p>
            </div>
            <div class="col-lg-5 text-lg-right">
                <div class="heading-button pull-right">
                    @if (auth()->user()->isInHorseTeam($horse))
                        <a href="{{ route('horses.edit', $horse->slug()) }}" class="btn btn-sm btn-mint">{{ trans('copy.a.edit_horse', ['horse' => $horse->name()]) }}</a>
                    @else
                        @include('horses.partials.follow-form')
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-lg-offset-3">
                <ul class="list-unstyled text-center pad-top mar-no clearfix">
                    <li class="col-lg-2 {{ Active::route('horses.show', 'bg-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('horses.show', $horse->slug()) }}">
                                <i class="fa fa-list fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-lg-2 {{ Active::route('horse.info', 'bg-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('horse.info', $horse->slug()) }}">
                                <i class="fa fa-info-circle fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-lg-2 {{ Active::route('follows.index', 'bg-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('follows.index', $horse->slug()) }}">
                                <i class="fa fa-users fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-lg-2 {{ Active::route('horses.pictures.index', 'bg-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('horses.pictures.index', $horse->slug()) }}">
                                <i class="fa fa-camera fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-lg-2 {{ Active::route('pedigree.index', 'bg-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('pedigree.index', $horse->slug()) }}">
                                <i class="fa fa-share-alt fa-2x"></i>
                            </a>
                        </p>
                    </li>
                    <li class="col-lg-2 {{ Active::route('palmares.index', 'bg-mint') }} pad-all">
                        <p class="text-muted text-uppercase">
                            <a href="{{ route('palmares.index', $horse->slug()) }}">
                                <fa class="fa fa-trophy fa-2x"></fa>
                            </a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
