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
                <p class="h6">Édition d'utilisateur</p>
                <p class="h1">Modifier un utilisateur</p>
                    @if (session('successMsg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('successMsg') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="user/{{ $user->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="FirstName">Prénom</label>
                                <input value="{{ $user->first_name }}" type="text" class="@error('FirstName') is-invalid @enderror form-control" id="FirstName" name="FirstName" aria-describedby="FirstName" placeholder="Entrez un prénom">
                                @error('FirstName')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="LastName">Nom</label>
                                <input value="{{ $user->last_name }}" type="text" class="@error('LastName') is-invalid @enderror form-control" id="LastName" name="LastName" aria-describedby="InputLastName" placeholder="Entrez un nom">
                                @error('LastName')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Email">Adresse mail</label>
                                <input value="{{ $user->email }}" type="email" class="@error('Email') is-invalid @enderror form-control" id="Email" name="Email" aria-describedby="emailHelp" placeholder="Entrez une adresse mail">
                                @error('Email')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Role">Example select</label>
                                <select class="@error('Role') is-invalid @enderror form-control" id="Role" name="Role">
                                    <option @if($user->role === 'admin') selected @endif value="admin">Admin</option>
                                    <option @if($user->role === 'student') selected @endif value="student">Étudiant</option>
                                    <option @if($user->role === 'professor') selected @endif value="professor">Professeur</option>
                                </select>
                                @error('Role')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <form method="POST" action="user/{{ $user->id }}">
                                @method('delete')
                                @csrf
                                <input type="submit" class="btn btn-danger" value="Supprimer">
                            </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
