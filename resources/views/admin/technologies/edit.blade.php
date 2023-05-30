@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('admin.technologies.update', ['technology' => $technology->slug]) }}">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome della tecnologia:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $technology->name) }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salva</button>
    </form>
@endsection
