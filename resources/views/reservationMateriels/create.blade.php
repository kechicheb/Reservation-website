@extends('layouts.enseignant')


@section('content')
    <div class="container">
        <div class="row mt-5 filter-rereservation">
            <div class="col ">
                <div class="jumbotron ">
                    <h1 class="display-4" style="  ">Réserver une matériel</h1>
                    <hr class="my-4">
                    <p class="lead">Vous devez saisir le créneau et la date de la salle réservée</p>

                    <form action="{{ route('enseignant.reservationM.create') }}" method="POST"
                        enctype="multipart/form-data">


                        @csrf
                        <div class="form-row align-items-center">

                            <div class="col-sm-3 my-1">

                                <select id="start_end" name="start_end[]" class="form-control selectpicker"
                                    data-live-search="true" multiple>



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
                                <br>

                            </div>




                            <div class="col-sm-3 my-1">

                                <input type="date" name="date_reservation" class="form-control">
                                <span class="text-danger">
                                    @error('date_reservation')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-auto my-1 ">
                                <button type="submit" class="btn btn-success">Filtre <i
                                        class="fa-solid fa-filter text-light ml-1 " style="font-size:14px;"></i></button>
                            </div>
                        </div>




                    </form>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">

                @if (Session::get('pasmateriels'))
                    <div class="alert alert-secondary">
                        {{ Session::get('pasmateriels') }}
                    </div>
                @endif
                @if (Session::get('vide'))
                    <div class="alert alert-danger">
                        {{ Session::get('vide') }}
                    </div>
                @endif
                @if (Session::get('fails'))
                    <div class="alert alert-danger">
                        {{ Session::get('fails') }}
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

            </div>
        </div>
        @if (count($materiels) > 0)
            <div class="perant-table">
                <div class="row">
                    <div class="col">
                        @if (count($materiels) > 0)
                            <div class="clearfix mb-2">
                                <button type="submit" onclick="document.getElementById('FormId').submit();"
                                    class="btn btn-success float-right">Réserver
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>



                <div class="row">




                    @if (count($materiels) > 0)
                        <div class="col">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    {{-- <thead  style="background-color:#75ff95; color:#176329;"> --}}
                                    <thead class="bg-success text-white">
                                        <tr>


                                            <th scope="col"> Nom</th>
                                            <th scope="col">Marque</th>
                                            <th scope="col">Description</th>
                                            <th>Choisir matériel</th>



                                        </tr>
                                    </thead>
                                    <tbody>

                                        <form action="{{ route('enseignant.reservationM.store') }}" method="POST"
                                            enctype="multipart/form-data" id="FormId">
                                            @csrf



                                            <select name="id_reservation[]" class="form-control" multiple hidden>


                                                @foreach ($id_reservation as $itemm)
                                                    <option value="{{ $itemm->id }}" selected hidden>
                                                    </option>
                                                @endforeach






                                            </select>
                                            @foreach ($materiels as $item)
                                                <tr>




                                                    <td>{{ $item->nom }}</td>
                                                    <td>{{ $item->marque }}</td>
                                                    <td>{{ $item->desecription }}</td>
                                                    <td>

                                                        <div class="form-check">

                                                            <input id="filled-in-box1"
                                                                class="form-check-input checkbox-material
                                                              invoiceOption filled-in"
                                                                name="checkbox[]" type="checkbox"
                                                                value="{{ $item->id }}">


                                                            </label>

                                                        </div>


                                                        <script type="text/javascript">
                                                            //localstorage to keep checkboxes check after refresh

                                                            (function() {

                                                                var boxes = document.querySelectorAll("input[name='checkbox[]']");

                                                                for (var i = 0; i < boxes.length; i++) {

                                                                    var box = boxes[i];

                                                                    if (box.hasAttribute("value")) {

                                                                        setupBox(box);

                                                                    }

                                                                }



                                                                function setupBox(box) {

                                                                    var storageId = box.getAttribute("value");

                                                                    var oldVal = localStorage.getItem(storageId);

                                                                    box.checked = oldVal === "true" ? true : false;



                                                                    box.addEventListener("change", function() {

                                                                        localStorage.setItem(storageId, this.checked);

                                                                    });

                                                                }

                                                            })
                                                            ();

                                                            
                                                        </script>
                                                    </td>


                                                </tr>
                                            @endforeach

                                        </form>


                                    </tbody>
                                </table>



                            </div>


                        </div>
                        <div class="d-felx justify-content-center col-12 ">




                            {{ $materiels->appends(Request::except('page'))->links() }}

                        </div>
                    @endif






                </div>
        @endif
    </div>
@endsection
