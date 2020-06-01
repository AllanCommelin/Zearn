@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="h6">Utilisateur</p>
                <p class="h1">Créer un utilisateur</p>
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="{{ route('store_user') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="first_name">Prénom</label>
                                <input value="{{ old('first_name') }}" type="text" class="@error('first_name') is-invalid @enderror form-control" id="first_name" name="first_name" aria-describedby="Prénom" placeholder="Entrez un prénom">
                                @error('first_name')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">Nom</label>
                                <input value="{{ old('last_name') }}" type="text" class="@error('last_name') is-invalid @enderror form-control" id="last_name" name="last_name" aria-describedby="Nom de famille" placeholder="Entrez un nom de famille">
                                @error('last_name')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Adresse mail</label>
                                <input value="{{ old('email') }}" type="email" class="@error('email') is-invalid @enderror form-control" id="email" name="email" aria-describedby="Adresse mail" placeholder="Entrez une adresse mail">
                                @error('email')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">Example select</label>
                                <select class="@error('role') is-invalid @enderror form-control" id="role" name="role">
                                    <option @if(old('role') === 'admin') selected @endif value="admin">Admin</option>
                                    <option @if(old('role') === 'student') selected @endif value="student">Étudiant</option>
                                    <option @if(old('role') === 'professor') selected @endif value="professor">Professeur</option>
                                </select>
                                @error('role')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
