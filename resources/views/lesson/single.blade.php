@extends('layouts.app')

@section('content')
<section class="container single">
    <div class="col d-flex justify-content-center mb-4">
        <h1 class="col-12 col-md-6 single__title">{{ $lesson->name }}</h1>
    </div>

    <div class="col d-flex align-items-center flex-column single__slots">
        <div class="col-12 col-md-8 controls text-center">
            <button class="btn btn-secondary col-6 col-md-5 py-3" type="button" data-toggle="collapse" data-target="#pastSessions" aria-expanded="false" aria-controls="pastSessions">
                créneaux passées
            </button>
            <button class="btn btn-secondary col-6 col-md-5 py-3" type="button" data-toggle="collapse" data-target="#incomingSessions" aria-expanded="false" aria-controls="incomingSessions">
                créneaux à venir
            </button>
        </div>
        <div class="col-12 mt-4 single__slots__timeslots">
            <div class="collapse list-timeslots list-timeslots--past mb-4" id="pastSessions">
                <div class="card card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($past_sessions as $past_session)
                            <li class="list-group-item {{ $loop->first ?: 'mt-2' }}">
                                <span class="col-12 timeslot-date">{{ date('d/m/Y', strtotime($past_session->start_datetime)) }}</span>
                                <div class="col-12 col-md-9 mt-3 controls">
                                    <button class="btn btn-secondary col-12 col-md-6 py-2" type="button" data-toggle="collapse" data-target="#students-{{ $past_session->id }}" aria-expanded="false" aria-controls="students-{{ $past_session->id }}">
                                        voir la liste des salarié(e)s
                                    </button>
                                    <button class="btn btn-secondary col-12 col-md-5 py-2" type="button" data-toggle="collapse" data-target="#report-{{ $past_session->id }}" aria-expanded="false" aria-controls="report-{{ $past_session->id }}">
                                        ajouter un compte-rendu
                                    </button>
                                </div>
                                <div class="collapse col-12 mt-3" id="students-{{ $past_session->id }}">
                                    <div class="card card-body">
                                        <ul class="list-group list-group-flush mt-2">
                                            @foreach ($past_session->students as $student_session)
                                                <li class="list-group-item d-flex justify-content-between align-items-center {{ $loop->first ?: 'mt-2' }}">
                                                    <span>{{ $student_session->student->first_name }} {{ $student_session->student->last_name }}</span>
                                                    <form class="form-inline js-form-mark" action="{{ route('professor.handle_mark', ['lesson' => $lesson->id, 'studentSession' => $student_session->id]) }}" method="post">
                                                        @csrf

                                                        <small style="display: none;" class="pb-2 text-success notification">La note a bien été mise à jour.</small>
                                                        <div class="form-group mx-sm-3 mb-2">
                                                            <label for="mark-{{ $student_session->id }}" class="sr-only">NOTE</label>
                                                            <input type="text" class="form-control input-mark" name="mark-{{ $student_session->id }}" id="mark-{{ $student_session->id }}" placeholder="{{ is_null($student_session->student_mark) ? 'NOTE' : $student_session->student_mark . '/20' }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-secondary mb-2">ajouter une note</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="collapse col-12 mt-3" id="report-{{ $past_session->id }}">
                                    <div class="card card-body">
                                        <form class="js-form-report" action="{{ route('professor.handle_report', ['lesson' => $lesson->id, 'session' => $past_session->id]) }}" method="post">
                                            @csrf

                                            <small style="display: none;" class="pb-2 text-success notification">Le compte-rendu a bien été mis à jour.</small>
                                            <div class="form-group mb-2">
                                                <textarea class="form-control" name="session-report-{{ $past_session->id }}" id="exampleFormControlTextarea1" rows="9">{{ empty($past_session->report) ? 'Ajouter un compte-rendu...' : $past_session->report }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-secondary">valider</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="collapse list-timeslots list-timeslots--incoming" id="incomingSessions">
                <div class="card card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($incoming_sessions as $incoming_session)
                            <li class="list-group-item d-flex justify-content-between {{ $loop->first ?: 'mt-1' }}">
                                <span>Date : {{ date('d/m/Y', strtotime($incoming_session->start_datetime)) }}</span>
                                <span>Nombre d’élèves inscrits : {{ count($incoming_session->students) < 10 ? '0' . count($incoming_session->students) : count($incoming_session->students) }}/20</span>
                                <span>numéro de la salle : {{ intval($incoming_session->nb_classroom) < 100 ? '0' . $incoming_session->nb_classroom : $incoming_session->nb_classroom }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
