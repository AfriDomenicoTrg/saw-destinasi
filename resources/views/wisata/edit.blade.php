<h2>Edit Wisata</h2>

<form action="{{ route('admin.wisata.update', $data->id) }}" method="POST">
@csrf
@method('PUT')

<input type="text" name="nama_wisata" value="{{ $data->nama_wisata }}"><br><br>
<input type="text" name="lokasi" value="{{ $data->lokasi }}"><br><br>
<input type="number" name="harga_tiket" value="{{ $data->harga_tiket }}"><br><br>

<textarea name="deskripsi">{{ $data->deskripsi }}</textarea><br><br>

<button type="submit">Update</button>
</form>
