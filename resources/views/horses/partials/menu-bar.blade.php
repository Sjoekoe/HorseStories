<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills nav-justified">
            <li class="active">
                <a href="{{ route('horses.show', $horse->slug()) }}" class="teal-text {{ Active::route('horses.show') }}">
                    {{ trans('copy.a.statuses') }}
                </a>
            </li>
            <li>
                <a href="{{ route('horse.info', $horse->slug()) }}" class="teal-text {{ Active::route('horse.info') }}">
                    {{ trans('copy.a.info') }}
                </a>
            </li>
            <li>
                <a href="{{ route('follows.index', $horse->slug()) }}" class="teal-text {{ Active::route('follows.index') }}">
                    {{ trans('copy.a.followers') . ' ' }} <span class="badge badge-info">{{ count($horse->followers()) }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('horses.pictures.index', $horse->slug()) }}" class="teal-text {{ Active::route('horses.pictures.index') }}">
                    {{ trans('copy.a.pictures') }}
                </a>
            </li>
            <li>
                <a href="{{ route('pedigree.index', $horse->slug()) }}" class="teal-text {{ Active::route('pedigree.index') }}">
                    {{ trans('copy.a.pedigree') }}
                </a>
            </li>
            <li>
                <a href="{{ route('palmares.index', $horse->slug()) }}" class="teal-text {{ Active::route('palmares.index') }}">
                    {{ trans('copy.a.palmares') }}
                </a>
            </li>
        </ul>
    </div>
</div>
