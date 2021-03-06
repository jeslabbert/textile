<!-- Left Side Of Navbar -->

<!--
<li class="nav-item">
    <a class="nav-link" href="#">Your Link</a>
</li>
-->
@yield('navextra')
<li class="sparknavli" style="min-width: 50px;">
    <a class="navbar-brand" href="/home" style="margin-right:0px;">
        <img src="/{{env('BRAND')}}/logo.png" height="32">
    </a>
</li>

<li class="sparknavli">
    <a class="nav-link" href="/sites">Sites</a>
</li>
<li class="sparknavli" style="display: contents;">
    <a @click="showNotifications" class="notification-pill mx-auto mb-3 mb-md-0 mr-md-0 ml-md-auto" style="margin-bottom: 0px !important;">
        <svg class="mr-2" width="18px" height="20px" viewBox="0 0 18 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <linearGradient x1="50%" y1="100%" x2="50%" y2="0%" id="linearGradient-1">
                    <stop stop-color="#86A0A6" offset="0%"></stop>
                    <stop stop-color="#596A79" offset="100%"></stop>
                </linearGradient>
            </defs>
            <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="header" transform="translate(-926.000000, -29.000000)" fill-rule="nonzero" fill="url(#linearGradient-1)">
                    <g id="Group-3">
                        <path d="M929,37 C929,34.3773361 930.682712,32.1476907 933.027397,31.3318031 C933.009377,31.2238826 933,31.1130364 933,31 C933,29.8954305 933.895431,29 935,29 C936.104569,29 937,29.8954305 937,31 C937,31.1130364 936.990623,31.2238826 936.972603,31.3318031 C939.317288,32.1476907 941,34.3773361 941,37 L941,43 L944,45 L944,46 L926,46 L926,45 L929,43 L929,37 Z M937,47 C937,48.1045695 936.104569,49 935,49 C933.895431,49 933,48.1045695 933,47 L937,47 L937,47 Z"
                              id="Combined-Shape"></path>
                    </g>
                </g>
            </g>
        </svg>
        @{{notificationsCount}}
    </a>
</li>
<li class="sparknavli">
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a href="#" class="d-block d-md-flex text-center nav-link dropdown-toggle" id="dropdownMenuButton" style="padding-top: 1px; padding-bottom: 1px;" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <img :src="user.photo_url" class="dropdown-toggle-image spark-nav-profile-photo">
                <span class="d-none d-md-block">@{{ user.name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">


                <a class="dropdown-item" href="/settings#/profile">
                    <i class="fa fa-fw text-left fa-btn fa-user-secret"></i> {{__('Profile')}}
                </a>
                <!-- Impersonation -->
                @if (session('spark:impersonator'))
                    <h6 class="dropdown-header">{{__('Impersonation')}}</h6>

                    <!-- Stop Impersonating -->
                    <a class="dropdown-item" href="/spark/kiosk/users/stop-impersonating">
                        <i class="fa fa-fw text-left fa-btn fa-user-secret"></i> {{__('Back To My Account')}}
                    </a>

                    <div class="dropdown-divider"></div>
            @endif

            <!-- Developer -->
            @if (Spark::developer(Auth::user()->email))
                @include('spark::nav.developer')
            @endif

            <!-- Subscription Reminders -->
            @include('spark::nav.subscriptions')

            {{--<!-- Settings -->--}}
            {{--<h6 class="dropdown-header">{{__('Settings')}}</h6>--}}

            {{--<!-- Your Settings -->--}}
            {{--<a class="dropdown-item" href="/settings">--}}
            {{--<i class="fa fa-fw text-left fa-btn fa-cog"></i> {{__('Your Settings')}}--}}
            {{--</a>--}}

            {{--<div class="dropdown-divider"></div>--}}

            {{--@if (Spark::usesTeams() && (Spark::createsAdditionalTeams() || Spark::showsTeamSwitcher()))--}}
            {{--<!-- Team Settings -->--}}
            {{--@include('spark::nav.teams')--}}
            {{--@endif--}}

            @if (Spark::hasSupportAddress())
                <!-- Support -->
                @include('spark::nav.support')
            @endif

            <!-- Logout -->
                <a class="dropdown-item" href="/logout">
                    <i class="fa fa-fw text-left fa-btn fa-sign-out"></i> {{__('Logout')}}
                </a>
            </div>
        </li>

    </ul>

</li>
{{--<li class="nav-link">--}}
    {{--<a href="/about">About</a>--}}
{{--</li>--}}