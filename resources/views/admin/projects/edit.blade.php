@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('admin.projects.update', ['project' => $project->slug]) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titolo del progetto:</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title', $project->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="preview_img" class="form-label">Immagine di anteprima:</label>
            @if ($project->preview_img)
                <div class="ms-wrap-preview">
                    <img class="ms-edit-img" src="{{ asset('storage/' . $project->preview_img) }}"
                        alt="{{ $project->title }}">
                    <div id="btn-preview-delete" class="ms-preview-delete btn btn-danger">
                        <i class="fa-regular fa-trash-can"></i>
                    </div>
                </div>
            @endif
            <input type="file" class="form-control @error('preview_img') is-invalid @enderror " id="preview_img"
                name="preview_img">
            @error('preview_img')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type_id" class="form-label">Tipologia del progetto:</label>
            <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id">
                <option @selected(old('type_id', $project->type_id) == '') value="">Nessuna tipologia</option>
                @foreach ($types as $type)
                    <option @selected(old('type_id', $project->type_id) == $type->id) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <p>Tecnologie associate:</p>
            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                @forelse ($technologies as $technology)
                    @if ($errors->any())
                        <input type="checkbox" class="btn-check" id="technology_{{ $technology->id }}" name="technologies[]"
                            value="{{ $technology->id }}" @if (in_array($technology->id, old('technologies', []))) checked @endif>
                    @else
                        <input type="checkbox" class="btn-check" id="technology_{{ $technology->id }}"
                            name="technologies[]" value="{{ $technology->id }}"
                            @if ($project->technologies->contains($technology->id)) checked @endif>
                    @endif
                    <label class="btn btn-outline-primary"
                        for="technology_{{ $technology->id }}">{{ $technology->name }}</label>
                @empty
                    <span class="text-warning">Ancora nessuna tecnologia associabile presente nel database, è possibile
                        crearne una nell'apposita sezione.</span>
                @endforelse
                @error('technologies')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Data di inizio progetto:</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                name="start_date" value="{{ old('start_date', $project->start_date) }}">
            @error('start_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Data di fine progetto (opzionale):</label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                name="end_date" value="{{ old('end_date', $project->end_date) }}">
            @error('end_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrizione progetto (opzionale):</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salva</button>
    </form>

    <form id="form-preview-delete" action="{{ route('admin.delete-preview', ['project' => $project->id]) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection
