@extends('layout.admin')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">Dashboard</h1>
    </div>
    <div id="page-content">
        <admindash></admindash>

        <template id="admindash">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.users') }}">
                        <div class="panel media pad-all">
                            <div class="media-left">
                            <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                <i class="fa fa-user fa-2x"></i>
                            </span>
                            </div>
                            <div class="media-body">
                                <p class="text-2x mar-no text-thin">@{{ users }}</p>
                                <p class="text-muted mar-no">Registered users</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                            <i class="fa fa-comment fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">{{ $statuses }}</p>
                            <p class="text-muted mar-no">Statuses</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-pink">
                            <i class="fa fa-share-alt fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">{{ $pedigrees }}</p>
                            <p class="text-muted mar-no">Pedigree connections</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.horses.index') }}">
                        <div class="panel media pad-all">
                            <div class="media-left">
                            <span class="icon-wrap icon-wrap-sm icon-circle bg-info">
                                <i class="fa fa-photo fa-2x"></i>
                            </span>
                            </div>
                            <div class="media-body">
                                <p class="text-2x mar-no text-thin">{{ $horses }}</p>
                                <p class="text-muted mar-no">Horses</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('admin.searches.index') }}">
                        <div class="panel media pad-all">
                            <div class="media-left">
                                <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
                                    <i class="fa fa-search fa-2x"></i>
                                </span>
                            </div>
                            <div class="media-body">
                                <p class="text-2x mar-no text-thin">{{ $searchResults }}</p>
                                <p class="text-muted mar-no">Searches performed</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                            <i class="fa fa-microphone fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">{{ $conversations }}</p>
                            <p class="text-muted mar-no">Conversations</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-primary">
                            <i class="fa fa-picture-o fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">{{ $pictures }}</p>
                            <p class="text-muted mar-no">Pictures uploaded</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-dark">
                            <i class="fa fa-envelope-o fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">@{{ invites }}</p>
                            <p class="text-muted mar-no">Friends invited</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                            <i class="fa fa-commenting-o fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">@{{ comments }}</p>
                            <p class="text-muted mar-no">Comments placed</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                            <i class="fa fa-thumbs-o-up fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">@{{ likes }}</p>
                            <p class="text-muted mar-no">Likes given</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
                            <i class="fa fa-thumbs-o-down fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">{{ $unactivatedUsers }}</p>
                            <p class="text-muted mar-no">Unactivated users</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel media pad-all">
                        <div class="media-left">
                        <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                            <i class="fa fa-money fa-2x"></i>
                        </span>
                        </div>
                        <div class="media-body">
                            <p class="text-2x mar-no text-thin">{{ $advertisements }}</p>
                            <p class="text-muted mar-no">Advertisements</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </div>
    <script>
        var invites = {{ $invites }};
        var comments = {{ $comments }};
        var likes = {{ $likes }};
        var users = {{ $users }};
    </script>
@stop
