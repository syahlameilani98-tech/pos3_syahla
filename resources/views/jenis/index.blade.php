
@extends("layouts.app")

@section("title", "jenis")

@section("content")

@if (session("success"))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session("success") }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h1 class="mb-4">Halaman Jenis</h1>

<a href="{{ route("jenis.create") }}" class="btn btn-primary mb-3">Create</a>

<form action="{{ route("jenis.index") }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" value="{{ request("search") }}" class="form-control" placeholder="Search nama jenis">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
</form>

<table class="table align-middle">
<thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse ($jenis as $item)
    <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $item->nama }}</td>
        <td>
            <div class="d-flex gap-1 align-items-center">
                <a href="{{ route("jenis.edit", $item) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route("jenis.destroy", $item) }}" method="POST" class="d-inline">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger btn-sm" onclick="return confirm(''Apakah Anda yakin ingin menghapus jenis ini?'')">Hapus</button>
                </form>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="text-center py-4">
            <h5 class="text-muted">Data tidak tersedia.</h5>
        </td>
    </tr>
    @endforelse
</tbody>
</table>

<div class="mt-3">
    {{ $jenis->links() }}
</div>
@endsection