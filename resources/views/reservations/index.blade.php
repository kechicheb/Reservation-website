@extends('layouts.enseignant')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    </head>

    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-12 ">

                    <h3>Salles</h3>



                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if (Session::get('PasrerservationS'))
                        <div class="alert alert-danger">
                            {{ Session::get('PasrerservationS') }}
                        </div>
                    @endif

                    @if (Session::get('rerservationS'))
                        <div class="alert alert-success">
                            {{ Session::get('rerservationS') }}
                        </div>
                    @endif

                </div>
            </div>
            <div class="perant-table">
                <div class="row  ">

                    <div class="col">
                        <button class="btn btn-success"
                            onclick="document.getElementById('all-reservation').submit();">Tout</button>
                        <form id="all-reservation" action="{{ route('enseignant.reservations') }}" method="POST">
                            @csrf
                            <input hidden name="all_reservation" type="text">
                        </form>
                    </div>

                    <div class="col-12">

                        <form action="{{ route('enseignant.reservations') }}" method="POST" enctype="multipart/form-data">
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
                                                {{ $start }} To {{ $end }}</option>
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
                                    <button type="submit" class="btn btn-success">Filtre<i
                                            class="fa-solid fa-filter text-light ml-1 "
                                            style="font-size:14px;"></i></button>
                                </div>


                            </div>





                        </form>


                    </div>
                </div>
            </div>
            <div class="perant-table mt-3">


                <div class="row">


                    @if ($reservations->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    {{-- <thead  style="background-color:#75ff95; color:#176329;"> --}}
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th scope="col"><i class="fa-solid fa-house-chimney-user"></i> Salle</th>
                                            <th scope="col"><i class="fa-regular fa-clock"></i> Créneau</th>
                                            <th scope="col"><i class="fa-regular fa-calendar"></i> Date </th>

                                            <th scope="col"><i class="fa-solid fa-hourglass"></i> Attente </th>


                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reservations as $item)
                                            <tr>
                                                @php
                                                    $date = strtotime($item->creneau->start);
                                                    $start = date('H:i', $date);
                                                    $e = strtotime($item->creneau->end);
                                                    $end = date('H:i', $e);
                                                @endphp


                                                <td>{{ $item->code_salle }} , {{ $item->salle->special }} </td>
                                                <td>{{ $start }} à {{ $end }}</td>


                                                <td>{{ \Carbon\Carbon::parse($item->date_reservation)->format('m / j / Y') }}
                                                </td>
                                                <td>{{ $item->attente }}</td>


                                                <td>




                                                    <a style="margin-top: 2px;"
                                                        href="{{ route('enseignant.reservation.edit', $item->id) }}"
                                                        class="btn btn-primary btn-sm">Modifier
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <span style="margin-top: 2px;" class="btn btn-danger btn-sm"
                                                        style="cursor: pointer;" data-toggle="modal"
                                                        data-target="#modal{{ $item->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt"></i>
                                                    </span>






                                                </td>

                                                <!-- Modal -->
                                                <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Supprimer la
                                                                    réservation salle</h5>

                                                            </div>
                                                            <div class="modal-body">
                                                                <h6> Es-tu sur ?</h6>
                                                                <br>
                                                                Attention, lorsque vous supperimez une réservation salle
                                                                ,son
                                                                matériel réservé sera automatiquement supprimé

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Annuler</button>
                                                                @csrf
                                                                @method('DELETE')
                                                                <a class="btn btn-danger"
                                                                    href="{{ route('enseignant.reservation.destroy', $item->id) }}">
                                                                    Supprimer
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>


                        </div>
                    @else
                        <div class="col">
                            <div class="alert alert-danger" role="alert">
                                Il n'y pas de réservation des salles
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center col-12">

                    {{ $reservations->appends(Request::except('page'))->links() }}

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 ">

                    <h3>Matériel</h3>



                </div>
            </div>
            <div class="row ">
                <div class="col-12">
                    @if (Session::get('Pasdelete') || Session::get('delete'))
                        <div class="  mt-4">
                            @if (Session::get('Pasdelete'))
                                <div class="alert alert-danger">
                                    {{ Session::get('Pasdelete') }}
                                </div>
                            @endif
                            @if (Session::get('delete'))
                                <div class="alert alert-success">
                                    {{ Session::get('delete') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>



            <div class="perant-table">
                <div class="row">
                    @if ($materiels_reserve->count() > 0 && $reservations->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">

                                    <thead class="bg-success text-white">
                                        <tr>

                                            <th scope="col"> <i class="fa-solid fa-print "></i> Nom</th>
                                            <th scope="col"><i class="fa-solid fa-house-chimney-user"></i> Salle</th>
                                            <th scope="col"><i class="fa-regular fa-calendar"></i> Créneau </th>
                                            <th scope="col"><i class="fa-regular fa-clock"></i> Date </th>
                                            <th scope="col" class="col-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($materiels_reserve as $itemm)
                                            <tr>
                                                <td>{{ $itemm->nom }}</td>
                                                <td>{{ $itemm->code_salle }}</td>

                                                @php
                                                    $datee = strtotime($itemm->start);
                                                    $starte = date('H:i', $datee);
                                                    $ee = strtotime($itemm->end);
                                                    $ende = date('H:i', $ee);
                                                @endphp
                                                <td>{{ $starte }} à {{ $ende }}</td>
                                                <td>{{ \Carbon\Carbon::parse($itemm->date_reservation)->format('m / j / Y') }}
                                                <td>

                                                    <a style="margin-top: 2px;"
                                                        href="{{ route('enseignant.reservationM.edit', $itemm->id) }}"
                                                        class="btn btn-primary btn-sm">Modifier
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <span style="margin-top: 2px;" class="btn btn-danger btn-sm"
                                                        style="cursor: pointer;" data-toggle="modal"
                                                        data-target="#materiel{{ $itemm->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt"></i>
                                                    </span>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="materiel{{ $itemm->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Supprimer la
                                                                        réservation de matériel</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    Es-tu sur ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a class="btn btn-danger"
                                                                        href="{{ route('enseignant.reservationM.destroy', $itemm->id) }}">
                                                                        Supprimer
                                                                    </a>
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
                        <div class="col-12">
                            <div class="d-felx justify-content-center">

                                {{ $materiels_reserve->appends(Request::except('page_materiel'))->links() }}




                            </div>
                        </div>
                    @else
                        <div class="col">
                            <div class="alert alert-danger" role="alert">
                                Il n'y pas de réservation des matériels
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
