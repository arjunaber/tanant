@extends('layouts.app')

@section('content')
<h2>Tambah Ruangan Meeting</h2>

<form action="{{ route('meeting-rooms.store') }}" method="POST">
    @csrf
    <label>Kode Ruangan:</label>
    <input type="text" name="kode_ruangan" value="{{ old('kode_ruangan') }}">
    @error('kode_ruangan') <p style="color:red">{{ $message }}</p> @enderror

    <label>Nama Ruangan:</label>
    <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan') }}">
    @error('nama_ruangan') <p style="color:red">{{ $message }}</p> @enderror

    <label>Deskripsi:</label>
    <textarea name="deskripsi">{{ old('deskripsi') }}</textarea>

    <label>Status:</label>
    <select name="status">
        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
    </select>

    <label>Kategori:</label><br>
    @foreach ($categories as $category)
        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
        {{ $category->nama_kategori }}<br>
    @endforeach
    @error('categories') <p style="color:red">{{ $message }}</p> @enderror

    <button type="submit">Simpan</button>
</form>

<a href="{{ route('meeting-rooms.index') }}">Kembali</a>
@endsection
