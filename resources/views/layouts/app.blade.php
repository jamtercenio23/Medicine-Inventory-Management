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
                if ($("#wrapper").hasClass("toggled") && $("#menu-icon").hasClass("fa-chevron-left")) {
                    $("#menu-icon").removeClass("fa-chevron-left").addClass("fa-chevron-right");
                } else {
                    $("#menu-icon").removeClass("fa-chevron-right").addClass("fa-chevron-left");
                }
            });

            $("#inventory-toggle").click(function() {
                $("#inventory-categories").slideToggle(300);
                $("#manage-categories").slideUp(300);
                $("#distributions-categories").slideUp(300);
                $("#access-control-categories").slideUp(300);
                $("#barangayinventory-categories").slideUp(300);
                $("#barangaymanage-categories").slideUp(300);
                $("#barangaydistribution-categories").slideUp(300);
            });

            $("#manage-toggle").click(function() {
                $("#manage-categories").slideToggle(300);
                $("#inventory-categories").slideUp(300);
                $("#distributions-categories").slideUp(300);
                $("#access-control-categories").slideUp(300);
                $("#barangayinventory-categories").slideUp(300);
                $("#barangaymanage-categories").slideUp(300);
                $("#barangaydistribution-categories").slideUp(300);
            });

            $("#distributions-toggle").click(function() {
                $("#distributions-categories").slideToggle(300);
                $("#inventory-categories").slideUp(300);
                $("#manage-categories").slideUp(300);
                $("#access-control-categories").slideUp(300);
                $("#barangayinventory-categories").slideUp(300);
                $("#barangaymanage-categories").slideUp(300);
                $("#barangaydistribution-categories").slideUp(300);
            });

            $("#access-control-toggle").click(function() {
                $("#access-control-categories").slideToggle(300);
                $("#inventory-categories").slideUp(300);
                $("#manage-categories").slideUp(300);
                $("#distributions-categories").slideUp(300);
                $("#barangaymanage-categories").slideUp(300);
                $("#barangaydistribution-categories").slideUp(300);
                $("#barangayinventory-categories").slideUp(300);
            });

            $("#barangayinventory-toggle").click(function() {
                $("#barangayinventory-categories").slideToggle(300);
                $("#manage-categories").slideUp(300);
                $("#distributions-categories").slideUp(300);
                $("#inventory-categories").slideUp(300);
                $("#barangaymanage-categories").slideUp(300);
                $("#barangaydistribution-categories").slideUp(300);
                $("#access-control-categories").slideUp(300);
            });

            $("#barangaymanage-toggle").click(function() {
                $("#barangaymanage-categories").slideToggle(300);
                $("#manage-categories").slideUp(300);
                $("#distributions-categories").slideUp(300);
                $("#inventory-categories").slideUp(300);
                $("#barangayinventory-categories").slideUp(300);
                $("#barangaydistribution-categories").slideUp(300);
                $("#access-control-categories").slideUp(300);
            });
            $("#barangaydistribution-toggle").click(function() {
                $("#barangaydistribution-categories").slideToggle(300);
                $("#barangayinventory-categories").slideUp(300);
                $("#barangaymanage-categories").slideUp(300);
                $("#manage-categories").slideUp(300);
                $("#distributions-categories").slideUp(300);
                $("#inventory-categories").slideUp(300);
                $("#access-control-categories").slideUp(300);
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#loading-overlay").hide();
        });

        $(document).ajaxStart(function() {
            $("#loading-overlay").show();
        });

        $(document).ajaxStop(function() {
            $("#loading-overlay").hide();
        });
    </script>

    <style>
        body {
            overflow: hidden;
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

        #sidebar-wrapper .list-group-item a {
            color: black;
            transition: color 0.3s;
        }

        #sidebar-wrapper .list-group-item a:hover {
            color: #3498db;
        }

        #page-content-wrapper {
            background-color: rgba(255, 255, 255, 0.4);
            min-width: 100vw;
            height: 100vh;
            overflow: auto;
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

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Style for the footer */
        /* footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
        } */
        .sidebar-logo {
            text-align: center;
            margin: 20px 0;
        }

        .sidebar-logo img {
            max-width: 80px;
            height: auto;
            border-radius: 50%
        }
    </style>

