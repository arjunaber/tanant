@extends('layouts.app')

@section('content')
<h2>Edit Kategori</h2>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nama Kategori:</label>
    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}">
    @error('nama_kategori') <p style="color:red">{{ $message }}</p> @enderror

    <button type="submit">Perbarui</button>
</form>

<a href="{{ route('categories.index') }}">Kembali</a>
@endsection
