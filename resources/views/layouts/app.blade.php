<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Medicine Inventory')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
                if ($("#wrapper").hasClass("toggled")) {
                    $("#menu-icon").removeClass("fa-chevron-left").addClass("fa-chevron-right");
                } else {
                    $("#menu-icon").removeClass("fa-chevron-right").addClass("fa-chevron-left");
                }
            });
        });
    </script>
    <style>
        body {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        @if (Auth::check())
            <div class="bg-light border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">Mabini Health Center</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action bg-light">
                        <a href="{{ url('/home') }}"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    @can('view-categories')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('categories.index') }}"><i class="fas fa-th-large"></i> Categories</a>
                        </li>
                    @endcan
                    @can('view-medicines')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('medicines.index') }}"><i class="fas fa-pills"></i> Medicines</a>
                        </li>
                    @endcan
                    @can('view-out-of-stock')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('medicines.out-of-stock') }}"><i class="fas fa-exclamation-triangle"></i> Out
                                of Stock Medicines</a>
                        </li>
                    @endcan
                    @can('view-expired')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('medicines.expired') }}"><i class="fas fa-calendar-times"></i> Expired
                                Medicines</a>
                        </li>
                    @endcan
                    @can('view-patients')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('patients.index') }}"><i class="fas fa-users"></i> Patients</a>
                        </li>
                    @endcan
                    @can('view-barangays')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('barangays.index') }}"><i class="fas fa-map-marked-alt"></i> Barangays</a>
                        </li>
                    @endcan
                    @can('view-schedules')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('schedules.index') }}"><i class="fas fa-clock"></i> Schedules</a>
                        </li>
                    @endcan
                    @can('view-distributions')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('distributions.index') }}"><i class="fas fa-clipboard-list"></i> Patient
                                Distributions</a>
                        </li>
                    @endcan
                    @can('view-distribution-barangay')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('distribution-barangay.index') }}"><i class="fas fa-chart-bar"></i> Barangay
                                Distributions</a>
                        </li>
                    @endcan

                    @can('view-permissions')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('permissions.index') }}"><i class="fas fa-lock"></i> Permissions</a>
                        </li>
                    @endcan

                    @can('view-roles')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('roles.index') }}"><i class="fas fa-user-shield"></i> Roles</a>
                        </li>
                    @endcan

                    @can('view-users')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('users.index') }}"><i class="fas fa-users"></i> Users</a>
                        </li>
                    @endcan

                </ul>
                <div style="padding: 10px; margin-top: 50px">
                    <a href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal"
                        class="btn btn-danger btn-block text-white">Logout</a>
                </div>
            </div>
        @endif
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                @if (Auth::check())
                    <button class="btn btn-primary" id="menu-toggle">
                        <i id="menu-icon" class="fas fa-chevron-left"></i>
                    </button>
                @endif

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        @if (Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if (Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        Dropdown
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal"
                                        data-target="#logoutModal">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif

                    </ul>
                </div>
            </nav>

            <div class="w3-container">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>

    </div>
    @include('auth.logout-modal')
</body>

</html>
