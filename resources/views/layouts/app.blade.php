<!DOCTYPE html>
<html>

<head>
    <title>Site de réservation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">

    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;700;900&family=Mochiy+Pop+P+One&family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    <!--Font Aweasome-->

    <script src="https://kit.fontawesome.com/787e0eb937.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top " style="z-index: 1000;">
        <div class="container-fluid">
            <div class="toggele-Site">
                <span id="sidebarCollapse" class="toggele"><i class="fa fa-bars  "
                        style="font-size: 24px;"></i></span>
                <h5>Site de réservation</h5>
            </div>
            <span class="navbar-brand " >
                <img style="height: 50px; width:50px; border-radius:25px;" src="{{ url('images/LogoNTIC.png') }}"
                    alt="LogoNTIC">
            </span>
        </div>



    </nav>

    <!-- Vertical navbar -->
    <div class="vertical-nav bg-white  " id="sidebar">


        <p class=" font-weight-bold text-uppercase px-3 small pb-4 mb-0">Gestion</p>

        <ul class="nav flex-column bg-white mb-0">
            <li class="nav-item">
                <a href="{{ route('admin.specials') }}"
                    class="{{ Route::currentRouteName() == 'admin.specials' ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-hourglass mr-3"></i>
                    @php
                        $special = 0;
                        $count = App\Models\reservation::where('attente', 'oui')->get();
                        foreach ($count as $item) {
                            $special = $special + 1;
                        }
                    @endphp

                    <div style="display: inline-flex"> <span> En attente </span>
                        @if ($special > 0)
                            <span class="count_attente">{!! $special !!}</span>
                        @endif

                    </div>
                </a>


            </li>
            <li class="nav-item">


                <a href="{{ route('admin.consultationReservation') }}"
                    class="{{ Route::currentRouteName() == 'admin.consultationReservation' ? 'nav-active' : '' }}  nav-link ">
                    {{-- <i class="fa-solid fa-house mr-3"></i> --}}
                    <i class="fa-regular fa-calendar-days mr-3"></i>
                    Consultation
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('admin.Personne_admins') }}"
                    class=" {{ str_contains(Route::currentRouteName(), 'admin.Personne_admin') ? 'nav-active' : '' }} nav-link ">


                    <i class="fa-solid fa-user-tie mr-3"></i>
                    Personnes
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.enseignants') }}"
                    class="{{ str_contains(Route::currentRouteName(), 'admin.enseignant') ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-user mr-3"></i>
                    Enseignants
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.materiels') }}"
                    class="{{ str_contains(Route::currentRouteName(), 'admin.materiel') ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-print mr-3"></i>
                    Matériel
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.salles') }}"
                    class="{{ str_contains(Route::currentRouteName(), 'admin.salle') ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-house-user mr-3"></i>
                    Salles
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.creneaus') }}"
                    class="{{ str_contains(Route::currentRouteName(), 'admin.creneau') ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-clock mr-3"></i>
                    Créneaux
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.departements') }}"
                    class="{{ str_contains(Route::currentRouteName(), 'admin.departement') ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-school mr-3"></i>
                    Départements
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.status') }}"
                    class="{{ str_contains(Route::currentRouteName(), 'admin.status') ? 'nav-active' : '' }} nav-link ">
                    <i class="fa-solid fa-graduation-cap mr-3"></i>
                    Status
                </a>
            </li>
        </ul>


        <ul class="nav flex-column bg-white mb-0  " style="margin-top: 60px">


            <li class="nav-item">



                <a class="{{ Route::currentRouteName() == 'admin.logout' ? 'nav-active' : '' }} nav-link  "
                    href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-3"></i>
                    Déconnecter
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </li>
        </ul>
    </div>
    <!-- End vertical navbar -->


    <!-- Page content holder -->
    <div class="page-content" id="content">
        <!-- Toggle button -->

        <main class="py-4">
            <div class="container-fluid " style="margin-top:50px"> @yield('content')</div>

        </main>
        <!-- Demo content -->

    </div>

    <!-- End demo content -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
        integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script src="{{ url('js/main.js') }}"></script>
</body>

</html>
