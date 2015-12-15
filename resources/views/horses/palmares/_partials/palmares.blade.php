<div class="row border margin padding">
    <div class="col-md-5">
        <p>{{ trans('copy.p.event') }} {{ $palmares->event()->name() }}</p>
        <p>{{ trans('copy.p.date') }} {{ date('d F Y', strtotime($palmares->date())) }}</p>
    </div>
    <div class="col-md-5">
        <p>{{ trans('copy.p.discipline') }} {{ trans('disciplines.' . $palmares->discipline()) }}</p>
        <p>{{ trans('copy.p.category') }} {{ $palmares->level() }}</p>
    </div>
    <div class="col-md-2">
        <h4>{{ $palmares->ranking() }} {{ trans('copy.p.ranked') }}</h4>
        @if (auth()->user()->isInHorseTeam($horse))
            <p><a href="{{ route('palmares.edit', $palmares->id()) }}">{{ trans('copy.a.edit') }}</a></p>
            <p><a href="{{ route('palmares.delete', $palmares->id()) }}">{{ trans('copy.a.delete') }}</a></p>
        @endif
        <p class="palmares-link"><a href="{{ route('statuses.show', $palmares->status()->id()) }}">{{ trans('copy.a.show_story') }}</a></p>
    </div>
</div>
