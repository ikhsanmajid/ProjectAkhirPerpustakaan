@extends('layouts.app')

@section('content')
    <div class="col-12 bg-white py-2 rounded-3">
        <div class="container my-3">
            <h2 class="text-center mb-4">Manajemen Peminjaman Buku</h2>

            <!-- Informasi Transaksi -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="trx_id" class="form-label">ID Transaksi</label>
                            <input type="text" id="trx_id" name="trx_id" class="form-control"
                                placeholder="Masukkan ID Buku" value="{{ $data->trx_id }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_rencana_ambil" class="form-label">Rencana Pengambilan Buku</label>
                            <input type="text" id="tanggal_rencana_ambil" value="{{ $data->rencana_ambil }}"
                                name="tanggal_rencana_ambil" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_rencana_kembali" class="form-label">Rencana Pengembalian Buku</label>
                            <input type="text" id="tanggal_rencana_kembali" value="{{ $data->rencana_kembali }}"
                                name="tanggal_rencana_ambil" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Information Section -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Informasi Buku</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="book_id" class="form-label">ID Buku</label>
                            <input type="text" id="book_id" name="book_id" class="form-control"
                                placeholder="Masukkan ID Buku" value="{{ $data->book_id }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="title" class="form-label">Judul Buku</label>
                            <input type="text" id="title" name="title" value="{{ $data->title }}"
                                class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="publisher" class="form-label">Penerbit</label>
                            <input type="text" id="publisher" name="publisher" value="{{ $data->publisher }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="author" class="form-label">Pengarang</label>
                            <input type="text" id="author" name="author" value="{{ $data->author }}"
                                class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">Tahun Terbit</label>
                            <input type="text" id="year" name="year" value="{{ $data->publication_year }}"
                                class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" id="isbn" name="isbn" value="{{ $data->isbn }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrower Information Section -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Informasi Peminjam</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="member_id" class="form-label">ID Anggota</label>
                            <input type="text" id="member_id" name="member_id" class="form-control"
                                placeholder="Masukkan ID Anggota" value="{{ $data->id }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="full_name" name="full_name"
                                value="{{ $data->first_name . ' ' . $data->last_name }}" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="phone" class="form-label">No. Hp</label>
                            <input type="text" id="phone" name="phone" value="{{ $data->no_hp }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="text" id="email" name="email" value="{{ $data->email }}"
                                class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="identity_type" class="form-label">Jenis Identitas</label>
                            <input type="text" id="identity_type" name="identity_type"
                                value="{{ strtoupper($data->jenis_identitas) }}" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="identity_number" class="form-label">No. Identitas</label>
                            <input type="text" id="identity_number" name="identity_number"
                                value="{{ $data->nomor_identitas }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" onclick="updateData()" form="borrowForm" class="btn btn-success">Rekam Peminjaman</button>
            </div>
        </div>

    </div>
@endsection
@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateData() {
            // Update Data Buku
            fetch("{{ $data->trx_id }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                    })
                }).then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status == 'success') {
                        Swal.fire({
                            title: "Sukses!",
                            text: data.message,
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                modalPinjam.hide();
                                window.location.reload();
                            }
                        });
                    } else if (data.status == 'failed') {
                        Swal.fire({
                            title: "Gagal!",
                            text: data.message,
                            icon: "error"
                        });
                    }
                }).catch((error) => {
                    alert("Backend error");
                });
        }
    </script>
@endsection
