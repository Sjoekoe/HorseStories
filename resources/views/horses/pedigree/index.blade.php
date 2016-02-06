@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
            <div class="row">
                <div class="table-responsive">
                    <table class="text-center pedigree col-lg-12">
                        <tbody>
                        <tr>
                            <td>
                                <div class="panel panel-bordered-mint mar-rgt">
                                    <div class="panel-body text-center">
                                        <h4 class="mar-btm">{{ $horse->name() }}</h4>
                                        <p class="text-muted"><strong>{{ trans('forms.labels.breed') }}</strong> {{ trans('horses.breeds.' . $horse->breed()) }}</p>
                                        <p class="text-muted"><strong>{{ trans('copy.p.born') }}</strong> {{ eqm_date($horse->dateOfBirth(), 'Y') }}</p>
                                        <p class="text-muted"><strong>{{ trans('copy.p.life_number') }}</strong> {{ $horse->lifeNumber() ? : '-' }}</p>
                                        <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                            <li class="col-sm-4">
                                                <span class="text-lg">{{ count($horse->statuses()) }}</span>
                                                <p class="text-muted text-uppercase">
                                                    <small>{{ trans('copy.a.statuses') }}</small>
                                                </p>
                                            </li>
                                            <li class="col-sm-4">
                                                @if (! auth()->user()->isInHorseTeam($horse))
                                                    @if (Auth::user()->isFollowing($horse))
                                                        {{ Form::open(['route' => ['follows.destroy', $horse->id()], 'method' => 'DELETE']) }}
                                                        <button type="submit" class="btn btn-mint">{{ trans('copy.a.unfollow') . $horse->name() }}</button>
                                                        {{ Form::close() }}
                                                    @else
                                                        {{ Form::open(['route' => ['follows.store', $horse->id()]]) }}
                                                        <button type="submit" class="btn btn-mint">{{ trans('copy.a.follow') . $horse->name() }}</button>
                                                        {{ Form::close() }}
                                                    @endif
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
                            </td>
                            <td>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="panel panel-bordered-info mar-hor">
                                                @if ($horse->father())
                                                    @include('horses.pedigree._partials._pedigree', ['family' => $horse->father()])
                                                @else
                                                    <div class="panel-body">
                                                        <a href="{{ route('pedigree.create', [$horse->slug(), 'type' => \EQM\Models\Pedigrees\Pedigree::FATHER]) }}" class="btn btn-mint">{{ trans('copy.a.add_father') }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <div class="panel panel-bordered-info mar-hor">
                                                        @if ($horse->father() && $horse->fathersFather())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->fathersFather()])
                                                        @else
                                                            <div class="panel-body">
                                                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="panel panel-bordered-pink mar-hor">
                                                        @if ($horse->father() && $horse->fathersMother())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->fathersMother()])
                                                        @else
                                                            <div class="panel-body">
                                                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="panel panel-bordered-pink mar-hor">
                                                @if ($horse->mother())
                                                    @include('horses.pedigree._partials._pedigree', ['family' => $horse->mother()])
                                                @else
                                                    <div class="panel-body">
                                                        <a href="{{ route('pedigree.create', [$horse->slug(), 'type' => \EQM\Models\Pedigrees\Pedigree::MOTHER]) }}" class="btn btn-mint">{{ trans('copy.a.add_mother') }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <div class="panel panel-bordered-info mar-hor">
                                                        @if ($horse->mother() && $horse->mothersFather())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->mothersFather()])
                                                        @else
                                                            <div class="panel-body">
                                                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="panel panel-bordered-pink mar-hor">
                                                        @if ($horse->mother() && $horse->mothersMother())
                                                            @include('horses.pedigree._partials._pedigree', ['family' => $horse->mothersMother()])
                                                        @else
                                                            <div class="panel-body">
                                                                <a href="{{ route('pedigree.create', [$horse->slug(), 'type=6']) }}" class="btn btn-mint">{{ trans('copy.a.add_father_mother') }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-bordered-info">
                            <div class="panel-header">
                                <h3 class="panel-title">
                                    {{ trans('copy.titles.sons') }}
                                </h3>
                            </div>
                            <div class="panel-body">
                                @foreach ($horse->sons() as $son)
                                    {{ $son->originalHorse->name() }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-bordered-pink">
                            <div class="panel-header">
                                <h3 class="panel-title">
                                    {{ trans('copy.titles.daughters') }}
                                </h3>
                            </div>
                            <div class="panel-body">
                                @foreach ($horse->daughters() as $daughter)
                                    {{ $daughter->originalHorse->name() }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--@if (auth()->user()->isInHorseTeam($horse))
        <div class="row">
            <a href="{{ route('pedigree.create', $horse->slug()) }}" class="btn">{{ trans('copy.a.add_family') }}</a>
        </div>
    @endif--}}
    {{--<div class="row pedigree">
        <div class="col s12">
            @if ($horse->hasFather())
                <div class="col s3 grandparent male">
                    @if ($family = $horse->fathersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug, 'type=5']) }}" class="black-text">{{ trans('copy.a.add_father_father') }}</a>
                        @endcan
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->fathersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug, 'type=6']) }}" class="black-text">{{ trans('copy.a.add_father_mother') }}</a>
                        @endcan
                    @endif
                </div>
            @endif

            @if ($horse->hasMother())
                <div class="col s3 grandparent male">
                    @if ($family = $horse->mothersFather())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can ('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type=7']) }}" class="black-text">{{ trans('copy.a.add_mother_father') }}</a>
                        @endcan
                    @endif
                </div>
                <div class="col s3 grandparent female">
                    @if ($family = $horse->mothersMother())
                        @include('horses.pedigree._partials._pedigree')
                    @else
                        @can('create-pedigree', $horse)
                            <a href="{{ route('pedigree.create', [$horse->slug(), 'type=8']) }}" class="black-text">{{ trans('copy.a.add_mother_mother') }}</a>
                        @endcan
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s6 parent male">
                @if ($family = $horse->father())
                    @include('horses.pedigree._partials._pedigree')
                @else
                    @can('create-pedigree', $horse)
                        <a href="{{ route('pedigree.create', [$horse->slug(), 'type=1']) }}" class="black-text">{{ trans('copy.a.add_father') }}</a>
                    @endcan
                @endif
            </div>
            <div class="col s6 parent female">
                @if ($family = $horse->mother())
                    @include('horses.pedigree._partials._pedigree')
                @else
                    @can('create-pedigree', $horse)
                        <a href="{{ route('pedigree.create', [$horse->slug(), 'type=2']) }}" class="black-text">{{ trans('copy.a.add_mother') }}</a>
                    @endcan
                @endif
            </div>
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s12 self">
                <a href="{{ route('horses.show', $horse->slug()) }}">
                    <h4>{{ $horse->name() }}</h4>
                </a>
                <p>{{ trans('copy.p.born') . ' ' . eqm_date($horse->dateOfBirth(), 'Y') }}</p>
                <p>{{ trans('copy.p.life_number') . ' ' . $horse->lifeNumber() ? : '-' }}</p>
            </div>
        </div>
    </div>
    <div class="row pedigree">
        <div class="col s12">
            <div class="col s6 offspring male">
                {{ trans('copy.titles.sons') }}
                <hr/>
                @foreach ($horse->sons() as $son)
                    {{ $son->originalHorse->name() }}
                @endforeach
            </div>
            <div class="col s6 offspring female">
                {{ trans('copy.titles.daughters') }}
                <hr/>
                @foreach ($horse->daughters() as $daughter)
                    {{ $daughter->originalHorse->name() }}
                @endforeach
            </div>
        </div>
    </div>--}}
@stop
