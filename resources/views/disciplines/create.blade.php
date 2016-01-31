@extends('layout.app')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">{{ trans('copy.titles.disciplines') }}</h1>
    </div>
    <div id="page-content">
        {{ Form::open(['route' => ['disciplines.store', $horse->slug()], 'class' => 'form-inline']) }}
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Various
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::VARIOUS as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Racing
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::RACING as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Classic
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::CLASSIC as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox {{ $horse->performsDiscipline($discipline) ? 'active' : '' }}">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Western
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::WESTERN_SPORTS as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Harness
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::HARNESS as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Team Sports
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::TEAM as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Ancient
                    </h3>
                </div>
                <div class="panel-body">
                    @foreach (\EQM\Models\Disciplines\Discipline::ANCIENT as $discipline)
                        <div>
                            <div class="col-xs-3 text-left checkbox">
                                <label class="form-checkbox form-icon" for="{{ $discipline }}">
                                    {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                                    {{ trans('disciplines.' . $discipline) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 pull-right">
                    <div class="form-group text-right pull-right">
                        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-mint text-uppercase']) }}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
@stop
