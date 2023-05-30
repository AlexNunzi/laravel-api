@extends('layouts.admin')

@section('content')
    <table class="table table-striped table-light">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Quantità di progetti associati</th>
                <th scope="col">Opzioni</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($types as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ count($type->project) }}</td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-primary mx-1" href="{{ route('admin.types.show', $type->slug) }}">Info</a>
                            <a class="btn btn-warning mx-1" href="{{ route('admin.types.edit', $type->slug) }}">Modifica</a>
                            <form id="form{{ $type->id }}" method="POST"
                                action="{{ route('admin.types.destroy', ['type' => $type->slug]) }}">
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
                        Nessuna tipologia da visualizzare
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
                    Sei sicuro di voler eliminare definitivamente questa tipologia dall'elenco?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="confirmDelete btn btn-danger">Elimina</button>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.types.create') }}" class="btn btn-primary">Crea nuova tipologia</a>
@endsection
