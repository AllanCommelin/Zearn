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
                <a href="{{ route('home_admin') }}"  class="btn-link text-black-50"><i class="fas fa-angle-left mr-1"></i>Retour</a>
                <p class="h6 mt-2">Édition de formation</p>
                <p class="h1">Modifier une formation</p>
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
                        <form action="{{ $lesson->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input value="{{ $lesson->name }}" type="text" class="@error('Name') is-invalid @enderror form-control" id="Name" name="Name" aria-describedby="Name" placeholder="Entrez le nom de la formation">
                                @error('Name')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Professor">Professeur Responsable</label>
                                <select class="@error('Professor') is-invalid @enderror form-control" id="Professor" name="Professor">
                                    @foreach($professors as $professor)
                                        <option @if($lesson->professor->id === $professor->id) selected @endif value="{{ $professor->id }}">{{ $professor->last_name.' '.$professor->first_name }}</option>
                                    @endforeach
                                </select>
                                @error('Professor')
                                <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </form>
                    </div>
                </div>

                <p class="h3 mt-5">Créneaux</p>
                    <button type="button" class="btn btn-success mb-5" data-toggle="modal" data-target="#exampleModal">
                        Ajouter un créneau
                    </button>
                    <table class="table table-hover mt-2">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Horaires</th>
                            <th scope="col">Nb participants</th>
                            <th scope="col">Salle</th>
                            <th scope="col">Compte-rendu</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td>{{ DateTime::createFromFormat('Y-m-d H:i:s',$session->start_datetime)->format('d-m-Y') }}</td>
                                <td>{{ DateTime::createFromFormat('Y-m-d H:i:s',$session->start_datetime)->format('H:i:s').'-'.DateTime::createFromFormat('Y-m-d H:i:s',$session->end_datetime)->format('H:i:s') }}</td>
                                <td>{{ count($session->students) }}</td>
                                <td>{{ $session->nb_classroom }}</td>
                                <td>
                                    @if($session->completed)
                                        <button
                                                type="button"
                                                class="btn btn-sm btn-info"
                                                data-toggle="popover"
                                                data-content="{{ $session->report }}">
                                            Lire
                                        </button>
                                    @else
                                        Non finis
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $sessions->links() }}
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Création d'un créneau</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('create_session') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="text" hidden name="lesson_id" value="{{ $lesson->id }}">
                                        <div class="form-group">
                                            <label for="start_datetime">Date Début</label>
                                            <input
                                                    type="datetime-local"
                                                    class="@error('start_datetime') is-invalid @enderror form-control"
                                                    id="start_datetime"
                                                    name="start_datetime"
                                                    aria-describedby="Date Début"
                                                    placeholder="Date de début"
                                            >
                                            @error('start_datetime')
                                            <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="end_datetime">Date de fin</label>
                                            <input type="datetime-local" class="@error('end_datetime') is-invalid @enderror form-control" id="end_datetime" name="end_datetime" aria-describedby="Date de fin" placeholder="Date de fin">
                                            @error('end_datetime')
                                            <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="nb_classroom">Numéro de la salle</label>
                                            <input type="text" class="@error('NbClassroom') is-invalid @enderror form-control" id="nb_classroom" name="nb_classroom" aria-describedby="Numéro de salle" placeholder="Numéro de la salle">
                                            @error('nb_classroom')
                                            <div class="mt-1 alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success">Sauvegarder</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('[data-toggle="popover"]').popover({
                                html: true,
                                trigger: 'focus'
                            });
                        });


                    </script>
            </div>
        </div>
    </div>
@endsection
