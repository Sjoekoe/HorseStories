<div class="row">
    <div class="col s12 palmares">
        <div class="col s5">
            <p>Event: {{ $palmares->event->name }}</p>
            <p>Date: {{ date('d F Y', strtotime($palmares->date)) }}</p>
        </div>
        <div class="col s5">
            <p>Discipline: {{ array_flatten(trans('disciplines.list'))[$palmares->discipline - 1] }}</p>
            <p>Category: {{ $palmares->level }}</p>
        </div>
        <div class="col s2">
            <h4>{{ $palmares->ranking }} Place</h4>
            <p class="palmares-link"><a href="#">Show Story</a></p>
        </div>
    </div>
</div>