</head>

<body>
    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>
    <div class="d-flex" id="wrapper">
        @if (Auth::check())
            <div class="bg-light border-right fixed-sidebar" id="sidebar-wrapper">
                <div class="sidebar-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Mabini Health Center Logo">
                </div>
                <div class="text-center" style="font-size: 20px; font-weight: 500;">Mabini Health Center</div>
                <br>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action bg-light">
                        <a href="{{ url('/home') }}"><i class="fas fa-tachometer-alt" style="margin-right: 31px; padding-top:5px; padding-bottom: 5px"></i> Dashboard</a>
                    </li>
                    <!-- Inventory -->
                    @can('view-admin_inventory')
                        <li class="list-group-item list-group-item-action bg-light" id="inventory-toggle">
                            <a href="javascript:void(0)"><i class="fas fa-cubes" style="margin-right: 30px; padding-top:5px; padding-bottom: 5px"></i> MHC Inventory</a>
                        </li>
                        <div id="inventory-categories" style="display: none;">
                            @can('view-categories')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('categories.index') }}"><i class="fas fa-th-large" style="margin-right: 20px;"></i>
                                        Categories</a>
                                </li>
                            @endcan
                            @can('view-medicines')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('medicines.index') }}"><i class="fas fa-pills" style="margin-right: 20px;"></i>
                                        Medicines</a>
                                </li>
                            @endcan
                            @can('view-out-of-stock')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('medicines.out-of-stock') }}"><i
                                            class="fas fa-exclamation-triangle" style="margin-right: 20px;"></i>
                                        Out of Stock</a>
                                </li>
                            @endcan
                            @can('view-expired')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('medicines.expired') }}"><i
                                            class="fas fa-calendar-times" style="margin-right: 20px;"></i> Expired
                                        Medicines</a>
                                </li>
                            @endcan
                        </div>
                    @endcan
                    <!-- Manage -->
                    @can('view-admin_manage')
                        <li class="list-group-item list-group-item-action bg-light" id="manage-toggle">
                            <a href="javascript:void(0)"><i class="fas fa-tasks" style="margin-right: 32px; padding-top:5px; padding-bottom: 5px"></i> MHC Manage</a>
                        </li>
                        <div id="manage-categories" style="display: none;">
                            @can('view-patients')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('patients.index') }}"><i class="fas fa-users" style="margin-right: 20px;"></i>
                                        Patients</a>
                                </li>
                            @endcan
                            @can('view-barangays')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('barangays.index') }}"><i class="fas fa-map-marked-alt" style="margin-right: 20px;"></i>
                                        Barangays</a>
                                </li>
                            @endcan
                            @can('view-schedules')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('schedules.index') }}"><i class="fas fa-clock" style="margin-right: 23px;"></i>
                                        Schedules</a>
                                </li>
                            @endcan
                        </div>
                    @endcan

                    <!-- Distributions -->
                    @can('view-admin_distributions')
                        <li class="list-group-item list-group-item-action bg-light" id="distributions-toggle">
                            <a href="javascript:void(0)"><i class="fas fa-truck" style="margin-right: 30px; padding-top:5px; padding-bottom: 5px"></i> MHC Distributions</a>
                        </li>
                        <div id="distributions-categories" style="display: none;">
                            @can('view-distributions')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('distributions.index') }}" style="font-size: 14.5px"><i
                                            class="fas fa-clipboard-list" style="margin-right: 23px;"></i> Patient
                                        Distributions</a>
                                </li>
                            @endcan
                            @can('view-distribution-barangay')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('distribution_barangay.index') }}" style="font-size: 14.5px"><i
                                            class="fas fa-chart-bar" style="margin-right: 20px;"></i>
                                        Barangay Distributions</a>
                                </li>
                            @endcan
                        </div>
                    @endcan
                    @can('view-bhw_inventory')
                        <li class="list-group-item list-group-item-action bg-light" id="barangayinventory-toggle">
                            <a href="javascript:void(0)"><i class="fas fa-cubes"style="margin-right: 30px; padding-top:5px; padding-bottom: 5px"></i> Barangay Inventory</a>
                        </li>
                        <div id="barangayinventory-categories" style="display: none;">
                            @can('view-barangay_medicines')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('barangay-medicines.index') }}"><i class="fas fa-pills" style="margin-right: 20px;"></i>
                                        Medicines</a>
                                </li>
                            @endcan
                        </div>
                    @endcan
                    @can('view-bhw_manage')
                        <li class="list-group-item list-group-item-action bg-light" id="barangaymanage-toggle">
                            <a href="javascript:void(0)"><i class="fas fa-tasks" style="margin-right: 30px; padding-top:5px; padding-bottom: 5px"></i> Barangay Manage</a>
                        </li>
                        <div id="barangaymanage-categories" style="display: none;">
                            @can('view-barangay_patients')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('barangay-patients.index') }}"><i class="fas fa-users" style="margin-right: 20px;"></i>
                                        Patients</a>
                                </li>
                            @endcan
                        </div>
                    @endcan
                    @can('view-bhw_distributions')
                        <li class="list-group-item list-group-item-action bg-light" id="barangaydistribution-toggle">
                            <a href="javascript:void(0)" style="font-size: 14.5px"><i class="fas fa-truck" style="margin-right: 30px; padding-top:5px; padding-bottom: 5px"></i> Barangay Distributions</a>
                        </li>
                        <div id="barangaydistribution-categories" style="display: none;">
                            @can('view-barangay_distributions')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('barangay-distributions.index') }}"><i
                                            class="fas fa-users"style="margin-right: 20px;"></i>
                                        Distributions</a>
                                </li>
                            @endcan
                        </div>
                    @endcan
                    <!-- Access Control -->
                    @can('view-access-control')
                        <li class="list-group-item list-group-item-action bg-light" id="access-control-toggle">
                            <a href="javascript:void(0)"><i class="fas fa-lock"style="margin-right: 32px; padding-top:5px; padding-bottom: 5px"></i> Access Control</a>
                        </li>
                        <div id="access-control-categories" style="display: none;">
                            @can('view-permissions')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('permissions.index') }}"><i class="fas fa-lock" style="margin-right: 25px;"></i>
                                        Permissions</a>
                                </li>
                            @endcan
                            @can('view-roles')
                                <li class="list-group-item list-group-item-action bg-light">
                                    &nbsp; &nbsp;<a href="{{ route('roles.index') }}"><i class="fas fa-user-shield" style="margin-right: 20px;"></i>
                                        Roles</a>
                                </li>
                            @endcan
                        </div>
                    @endcan

                    @can('view-users')
                        <li class="list-group-item list-group-item-action bg-light">
                            <a href="{{ route('users.index') }}"><i class="fas fa-users" style="margin-right: 25px; padding-top:5px; padding-bottom: 5px"></i> Users</a>
                        </li>
                    @endcan
                    <li class="list-group-item list-group-item-action bg-light">
                        <a href="{{ route('profile.edit') }}"><i class="fas fa-user" style="margin-right: 33px; padding-top:5px; padding-bottom: 5px"></i> Profile</a>
                    </li>
                </ul>
                <div style="padding: 10px; margin-top: 15px">
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

                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="/"><i class="fas fa-home"></i> Home <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        @if (Auth::check())
                            @can('view-admin_distributions')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('distributions.index') }}"><i
                                            class="fas fa-clipboard-list"></i> Patient Distributions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('distribution_barangay.index') }}"><i
                                            class="fas fa-chart-bar"></i> Barangay Distributions</a>
                                </li>
                            @endcan
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
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
