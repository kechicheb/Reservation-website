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

            <div class="row">
                <div class="col ">
                    <div class="jumbotron ">
                        <h1 class="display-4" style="font-size: 3rem; font-weight: 500;  ">Consultaion</h1>


                        <form action="{{ route('admin.consultation') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">

                                <div class="col">
                                    <label for="start_end">Creneau</label>
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




                                <div class="col">
                                    <label for="exampleFormControlInput1">Date</label>
                                    <input type="date" name="date_reservation" class="form-control">
                                    <span class="text-danger">
                                        @error('date_reservation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col">
                                    <label for="exampleFormControlInput1">Rechercher une salle</label>
                                    <input type="search" name="code_salle" class="form-control">
                                    <span class="text-danger">
                                        @error('code_salle')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col">
                                    <label for="exampleFormControlInput1">Rechercher un enseignant</label>
                                    <input type="search" name="name" class="form-control">
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success">Filtre<i class="fa-solid fa-filter text-light ml-1 " style="font-size:14px;"></i></button>
                                </div>

                        </form>

                    </div>

                </div>



            </div>
        </div>




        <div class="row">


            @if ($reservations->count() > 0)
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">

                            <thead class="bg-success text-white">
                                <tr>
                                    <th scope="col">Salle</th>
                                    <th scope="col">Date </th>
                                    <th scope="col"> Creneau</th>
                                    <th scope="col"> enseignant</th>
                                    <th scope="col"> Contacter</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($reservations as $item)
                                    <tr>


                                        <td>{{ $item->code_salle }}</td>
                                        <td>{{ $item->date_reservation }}</td>
                                        @php
                                            $date = strtotime($item->creneau->start);
                                            $start = date('H:i', $date);
                                            $e = strtotime($item->creneau->end);
                                            $end = date('H:i', $e);
                                        @endphp
                                        <td>{{ $start }}-{{ $end }}</td>
                                        <td>{{ $item->enseignant->nom_prenom }} </td>
                                        <td>
                                            <span class="text-primary" style="cursor: pointer;" data-toggle="modal"
                                                data-target="#exampleModal">

                                                <i style="font-size: 25px" class="fa-solid fa-message"></i>


                                            </span>
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <table style="width:100%">
                                                                <tr>
                                                                    <th>Nom et prénom</th>
                                                                    <td>{{ $item->enseignant->nom_prenom }}</td>
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
                                        </td>




                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>


                </div>
            @else
                <div class="col-3">
                    <div class="alert alert-danger" role="alert">
                        Pas des réservations
                    </div>
                </div>
            @endif


        </div>
        <div class="d-felx justify-content-center col-12">


            {{ $reservations->appends(Request::except('page'))->links() }}



        </div>
        </div>

    </body>
    <script>
        $('select').selectpicker();
    </script>
   

    </html>
@endsection
