<h2>Tambah Wisata</h2>

<form action="{{ route('admin.wisata.store') }}" method="POST">
@csrf

<input type="text" name="nama_wisata" placeholder="Nama Wisata"><br><br>
<input type="text" name="lokasi" placeholder="Lokasi"><br><br>
<input type="number" name="harga_tiket" placeholder="Harga"><br><br>

<textarea name="deskripsi" placeholder="Deskripsi"></textarea><br><br>

<button type="submit">Simpan</button>
</form>
