<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Koleksi Buku</title>
</head>
<body>
    <h1>Manajemen Koleksi Buku</h1>
    <h2>Return Buku</h2>

    <form action="{{ route('return.store') }}" method="POST">
        @csrf
        <div>
            <label for="no_transaksi">No Transaksi Peminjaman</label>
            <input type="text" id="no_transaksi" name="no_transaksi">
        </div>

        <div>
            <label for="jatuh_tempo">Jatuh Tempo Return</label>
            <input type="date" id="jatuh_tempo" name="jatuh_tempo">
        </div>

        <div>
            <label for="keterlambatan">Keterlambatan (hari)</label>
            <input type="number" id="keterlambatan" name="keterlambatan">
        </div>

        <h3>Informasi Buku</h3>
        <div>
            <label for="id_buku">ID Buku</label>
            <input type="text" id="id_buku" name="id_buku">
        </div>
        <div>
            <label for="judul_buku">Judul Buku</label>
            <input type="text" id="judul_buku" name="judul_buku">
        </div>
        <div>
            <label for="pengarang">Pengarang</label>
            <input type="text" id="pengarang" name="pengarang">
        </div>
        <div>
            <label for="penerbit">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit">
        </div>
        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="text" id="tahun_terbit" name="tahun_terbit">
        </div>

        <h3>Informasi Peminjam</h3>
        <div>
            <label for="id_anggota">ID Anggota</label>
            <input type="text" id="id_anggota" name="id_anggota">
        </div>
        <div>
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap">
        </div>
        <div>
            <label for="no_hp">No. HP</label>
            <input type="text" id="no_hp" name="no_hp">
        </div>

        <h3>Penambahan Denda</h3>
        <div>
            <label for="denda_keterlambatan">Denda Keterlambatan</label>
            <input type="number" id="denda_keterlambatan" name="denda_keterlambatan">
        </div>
        <div>
            <label for="denda_kerusakan">Denda Kerusakan</label>
            <input type="number" id="denda_kerusakan" name="denda_kerusakan">
        </div>
        <div>
            <label for="denda_lainnya">Denda Lainnya</label>
            <input type="number" id="denda_lainnya" name="denda_lainnya">
        </div>

        <button type="submit">Terima Return</button>
    </form>
</body>
</html>
