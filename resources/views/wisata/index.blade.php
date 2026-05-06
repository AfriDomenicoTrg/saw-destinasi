<h2>Data Wisata</h2>

<a href="{{ route('admin.wisata.create') }}">Tambah Data</a>

@if(session('success'))
<p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Lokasi</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $i => $d)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $d->nama_wisata }}</td>
        <td>{{ $d->lokasi }}</td>
        <td>{{ $d->harga_tiket }}</td>
        <td>
            <a href="{{ route('admin.wisata.edit', $d->id) }}">Edit</a>

            <form action="{{ route('admin.wisata.destroy', $d->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
