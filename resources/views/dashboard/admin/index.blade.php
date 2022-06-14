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
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="jumbotron">
                        <h1 class="display-4">All Materiel </h1>
                        <a class="btn btn-success" href="{{ route('admin.materiel.create') }}"> create Materiel</a>

                    </div>
                </div>
            </div>
            <div class="row">


                @if ($materiels->count() > 0)
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                {{-- <thead  style="background-color:#75ff95; color:#176329;"> --}}
                                <thead class="bg-success text-white">
                                    <tr>

                                        <th scope="col">N serie</th>
                                        <th scope="col"> nom</th>
                                        <th scope="col">marque</th>
                                        <th scope="col">desecription</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($materiels as $item)
                                        <tr>


                                            <td>{{ $item->n_serie }}</td>
                                            <td>{{ $item->nom }}</td>
                                            <td>{{ $item->marque }}</td>
                                            <td>{{ $item->desecription }}</td>

                                            <td>



                                                <div style="display: flex;justify-content:space-between;">
                                                    <a href="{{ route('admin.materiel.edit') }}" class="mr-3">
                                                        <i class="fas fa-2x fa-edit"></i>
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="text-danger"
                                                        href="{{ route('admin.materiel.destroy') }}"> <i
                                                            class="fas  fa-2x fa-trash-alt"></i> </a>
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
                            Not Materiel
                        </div>
                    </div>
                @endif


            </div>
            <div class="d-felx justify-content-center">

                {{ $materiels->links() }}

            </div>
        </div>

    </body>

    </html>
@endsection
