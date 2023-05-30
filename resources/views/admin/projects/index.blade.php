@extends('layouts.admin')

@section('content')
    <table class="table table-striped table-light">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Anteprima</th>
                <th scope="col">Data inizio progetto</th>
                <th scope="col">Data fine progetto</th>
                <th scope="col">Tipologia del progetto</th>
                <th scope="col">Opzioni</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>
                        @if ($project->preview_img)
                            <img class="ms-index-img" src="{{ asset('storage/' . $project->preview_img) }}"
                                alt="Anteprima progetto non disponibile">
                        @else
                            <img class="ms-index-img" src="{{ asset('img/h9pqRmsIwC1KOxfYbxgyvAFotT7SuEuNHayFtPir.png') }}"
                                alt="Anteprima progetto non disponibile">
                        @endif
                    </td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>{{ $project->type ? $project->type->name : '-' }}</td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-primary mx-1"
                                href="{{ route('admin.projects.show', $project->slug) }}">Info</a>
                            <a class="btn btn-warning mx-1"
                                href="{{ route('admin.projects.edit', $project->slug) }}">Modifica</a>
                            <form id="form{{ $project->id }}" method="POST"
                                action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="form_delete btn btn-danger mx-1">Elimina</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        Nessun progetto da visualizzare
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Attenzione!
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler eliminare definitivamente il progetto dal'elenco?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="confirmDelete btn btn-danger">Elimina</button>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Crea nuovo progetto</a>
@endsection
