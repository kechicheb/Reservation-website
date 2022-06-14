@extends('layouts.app')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    </head>

    <body>
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 ">

                    <h3>Réservations particulière</h3>

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
                </div>
            </div>

            <div class="row">
                <div class="col">
                    @if (Session::get('accepte'))
                        <div class="alert alert-success">
                            {{ Session::get('accepte') }}
                        </div>
                    @endif
                    @if (Session::get('pas_accepte'))
                        <div class="alert alert-danger">
                            {{ Session::get('pas_accepte') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="perant-table">
               <div class="row">
                <div class="col">
                    <button class="btn btn-success"
                        onclick="document.getElementById('all-reservation').submit();">Tout</button>
                    <form id="all-reservation" action="{{ route('admin.specials') }}" method="POST">
                        @csrf
                        <input hidden name="all_reservation" type="text">
                    </form>
                </div>
                <div class="col-12">
                    <form action="{{ route('admin.specials') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row align-items-center" style="margin-bottom:5px;">
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

                                <input type="search" name="name" class="form-control"
                                    placeholder="Recherecher enseignant">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-auto my-1">
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
                                    {{-- <thead  style="background-color:#75ff95; color:#176329;"> --}}
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th scope="col"><i class="fa-solid fa-house-chimney-user"></i> Salle</th>
                                            <th scope="col"><i class="fa-regular fa-calendar"></i> Date </th>
                                            <th scope="col"><i class="fa-regular fa-clock"></i> Créneau</th>
                                            <th scope="col"><i class="fa-regular fa-user"></i> Enseignant</th>

                                            <th scope="col"> Actions</th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reservations as $item)
                                            <tr>


                                                <td>{{ $item->code_salle }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->date_reservation)->format('m / j / Y') }}
                                                    @php
                                                        $date = strtotime($item->creneau->start);
                                                        $start = date('H:i', $date);
                                                        $e = strtotime($item->creneau->end);
                                                        $end = date('H:i', $e);
                                                    @endphp
                                                <td>{{ $start }}-{{ $end }}</td>
                                                <td>{{ $item->enseignant->nom_prenom }} </td>
                                                <td>



                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#accepte{{ $item->id }}">Accepter <i
                                                            class="fa-solid fa-check"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade table-copy-email"
                                                        id="accepte{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Accepter
                                                                        réservation</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    Es-tu sur ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    @csrf

                                                                    <a class="btn btn-success"
                                                                        href="{{ route('admin.special.accepte', $item->id) }}">
                                                                        Accepte
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                                        data-target="#contact{{ $item->id }}">
                                                        Contacter
                                                        <i class="fa-solid fa-message"></i>


                                                    </button>
                                                    <div class="modal fade" id="contact{{ $item->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Contacter
                                                                        Enseignant
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table style="width:100%">
                                                                        <tr>
                                                                            <th>Nom et prénom</th>
                                                                            <td class="button-contacter">
                                                                                <span> {!! $item->enseignant->email !!}</span><span
                                                                                    class="btn btn-outline-success btn-sm"
                                                                                    title="Copié"
                                                                                    onclick="copyToClipboard({{ $item->id }})">Copie</span>
                                                                                <input hidden type="text"
                                                                                    value="{{ $item->enseignant->email }}"
                                                                                    id="{{ $item->id }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Email</th>
                                                                            <td>{{ $item->enseignant->email }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Téléphone</th>
                                                                            <td>{{ $item->enseignant->telephone }}</td>
                                                                        </tr>
                                                                    </table>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-danger btn-sm" style="cursor: pointer; "
                                                        data-toggle="modal"
                                                        data-target="#modal{{ $item->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt"></i>
                                                    </button>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Supprimer
                                                                        réservation</h5>

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
                                                                        href="{{ route('admin.reservation.destroy', $item->id) }}">
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
                    @else
                        <div class="col">
                            <div class="alert alert-danger" role="alert">
                                Pas réservations particulière
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center">


                    {{ $reservations->appends(Request::except('page'))->links() }}



                </div>
            </div>

        </div>

    </body>
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


    </html>
@endsection
