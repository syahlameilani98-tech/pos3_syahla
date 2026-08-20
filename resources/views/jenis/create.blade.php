
@extends("layouts.app")

@section("title", "jenis")

@section("content")

<h1 class="mb-4">Tambah Jenis</h1>

<form action="{{ route("jenis.store") }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Jenis</label>
        <input type="text" name="nama" id="nama" class="form-control @error("nama") is-invalid @enderror" value="{{ old("nama") }}">
        @error("nama")
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route("jenis.index") }}" class="btn btn-secondary">Batal</a>
</form>
@endsection