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
            <p class="h6">Dashboard Administrateur</p>
            <p class="h1">Bienvenue {{ Auth::user()->first_name }}</p>
            @if (session('successMsg'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('successMsg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif



            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#users" role="tab" aria-controls="home" aria-selected="true">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#formations" role="tab" aria-controls="profile" aria-selected="false">Formations</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="home-tab">
                    {{--USER TABLE--}}
                    <a href="{{ route('create_user') }}" class="text-white btn btn-primary mt-5">Créer un utilisateur</a>
                    <table class="table table-hover mt-5">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Rôle</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name }}&nbsp;{{ $user->last_name }}</td>
                                <td>
                                    @switch($user->role)
                                        @case('admin')
                                        Admin
                                        @break

                                        @case('student')
                                        Étudiant
                                        @break

                                        @case('professor')
                                        Professeur
                                    @endswitch
                                </td>
                                <td>
                                    <a href="edit/user/{{$user->id}}" role="button" class="text-white btn btn-primary">Modifier</a>
                                    <form method="POST" action="edit/user/{{ $user->id }}" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <input type="submit" class="btn btn-danger" value="Supprimer">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                </div>
                <div class="tab-pane fade" id="formations" role="tabpanel" aria-labelledby="profile-tab">
                    {{--LESSON TABLE--}}
                    <a href="{{ route('create_lesson') }}" class="text-white btn btn-primary mt-5">Créer une formation</a>
                    <table class="table table-hover mt-5">
                        <thead>
                        <tr>
                            <th scope="col">Nom de la formation</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lessons as $lesson)
                            <tr>
                                <td>{{ $lesson->name }}</td>
                                <td>
                                    <a href="edit/lesson/{{ $lesson->id }}" role="button" class="text-white btn btn-primary">Modifier</a>
                                    <form method="POST" action="{{ route('delete_lesson', ['lesson' => $lesson]) }}" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <input type="submit" class="btn btn-danger" value="Supprimer">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $lessons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
