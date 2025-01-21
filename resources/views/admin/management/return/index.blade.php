@extends('layouts.app')

@section('content')
<div class="col-12 bg-white py-2 rounded-3">

    <div class="row p-3">
        <div class="col-12">
            <h2>Manajemen Pengembalian</h2>
        </div>
    </div>

    <div class="row pb-3">
        <div class="col-12">
            <div class="accordion mb-3" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseOne">
                            Filter Pengembalian Buku
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <form method="GET" id="filter_return" action="{{ route('admin.return.index') }}"
                                class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="member_id" class="form-label">ID Anggota</label>
                                        <div class="input-group">
                                            <input type="text" id="member_id" name="member_id"
                                                value="{{ $query['member_id'] ?? '' }}" class="form-control"
                                                placeholder="Masukkan ID Anggota" readonly>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#userSearchModal">Cari Anggota</button>
                                        </div>
                                        <div class="form-text visually-hidden text-danger" id="error_member"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="full_name" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="full_name" value="{{ $query['full_name'] ?? '' }}"
                                            name="full_name" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">No. Hp</label>
                                        <input type="text" id="phone" name="phone" value="{{ $query['phone'] ?? '' }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text">Periode Peminjaman: </span>
                                            <span class="input-group-text">Tanggal Awal</span>
                                            <input onkeydown="return false" value="{{ $query['start_date'] ?? '' }}"
                                                autocomplete="off" type="text" class="form-control" name="start_date"
                                                id="pickupDate" readonly>
                                            <span class="input-group-text">Tanggal Akhir</span>
                                            <input onkeydown="return false" value="{{ $query['end_date'] ?? '' }}"
                                                autocomplete="off" type="text" class="form-control" name="end_date"
                                                id="returnDate" disabled>
                                        </div>
                                        <div class="form-text visually-hidden text-danger" id="error_date"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        <button type="submit" class="btn btn-primary me-2">Cari</button>
                                        <button type="button" onclick="clearFilter()" class="btn btn-secondary">Hapus
                                            Filter</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header fw-bold">
                    Daftar Peminjaman
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-striped border">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama User</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Rencana Kembali</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data))
                                    @forelse ($data as $item)
                                        <tr>
                                            <th scope="row">
                                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                            </th>
                                            <td>{{ $item->first_name . " " . $item->last_name ?? "" }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->tanggal_ambil ?? '-' }}</td>
                                            <td>{{ $item->rencana_kembali ?? '-' }}</td>
                                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                                            <td>{{ $item->status ?? '-' }}</td>
                                            <td>
                                                @if($item->status == "dipinjam")
                                                    <button class="btn btn-sm btn-warning"
                                                        onclick="showPengembalianModal({{$item}})">
                                                        Kembalikan Buku
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-secondary"
                                                        onclick="showPengembalianModal({{$item}})">
                                                        Detail
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>

    </div>

    <!-- User Search Modal -->
    <div class="modal fade" id="userSearchModal" tabindex="-1" aria-labelledby="userSearchModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userSearchModalLabel">Cari Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="userSearchInput" class="form-control mb-3" placeholder="Cari Anggota...">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Anggota</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="userResults">
                            <!-- Results will be inserted dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengembalian -->
    <div class="modal fade" id="pengembalianModal" tabindex="-1" aria-labelledby="pengembalianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengembalianModalLabel">Pengembalian Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="returnForm">
                        <!-- Return Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5>Informasi Transaksi</h5>
                            </div>
                            <div class="card-body">

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label for="modal_trx_id" class="form-label">ID Transaksi</label>
                                        <div class="input-group">
                                            <input type="text" id="modal_trx_id" name="modal_trx_id"
                                                class="form-control" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="modal_borrow_date" class="form-label">Tanggal Peminjaman</label>
                                        <input onkeydown="return false" value="" type="text" class="form-control"
                                            id="modal_borrow_date" name="modal_borrow_date" readonly>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="modal_planned_return" class="form-label">Tanggal Rencana
                                            Kembali</label>
                                        <div class="input-group">
                                            <input type="text" id="modal_planned_return" name="modal_planned_return"
                                                class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="modal_days_late" class="form-label">Keterlambatan</label>
                                        <div class="input-group">
                                            <input type="text" id="modal_days_late" name="modal_days_late"
                                                class="form-control" readonly>
                                            <span class="input-group-text" id="basic-addon2">Hari</span>
                                        </div>
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
                                        <label for="modal_book_id" class="form-label">ID Buku</label>
                                        <div class="input-group">
                                            <input type="text" id="modal_book_id" name="modal_book_id"
                                                class="form-control" placeholder="Masukkan ID Buku" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="modal_title" class="form-label">Judul Buku</label>
                                        <input type="text" id="modal_title" name="modal_title" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="modal_publisher" class="form-label">Penerbit</label>
                                        <input type="text" id="modal_publisher" name="modal_publisher"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="modal_author" class="form-label">Pengarang</label>
                                        <input type="text" id="modal_author" name="modal_author" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="modal_year" class="form-label">Tahun Terbit</label>
                                        <input type="text" id="modal_year" name="modal_year" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="modal_isbn" class="form-label">ISBN</label>
                                        <input type="text" id="modal_isbn" name="modal_isbn" class="form-control"
                                            readonly>
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
                                        <label for="modal_member_id" class="form-label">ID Anggota</label>
                                        <div class="input-group">
                                            <input type="text" id="modal_member_id" name="modal_member_id"
                                                class="form-control" placeholder="Masukkan ID Anggota" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="modal_full_name" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="modal_full_name" name="modal_full_name"
                                            class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="modal_phone" class="form-label">No. Hp</label>
                                        <input type="text" id="modal_phone" name="modal_phone" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="modal_email" class="form-label">Alamat Email</label>
                                        <input type="text" id="modal_email" name="modal_email" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="modal_identity_type" class="form-label">Jenis Identitas</label>
                                        <input type="text" id="modal_identity_type" name="modal_identity_type"
                                            class="form-control" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="modal_identity_number" class="form-label">No. Identitas</label>
                                        <input type="text" id="modal_identity_number" name="modal_identity_number"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5>Informasi Denda</h5>
                            </div>
                            <div class="card-body">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="modal_late_fine" class="form-label">Denda Keterlambatan</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon4">Rp.</span>
                                            <input type="number" id="modal_late_fine" name="modal_late_fine"
                                                class="form-control" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="modal_damage_fine" class="form-label">Denda Kerusakan</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon5">Rp.</span>
                                            <input type="number" id="modal_damage_fine" name="modal_damage_fine"
                                                class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label for="modal_others_fine" class="form-label">Denda Lainnya</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon6">Rp.</span>
                                            <input type="number" id="modal_others_fine" name="modal_others_fine"
                                                class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-6">
                                        <label for="modal_total_fine" class="form-label"><strong>Total
                                                Denda</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon9">Rp.</span>
                                            <input type="number" id="modal_total_fine" name="modal_total_fine"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="button" onclick="kembalikanBuku()" id="modal_button" class="btn btn-success">Rekam
                                Pengembalian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#pickupDate').datepicker({
            format: 'dd-mm-yyyy',
            endDate: new Date(),
            autoclose: true,
            clearBtn: true,
        })

        function updateReturnDate(pickupValue) {
            if (pickupValue === "") {
                $('#returnDate').prop('disabled', true)
                $('#returnDate').datepicker('setDate', "")
                return
            }

            $('#returnDate').prop('disabled', false);
            $('#returnDate').datepicker('destroy');
            $('#returnDate').val('');
            const splittedDate = pickupValue.split("-")
            $('#returnDate').datepicker({
                format: 'dd-mm-yyyy',
                startDate: new Date(`${splittedDate[1]}/${splittedDate[0]}/${splittedDate[2]}`),
                endDate: new Date(),
                autoclose: true,
                clearBtn: true
            });
        }

        const pickupValue = $('#pickupDate').val()

        if (pickupValue !== "") {
            updateReturnDate(pickupValue)
        }

        $('#pickupDate').on('change', function () {
            updateReturnDate($('#pickupDate').val())
        })

        function checkIsValid() {
            let isValid = true
            const member_id = $('#member_id').val().trim()
            const pickupDateInput = $('#pickupDate').val().trim()
            const returnDateInput = $('#returnDate').val().trim()

            if (pickupDateInput.length > 0 && returnDateInput.length <= 0) {
                $('#error_date').html('Wajib Mengisi Tanggal Akhir jika Mengisi Tanggal Awal')
                $('#error_date').removeClass('visually-hidden')
                isValid = false
            } else {
                $('#error_date').addClass('visually-hidden')
            }

            return isValid
        }

        document.getElementById("filter_return").addEventListener('submit', function (event) {
            event.preventDefault()

            if (checkIsValid()) {
                this.submit()
            } else {
                return
            }
        })

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function clearFilter() {
        document.getElementById('member_id').value = "";
        document.getElementById('full_name').value = "";
        document.getElementById('phone').value = "";
        document.getElementById('pickupDate').value = "";
        document.getElementById('returnDate').value = "";
        $('#returnDate').prop('disabled', true)
    }
