@extends('layouts.enseignant')

@section('content')




    <div class="container">
        <div class="row mt-5 consultaion ">

            <div class="col-12 ">

                <h3>Consultaion</h3>






            </div>
        </div>




    </div>

    <div class="container">



        <div class="perant-table">
            <div class="row first-row">
                <div class="col ">
                    <button class="btn btn-success"
                        onclick="document.getElementById('all-reservation').submit();">Tout</button>
                    <form id="all-reservation" action="{{ route('enseignant.consultationReservation') }}" method="POST">
                        @csrf
                        <input hidden name="all_reservation" type="text">
                    </form>
                </div>
                <div class="col-12">

                    <form action="{{ route('enseignant.consultationReservation') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-row align-items-center">

                            <div class="col-sm-3 my-1">

                                <select id="start_end" name="start_end[]" class="form-control selectpicker"
                                    data-live-search="true" multiple>


                                    @foreach ($creneaus as $item)
                                        @php
                                            $date = strtotime($item->start);
                                            $start = date('H:i', $date);
                                            $e = strtotime($item->end);
                                            $end = date('H:i', $e);
                                        @endphp
                                        <option value="{{ $item->id }}">
                                            {{ $start }} à {{ $end }}</option>
                                    @endforeach


                                </select>
                                <span class="text-danger">
                                    @error('start_end')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-auto my-1">

                                <input type="date" name="date_reservation" class="form-control">
                                <span class="text-danger">
                                    @error('date_reservation')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-auto my-1">

                                <input type="search" name="code_salle" class="form-control"
                                    placeholder="Rechercher une salle">
                                <span class="text-danger">
                                    @error('code_salle')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-auto my-1">

                                <input type="search" name="name" class="form-control" placeholder="Rechercher enseignant">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-auto my-1 ">

                                <button type="submit" class="btn btn-success ">Filtre<i
                                        class="fa-solid fa-filter text-light ml-1 " style="font-size:14px;"></i></button>



                            </div>
                        </div>


                    </form>

                </div>
            </div>
            <div class="row">


                @if ($reservations->count() > 0)
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">

                                <thead class="bg-success text-white">
                                    <tr>
                                        <th scope="col"><i class="fa-solid fa-house-chimney-user"></i> Salle</th>
                                        <th scope="col"><i class="fa-regular fa-clock"></i> Créneau</th>
                                        <th scope="col"><i class="fa-regular fa-calendar"></i> Date </th>
                                        <th scope="col"><i class="fa-regular fa-user"></i> Enseignant</th>
                                        <th scope="col"> Contacter</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($reservations as $item)
                                        <tr>

                                            <td>{{ $item->code_salle }} , {{ $item->salle->special }}

                                                @php
                                                    $date = strtotime($item->creneau->start);
                                                    $start = date('H:i', $date);
                                                    $e = strtotime($item->creneau->end);
                                                    $end = date('H:i', $e);
                                                @endphp
                                            <td>{{ $start }} à {{ $end }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date_reservation)->format('m / j / Y') }}
                                            </td>

                                            <td>{{ $item->enseignant->nom_prenom }} </td>
                                            <td>



                                                <span class="btn btn-primary btn-sm" style="cursor: pointer;"
                                                    data-toggle="modal" data-target="#examp{{ $item->id }}">Contacter

                                                    <i class="fa-solid fa-message"></i>


                                                </span>

                                                <div class="modal fade table-copy-email" id="examp{{ $item->id }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Contacter un
                                                                    enseignant
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table style="width:100%; text-align:start;">

                                                                    <tr style="text-align:start;">
                                                                        <th>Nom et prénom</th>
                                                                        <td>{{ $item->enseignant->nom_prenom }}</td>
                                                                    </tr>
                                                                    <tr style="text-align:start;">
                                                                        <th>Email</th>
                                                                        <td class="button-contacter">
                                                                            <span>{!! $item->enseignant->email !!}</span><span
                                                                                class="btn btn-outline-success btn-sm"
                                                                                title="Copié"
                                                                                onclick="copyToClipboard({{ $item->id }})">Copie</span>
                                                                            <input hidden type="text"
                                                                                value="{{ $item->enseignant->email }}"
                                                                                id="{{ $item->id }}">
                                                                        </td>

                                                                        <input hidden type="text"
                                                                            value="{{ $item->enseignant->email }}"
                                                                            id="myInput">
                                                                    </tr>
                                                                    <tr style="text-align:start !important;">
                                                                        <th>Téléphone</th>
                                                                        <td>{{ $item->enseignant->telephone }}</td>
                                                                    </tr>
                                                                </table>


                                                                <script>
                                                                    function myFunction() {
                                                                        /* Get the text field */
                                                                        var input = document.getElementById("myInput");

                                                                        /* Select the text field */
                                                                        input.select();
                                                                        input.setSelectionRange(0, 99999); /* For mobile devices */

                                                                        /* Copy the text inside the text field */
                                                                        navigator.clipboard.writeText(input.value);

                                                                        /* Alert the copied text */
                                                                        alert("L'e-mail a été copie: " + input.value);
                                                                    }
                                                                </script>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>




                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>


                    </div>



            </div>
            <div class="col-12">
                <div class="d-felx justify-content-center">


                    {{ $reservations->appends(Request::except('page'))->links() }}


                </div>
            </div>
        @else
            <div class="col-12">

                <div class="alert alert-danger" role="alert">
                    Pas des réservations
                </div>

            </div>
            @endif
        </div>


    </div>









    <script>
        $('select').selectpicker();
    </script>
    <script>
        function copyToClipboard(id) {
            /* Get the text field */
            var copyText = document.getElementById(id);

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            /* Alert the copied text */
            alert("L'e-mail a été copie: " + copyText.value);
        }
    </script>



@endsection
