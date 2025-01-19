@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Left Column: Image -->
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <img class="img-fluid"
                    src="{{ $book->image ? asset('storage/' . $book->image) : asset('images/book-null.png') }}"
                    alt="{{ $book->title }}" style="width: 80%; height: auto; object-fit: cover;">
            </div>

            <!-- Right Column: Description -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title h1">{{ $book->title }}</h5>
                        <h4>
                            <span
                                class="badge badge-pill text-bg-{{ $book->available_quantity == 0 ? 'danger' : 'primary' }}">
                                {{ $book->available_quantity == 0 ? 'Tidak Tersedia' : 'Tersedia: ' . $book->available_quantity }}</span>
                        </h4>

                        <p class="card-text">
                        <p><strong>Author:</strong> {{ $book->author }}</p>
                        <p><strong>Category:</strong> {{ $book->category->name }}</p>
                        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                        <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
                        <p><strong>Published Year:</strong> {{ $book->publication_year }}</p>
                        <p><strong>Description:</strong> <br>{{ $book->description }}</p>
                        </p>
                        <!-- Borrow Button (conditionally displayed based on authentication) -->
                        @auth
                            @if (Auth::user()->role == 'user')
                                <!-- Assuming 'user' role is for book borrowers -->
                                {{-- <form action="{{ route('borrow.book', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Pinjam Buku</button>
                                </form> --}}
                                <button class="btn btn-success" {{ $book->available_quantity == 0 ? 'disabled' : '' }}
                                    {{ $book->available_quantity > 0 ? 'onClick=coba(' . $book->id . ')' : '' }}>Pinjam
                                    Buku</button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning">Silahkan Login Untuk Pinjam</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <img class="img-fluid"
                                        src="{{ $book->image ? asset('storage/' . $book->image) : asset('images/book-null.png') }}"
                                        alt="{{ $book->title }}" style="width: 80%; height: auto; object-fit: cover;">
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="bookTitle" class="form-label">Judul Buku</label>
                                        <input type="text" onkeydown="return false" class="form-control" id="bookTitle"
                                            name="bookTitle" value="{{ $book->title }}" readonly>
                                    </div>

                                    <!-- Tanggal Rencana Pengambilan -->
                                    <div class="mb-3">
                                        <label for="pickupDate" class="form-label">Tanggal Rencana Pengambilan</label>
                                        <input onkeydown="return false" value="" type="text" class="form-control"
                                            id="pickupDate" required>
                                        <div class="invalid-feedback" id="errorPickup">
                                            Pilih Tanggal Pengambilan
                                        </div>

                                    </div>

                                    <!-- Tanggal Pengembalian -->
                                    <div class="mb-3">
                                        <label for="returnDate" class="form-label">Tanggal Pengembalian</label>
                                        <input onkeydown="return false" value="" type="text" class="form-control"
                                            id="returnDate" required disabled="disabled">
                                        <div class="invalid-feedback" id="errorReturn">
                                            Pilih Tanggal Pengembalian
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" onclick="pinjam()" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#pickupDate').datepicker({
                format: 'dd-mm-yyyy',
                startDate: new Date(),
                endDate: new Date(new Date().setDate(new Date().getDate() + 14)),
                autoclose: true
            });

            $('#pickupDate').on('change', function() {
                $('#returnDate').prop('disabled', false);
                $('#returnDate').datepicker('destroy');
                $('#returnDate').val('');
                $('#returnDate').datepicker({
                    format: 'dd-mm-yyyy',
                    startDate: new Date(new Date().setDate(new Date($('#pickupDate').val()
                        .split('-').reverse().join('/')).getDate() + 1)),
                    endDate: new Date(new Date().setDate(new Date($('#pickupDate').val()
                        .split('-').reverse().join('/')).getDate() + 14)),
                    autoclose: true
                });
            })
        });

        const modalPinjam = new bootstrap.Modal(document.getElementById('modalPinjam'));

        function coba(idBuku) {
            modalPinjam.show();
        }

        function pinjam() {
            const pickupDate = $('#pickupDate').val();
            const returnDate = $('#returnDate').val();
            pickupDate == '' ? $('#errorPickup').show() : $('#errorPickup').hide();
            returnDate == '' ? $('#errorReturn').show() : $('#errorReturn').hide();

            fetch(`/borrow`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                        id_user: '{{ Auth::user()->id ?? "" }}',
                        id_buku: '{{ $book->id }}',
                        rencana_tanggal_pinjam: pickupDate.split('-').reverse().join('/'),
                        rencana_tanggal_kembali: returnDate.split('-').reverse().join('/'),
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
