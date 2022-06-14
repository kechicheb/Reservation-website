@extends('layouts.enseignant')


@section('content')
    <div class="container">
        <div class="row mt-5 filter-rereservation">
            <div class="col">
                <div class="jumbotron"
                    style=" padding-left:10px;padding-right:10px;padding-top:30px;padding-bottom:5px">



                    <h1 class="display-4" style="  ">Modifier ma réservation</h1>

                    <p class="pr-2">

                        @php
                            $s = strtotime($reservation->creneau->start);
                            $time_s = date('H:i', $s);
                            $e = strtotime($reservation->creneau->end);
                            $time_e = date('H:i', $e);

                        @endphp
                        Salle: {!! $reservation->code_salle !!},
                        Capacité: {!! $reservation->salle->capacite !!}
                        , Creneau :
                        {!! $time_s !!} à {!! $time_e !!}
                        , date: {!! $reservation->date_reservation !!} .</p>
                    <hr class="my-4">



                    <p class="lead">Lors de la réservation, vous devez mettre le créneau et la date</p>

                    @php
                        $id_reservation_update = $fff;
                    @endphp
                    <form action="{{ route('enseignant.reservation.edit', $id_reservation_update) }}" method="POST"
                        enctype="multipart/form-data">


                        @csrf
                        <div class="form-row align-items-center">

                            <div class="col-sm-3 my-1">

                                <select id="start_end" name="start_end" class="form-control selectpicker"
                                    data-live-search="true">
                                    @foreach ($creneaus as $item)
                                        @php
                                            $s = strtotime($item->start);
                                            $start = date('H:i', $s);
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

                                <input type="date" name="date_reservation" value="{{ $date }}"
                                    class="form-control">
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
                                        class="fa-solid fa-filter text-light ml-1 " style="font-size:14px;"></i></button>
                            </div>



                        </div>








                        <div class="form-row  mt-4">
                            @if (Session::get('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                        </div>

                    </form>

                    <div class="form-row">
                        @if (count($rooms) > 0)
                            <p> Votre créneaux choisi est
                                @foreach ($start_end as $item)
                                    @php
                                        $ss = strtotime($item->start);
                                        $s_start = date('H:i', $ss);
                                        $ee = strtotime($item->end);
                                        $e_end = date('H:i', $ee);
                                    @endphp
                                    {{ $s_start }} à {{ $e_end }}
                                @endforeach
                            <p>
                            <p>, et la date est {{ $date }}</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif
                @if (Session::get('pasReservation'))
                    <div class="alert alert-secondary">
                        {{ Session::get('pasReservation') }}
                    </div>
                @endif
                @if (Session::get('pasSalle'))
                <div class="alert alert-danger">
                    {{ Session::get('pasSalle') }}
                </div>
            @endif

            </div>
        </div>
        @if (count($rooms) > 0)
            <div class="perant-table">
                <div class="row">

                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">

                                <thead class="bg-success text-white">
                                    <tr>

                                        <th scope="col">Salle</th>

                                        <th scope="col">
                                            Capacité
                                        </th>
                                        <th scope="col">Etage</th>
                                        <th scope="col" class="col-1"> Action</th>




                                    </tr>
                                </thead>
                                <tbody>



                                    @foreach ($rooms as $item)
                                        <form
                                            action="{{ route('enseignant.reservation.update', $id_reservation_update) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <tr>
                                                <td>{{ $item->code_salle }} , {{ $item->special }} </td>
                                                <td>{{ $item->capacite }}</td>
                                                <td>{{ $item->etage }}</td>

                                                <td>
                                                    <p style="display: none">{!! $item->code_salle !!}</p>

                                                    <input class="radios" type="radio"
                                                        value="{{ $item->code_salle }}" name="code_salle" id=""
                                                        data-toggle="modal"
                                                        data-target="#exampleModal{{ $item->code_salle }}">

                                                    <div class="modal fade" id="exampleModal{{ $item->code_salle }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Modifier
                                                                        réservation</h5>

                                                                </div>
                                                                <div style="text-align: start;" class="modal-body">
                                                                    <h6>Attention</h6>
                                                                    Lorsque cette réservation est mise à jour, les
                                                                    réservation matériel associées aux salle anciennes
                                                                    seront automatiquement supprimées.
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler
                                                                    </button>



                                                                    <button type="submit" class=" btn btn-success">
                                                                        Modifier
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <input type="date" name="date_reservation" value="{{ $date }}"
                                                        class="form-control" hidden>

                                                    <select name="start_end[]" class="form-control" multiple hidden>



                                                        @foreach ($start_end as $item)
                                                            <option value="{{ $item->id }}" selected>
                                                                {{ $item->start }}-{{ $item->end }}
                                                            </option>
                                                        @endforeach
                                                    </select>



                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>


                    </div>



                    <div class="d-felx justify-content-center col-12">

                        {{ $rooms->appends(Request::except('page'))->links() }}

                    </div>


                </div>
            </div>
        @endif


    </div>
@endsection