</script>
<script>
    function showPengembalianModal(data) {
        if (data.status === "menunggu") {
            $('#modal_damage_fine').prop("readonly", true)
            $('#modal_others_fine').prop("readonly", true)
            $('#modal_button').attr('onclick', 'batalkanPeminjaman()')
            $('#modal_button').html('Batalkan Peminjaman')
            $('#modal_button').removeClass('btn-success')
            $('#modal_button').addClass('btn-danger')
            $('#modal_button').prop('disabled', false)
        } else if (data.status == "dikembalikan" || data.status == "batal") {
            $('#modal_damage_fine').prop("readonly", true)
            $('#modal_others_fine').prop("readonly", true)
            $('#modal_button').attr('onclick', '')
            $('#modal_button').html('Rekam Pengembalian')
            $('#modal_button').removeClass('btn-danger')
            $('#modal_button').addClass('btn-success')
            $('#modal_button').prop('disabled', true)
        } else {
            $('#modal_damage_fine').prop("readonly", false)
            $('#modal_others_fine').prop("readonly", false)
            $('#modal_button').attr('onclick', 'kembalikanBuku()')
            $('#modal_button').html('Rekam Pengembalian')
            $('#modal_button').removeClass('btn-danger')
            $('#modal_button').addClass('btn-success')
            $('#modal_button').prop('disabled', false)
        }

        const plannedReturnDate = data.rencana_kembali.split("-");
        const UTCLate = new Date() - new Date(`${plannedReturnDate[1]}/${plannedReturnDate[2]}/${plannedReturnDate[0]}`);
        const daysLate = data.late ?? Math.floor(UTCLate / (1000 * 60 * 60 * 24));

        const lateFineBase = 3000;

        function calculateFine() {
            const damageFine = Number($('#modal_damage_fine').val()) || 0;
            const othersFine = Number($('#modal_others_fine').val()) || 0;
            const lateFine = Math.max(0, daysLate) * lateFineBase;
            return lateFine + damageFine + othersFine;
        }

        $('#modal_damage_fine, #modal_others_fine').on('input', function () {
            const totalFine = calculateFine();
            $('#modal_total_fine').val(totalFine);
        });


        const initialLateFine = data.denda_keterlambatan == "0.00" ? Math.max(0, daysLate) * lateFineBase : data.denda_keterlambatan;
        const initialTotalFine = data.denda_keterlambatan == "0.00" ? initialLateFine : Number(data.denda_kerusakan) + Number(data.denda_keterlambatan) + Number(data.denda_lainnya)
        $('#modal_trx_id').val(data.id);
        $('#modal_planned_return').val(data.rencana_kembali);
        $('#modal_days_late').val(daysLate < 0 ? "0" : daysLate);
        $('#modal_book_id').val(data.book_id);
        $('#modal_title').val(data.title);
        $('#modal_publisher').val(data.publisher);
        $('#modal_author').val(data.author);
        $('#modal_year').val(data.publication_year);
        $('#modal_isbn').val(data.isbn);
        $('#modal_borrow_date').val(data.tanggal_ambil);
        $('#modal_member_id').val(data.user_id);
        $('#modal_full_name').val(`${data.first_name} ${data.last_name || ""}`);
        $('#modal_phone').val(data.no_hp);
        $('#modal_email').val(data.email);
        $('#modal_identity_type').val(data.jenis_identitas.toUpperCase());
        $('#modal_identity_number').val(data.nomor_identitas);
        $('#modal_late_fine').val(initialLateFine);
        $('#modal_damage_fine').val(data.denda_kerusakan ?? 0);
        $('#modal_others_fine').val(data.denda_lainnya ?? 0);
        $('#modal_total_fine').val(initialTotalFine);

        console.log(typeof data.denda_keterlambatan)

        // Menampilkan modal
        const pengembalianModal = new bootstrap.Modal('#pengembalianModal');
        pengembalianModal.show();
    }

    async function kembalikanBuku() {
        const data = {
            idTrx: $('#modal_trx_id').val(),
            idBuku: $('#modal_book_id').val(),
            dendaKeterlambatan: $('#modal_late_fine').val(),
            dendaKerusakan: $('#modal_damage_fine').val(),
            dendaLainnya: $('#modal_others_fine').val(),
            late: $('#modal_days_late').val()
        }

        try {
            const prosesPinjam = await fetch(`return/${data.idTrx}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _token: "{{ csrf_token() }}",
                    id_buku: data.idBuku,
                    denda_keterlambatan: data.dendaKeterlambatan,
                    denda_kerusakan: data.dendaKerusakan,
                    denda_lainnya: data.dendaLainnya,
                    late: data.late,
                    method: 'kembali'
                })
            })

            const result = await prosesPinjam.json()

            if (prosesPinjam.ok) {
                if (result.status == 'success') {
                    Swal.fire({
                        title: "Sukses!",
                        text: result.message,
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: result.message,
                        icon: "error"
                    });
                }
            }

        } catch (e) {
            //console.log(e)
            Swal.fire({
                title: "Backend Error!",
                html: `Kesalahan Internal Sistem <br> <strong>request_id: ${crypto.randomUUID()}</strong>`,
                icon: "error"
            });
        }
    }

    async function batalkanPeminjaman() {
        const data = {
            idTrx: $('#modal_trx_id').val(),
            idBuku: $('#modal_book_id').val(),
        }

        try {
            const prosesPinjam = await fetch(`return/${data.idTrx}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _token: "{{ csrf_token() }}",
                    id_buku: data.idBuku,
                    late: 0,
                    method: 'batal'
                })
            })

            const result = await prosesPinjam.json()

            if (prosesPinjam.ok) {
                if (result.status == 'success') {
                    Swal.fire({
                        title: "Sukses!",
                        text: result.message,
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: result.message,
                        icon: "error"
                    });
                }
            }

        } catch (e) {
            //console.log(e)
            Swal.fire({
                title: "Backend Error!",
                html: `Kesalahan Internal Sistem <br> <strong>request_id: ${crypto.randomUUID()}</strong>`,
                icon: "error"
            });
        }
    }

