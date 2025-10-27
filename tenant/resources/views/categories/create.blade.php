@extends('layouts.app')

@section('content')
<h2>Tambah Kategori</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <label>Nama Kategori:</label>
    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}">
    @error('nama_kategori') <p style="color:red">{{ $message }}</p> @enderror

    <button type="submit">Simpan</button>
</form>

<a href="{{ route('categories.index') }}">Kembali</a>
@endsection
