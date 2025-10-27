@extends('layouts.app')

@section('content')
<h2>Edit Ruangan Meeting</h2>

<form action="{{ route('meeting-rooms.update', $meetingRoom->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Kode Ruangan:</label>
    <input type="text" name="kode_ruangan" value="{{ old('kode_ruangan', $meetingRoom->kode_ruangan) }}">
    @error('kode_ruangan') <p style="color:red">{{ $message }}</p> @enderror

    <label>Nama Ruangan:</label>
    <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $meetingRoom->nama_ruangan) }}">
    @error('nama_ruangan') <p style="color:red">{{ $message }}</p> @enderror

    <label>Deskripsi:</label>
    <textarea name="deskripsi">{{ old('deskripsi', $meetingRoom->deskripsi) }}</textarea>

    <label>Status:</label>
    <select name="status">
        <option value="tersedia" {{ $meetingRoom->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="disewa" {{ $meetingRoom->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
    </select>

    <label>Kategori:</label><br>
    @foreach ($categories as $category)
        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
            {{ in_array($category->id, $meetingRoom->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
        {{ $category->nama_kategori }}<br>
    @endforeach

    <button type="submit">Perbarui</button>
</form>

<a href="{{ route('meeting-rooms.index') }}">Kembali</a>
@endsection