</script>
<script>
    // AJAX for User Search
    document.getElementById('userSearchInput').addEventListener('input', function () {
        const query = this.value;

        if (query.length > 2) {
            fetch(`/admin/users/search?query=${query}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(users => {
                    const resultsTable = document.getElementById('userResults');
                    resultsTable.innerHTML = ''; // Clear previous results

                    if (users.length === 0) {
                        resultsTable.innerHTML = '<tr><td colspan="4">No users found</td></tr>';
                    } else {
                        users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                    <td>${user.id}</td>
                                    <td>${user.first_name} ${user.last_name ?? ""}</td>
                                    <td>${user.email}</td>
                                    <td><button class="btn btn-primary btn-sm" onclick='selectUser(${JSON.stringify(user)})'>Pilih</button></td>
                                `;
                            resultsTable.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching users:', error.message);
                    const resultsTable = document.getElementById('userResults');
                    resultsTable.innerHTML =
                        '<tr><td colspan="4">Error fetching books. Please try again later.</td></tr>';
                });
        }
    });

    function selectUser(user) {
        //console.log(user);
        document.getElementById('member_id').value = user.id;
        document.getElementById('full_name').value = `${user.first_name} ${user.last_name ?? ""}`;
        document.getElementById('phone').value = user.no_hp;

        // Close modal
        const userSearchModal = bootstrap.Modal.getInstance(document.getElementById('userSearchModal'));
        userSearchModal.hide();
    }
</script>
@endsection