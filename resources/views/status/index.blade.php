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
                <div class="col-12">

                    <h3>Status </h3>


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
            <div class="perant-table">

                <div class="row first-row justify-content-between">
                    <div class="col-auto">
                        <a class="btn btn-success" href="{{ route('admin.status.create') }}"> Ajouter <i
                                class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="row">


                    @if ($status->count() > 0)
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table  table-bordered table-striped">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Status</th>

                                            <th scope="col" class="col-3"> Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($status as $item)
                                            <tr>
                                                <th scope="row">{{ $i++ }}</th>
                                                <td>{{ $item->type_status }}</td>


                                                <td>
                                                    <a style="margin-top: 2px;" href="{{ route('admin.status.edit', $item->id) }}"
                                                        class="btn btn-primary btn-sm">Modifier
                                                        <i class="fas  fa-edit" ></i>
                                                    </a>
                                                    <span style="margin-top: 2px;" class="btn btn-danger btn-sm" style="cursor: pointer;"
                                                        data-toggle="modal" data-target="#modal{{ $item->id }}">Supprimer <i
                                                            class="fas  fa-trash-alt" ></i>
                                                    </span>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Supprimer status
                                                                    </h5>

                                                                </div>
                                                                <div style="text-align: start;" class="modal-body">
                                                                    <h6>Attention</h6>
                                                                    Tous les enseignants seront supprimés avec toutes
                                                                    leurs réservations


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler</button>
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a class="btn btn-danger"
                                                                        href="{{ route('admin.status.destroy', $item->id) }}">
                                                                        Supperimer
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
                                Pas status
                            </div>
                        </div>
                    @endif


                </div>
                <div class="d-felx justify-content-center col-12">

                    {{ $status->links() }}

                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
