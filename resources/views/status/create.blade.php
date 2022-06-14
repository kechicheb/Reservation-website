@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 ">

                <h3>Ajouter status</h3>






            </div>



        </div>
        <a style="margin-left: -14px;" class="mb-1 btn btn-success" href="{{ route('admin.status') }}">
            <i class="fa-solid fa-reply-all"></i> Retour</a>

        <div class="row " style="background-color: #fff;">
            {{-- <div class="col-12 mt-3 mb-2">

                <h4> Ajouter status</h4>
                <hr>
            </div> --}}
            <div class="col mt-3 mb-2">
                <form action="{{ route('admin.status.store') }}" method="POST" enctype="multipart/form-data">
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
                    @csrf


                    <div class="form-group">
                        <label for="exampleFormControlInput1">Status </label>
                        <input type="text" name="type_status" class="form-control">
                        <span class="text-danger">
                            @error('type_status')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="form-group">

                        <button class="btn btn-success" type="submit">Sauvegarder</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
