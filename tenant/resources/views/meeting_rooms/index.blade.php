@extends('layouts.app')

@section('content')
<h2>Daftar Ruangan Meeting</h2>

<form method="GET" action="{{ route('meeting-rooms.index') }}">
    <input type="text" name="search" placeholder="Cari nama ruangan..." value="{{ request('search') }}">
    <button type="submit">Cari</button>
</form>

<a href="{{ route('meeting-rooms.create') }}">+ Tambah Ruangan</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @foreach ($rooms as $room)
    <tr>
        <td>{{ $room->kode_ruangan }}</td>
        <td>{{ $room->nama_ruangan }}</td>
        <td>
            @foreach ($room->categories as $cat)
                {{ $cat->nama_kategori }}@if(!$loop->last), @endif
            @endforeach
        </td>
        <td>{{ ucfirst($room->status) }}</td>
        <td>
            <a href="{{ route('meeting-rooms.edit', $room->id) }}">Edit</a>
            <form action="{{ route('meeting-rooms.destroy', $room->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
