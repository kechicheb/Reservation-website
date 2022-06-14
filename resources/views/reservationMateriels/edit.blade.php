@extends('layouts.enseignant')


@section('content')
    <div class="container">

        <div class="row mt-5 mb-2">
            <div class="col-12 ">

                <h3>Modifier réservation matériel
                </h3>

            </div>
        </div>
        <div class="row mt-1">
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

        <div class="perant-table">
            <div class="row mt-1">

                @if (count($reserv_materiel) > 0)
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">

                                <thead class="bg-success text-white">
                                    <tr>

                                       
                                        <th scope="col"> Nom</th>
                                        <th scope="col">Marque</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" class="col-2">Choisir matériel</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reserv_materiel as $item)
                                        <tr>




                                            <td>{{ $item->nom }}</td>
                                            <td>{{ $item->marque }}</td>
                                            <td>{{ $item->desecription }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('enseignant.reservationM.update', $id_reservation_materiel) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <span class="text-success" style="cursor: pointer;"
                                                        data-toggle="modal" data-target="#aa{{ $item->id }}">

                                                        <i style="font-size: 25px" class="fa-solid fa-circle-plus"></i>

                                                    </span>
                                                    <div class="modal fade" id="aa{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Modifier matériel</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    Es-tu sur ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    <input type="number" value="{{ $item->id }}"
                                                                        name="id_materiel" id="" hidden>
                                                                    <button type="submit" class="btn btn-success">
                                                                        Modifier</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
                            Aucun matériel ne peut être réservé
                        </div>
                @endif



                <div class="d-felx justify-content-center">

                    {{ $reserv_materiel->appends(Request::except('page'))->links() }}

                </div>



            </div>
        </div>
    </div>
@endsection
