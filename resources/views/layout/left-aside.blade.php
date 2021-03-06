<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EquiMundo</title>

    <link href="/css/app.css" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @if (App::environment('production'))
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-65362816-1', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
</head>
<body>
<div id="container" class="effect mainnav-out aside-in aside-left aside-bright">
    @include('layout.partials.nav')
    <div class="boxed">
        <div id="content-container">
            @yield('content')
        </div>
    </div>
</div>

@if (auth()->check())
    <script>
        var user_id = {{ auth()->user()->id() }}
    </script>
@endif
<script>
    var algolia_id = '{{ env('ALGOLIA_APP_ID') }}';
    var algolia_app_id = '{{ env('ALGOLIA_ADMIN_API_KEY') }}';
    var pusher = '{{ env('PUSHER_KEY') }}';
</script>

<!-- Scripts -->
@include('layout.partials._info')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
<script src="/js/all.js"></script>
<script src="/js/app.js"></script>
@if (auth()->check() && App::environment('production'))
    <script>
        window.intercomSettings = {
            app_id: "cl2pnkcf",
            name: "{{ auth()->user()->fullName() }}", // Full name
            email: "{{ auth()->user()->email() }}", // Email address
            created_at: "{{ auth()->user()->created_at }}" // Signup date as a Unix timestamp
        };
    </script>
    <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/cl2pnkcf';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
@endif
@yield('footer')
</body>
</html>
