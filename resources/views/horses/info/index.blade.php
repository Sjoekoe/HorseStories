@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.general_info') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>
                                    {{ trans('forms.labels.name') }}
                                </dt>
                                <dd>
                                    {{ $horse->name() }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.breed') }}
                                </dt>
                                <dd>
                                    {{ trans('horses.breeds.' . $horse->breed()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.gender') }}
                                </dt>
                                <dd>
                                    {{ trans('horses.genders.' . $horse->gender()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.date_of_birth') }}
                                </dt>
                                <dd>
                                    {{ eqm_date($horse->dateOfBirth()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.height') }}
                                </dt>
                                <dd>
                                    {{ config('heights.eur.' . $horse->height()) }}
                                </dd>
                                <dt>
                                    {{ trans('forms.labels.color') }}
                                </dt>
                                <dd>
                                    {{ trans('horses.colors.' . $horse->color()) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.users') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                @foreach ($horse->userTeams as $team)
                                    <?php $user = $team->user()->first() ?>
                                    <dt>
                                        {{ trans('horse_teams.type.' . $team->type()) }}
                                    </dt>
                                    <dd>
                                        <a href="{{ route('users.profiles.show', $user->slug()) }}" class="text-mint">
                                            {{ $user->fullName() }}
                                        </a>
                                        @if (auth()->check() && ($user->id() !== auth()->user()->id()))
                                            <a href="{{ route('conversation.create', ['contact' => $user->id()]) }}" class="btn btn-sm btn-mint btn-icon">
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        @endif
                                    </dd>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.disciplines') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            @foreach($horse->disciplines() as $discipline)
                                <div class="col-sm-3">
                                    {{ trans('disciplines.' . $discipline->discipline()) }}
                                </div>
                            @endforeach
                        </div>
                        @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                            <div class="panel-footer text-right">
                                <a href="{{ route('disciplines.index', $horse->slug()) }}" class="btn btn-info">{{ trans('copy.a.add_disciplines') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                {{ trans('copy.titles.companies_groups') }}
                            </h3>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                @foreach($horse->companies() as $company)
                                    <dt>{{ trans('companies.types.' . $company->type()) }}</dt>
                                    <dd>
                                        <a href="{{ route('companies.show', $company->slug()) }}" class="text-mint">
                                            {{ $company->name() }}
                                        </a>
                                    </dd>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
