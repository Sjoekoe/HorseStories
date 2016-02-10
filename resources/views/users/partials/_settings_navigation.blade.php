<div class="panel">
    <div class="banel-body">
        <div class="list-group">
            <a href="{{ route('settings.index') }}" class="list-group-item {{ Active::route('settings.index') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    Account
                </h5>
            </a>
            <a href="{{ route('password.edit') }}" class="list-group-item {{ Active::route('password.edit') }}">
                <h5>
                    <i class="fa fa-chevron-right pull-right"></i>
                    {{ trans('copy.a.change_password') }}
                </h5>
            </a>
        </div>
    </div>
</div>
