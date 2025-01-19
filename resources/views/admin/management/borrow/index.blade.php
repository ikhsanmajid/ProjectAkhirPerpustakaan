@extends('layouts.app')

@section('content')
    <div class="row bg-white py-2 rounded-3">
        <div class="col-1">
            <a href="/admin/borrow/scanner" class="btn btn-md btn-primary mt-5">
                Scan QR Peminjaman
            </a>
        </div>
        <div class="col-11">
            <div class="container my-3">
                <div class="col col-11">
                    <h2 class="text-center mb-4">Manajemen Peminjaman Buku</h2>
                </div>

                <!-- Book Information Section -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5>Informasi Buku</h5>
                    </div>
                    <div class="card-body">
                        <form id="borrowForm" method="POST" action="{{-- {{ route('admin.borrow.record') }} --}}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="book_id" class="form-label">ID Buku</label>
                                    <div class="input-group">
                                        <input type="text" id="book_id" name="book_id" class="form-control"
                                            placeholder="Masukkan ID Buku" readonly>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#bookSearchModal">Cari Buku</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="title" class="form-label">Judul Buku</label>
                                    <input type="text" id="title" name="title" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="publisher" class="form-label">Penerbit</label>
                                    <input type="text" id="publisher" name="publisher" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="author" class="form-label">Pengarang</label>
                                    <input type="text" id="author" name="author" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="year" class="form-label">Tahun Terbit</label>
                                    <input type="text" id="year" name="year" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" id="isbn" name="isbn" class="form-control" readonly>
                                </div>
                            </div>
                        </form>
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
                                <div class="input-group">
                                    <input type="text" id="member_id" name="member_id" class="form-control"
                                        placeholder="Masukkan ID Anggota" readonly>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#userSearchModal">Cari Anggota</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="full_name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="full_name" name="full_name" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="phone" class="form-label">No. Hp</label>
                                <input type="text" id="phone" name="phone" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="text" id="email" name="email" class="form-control" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="identity_type" class="form-label">Jenis Identitas</label>
                                <input type="text" id="identity_type" name="identity_type" class="form-control"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="identity_number" class="form-label">No. Identitas</label>
                                <input type="text" id="identity_number" name="identity_number" class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" form="borrowForm" class="btn btn-success">Rekam Peminjaman</button>
                </div>
            </div>
        </div>

        <!-- Book Search Modal -->
        <div class="modal fade" id="bookSearchModal" tabindex="-1" aria-labelledby="bookSearchModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookSearchModalLabel">Cari Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="bookSearchInput" class="form-control mb-3" placeholder="Cari Buku...">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Buku</th>
                                    <th>Judul</th>
                                    <th>Penerbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bookResults">
                                <!-- Results will be inserted dynamically -->
                            </tbody>
                        </table>
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
                        <input type="text" id="userSearchInput" class="form-control mb-3"
                            placeholder="Cari Anggota...">
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
    </div>
@endsection
@section('script-js')
    <script>
        // AJAX for Book Search
        document.getElementById('bookSearchInput').addEventListener('input', function() {
            const query = this.value;

            if (query.length > 2) { // Only search if input is more than 2 characters
                fetch(`/admin/books/search?query=${query}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(books => {
                        const resultsTable = document.getElementById('bookResults');
                        resultsTable.innerHTML = ''; // Clear previous results

                        if (books.length === 0) {
                            resultsTable.innerHTML = '<tr><td colspan="4">No books found</td></tr>';
                        } else {
                            books.forEach(book => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${book.id}</td>
                                    <td>${book.title}</td>
                                    <td>${book.publisher}</td>
                                    <td><button class="btn btn-primary btn-sm" onclick='selectBook(${JSON.stringify(book)})'>Pilih</button></td>
                                `;
                                resultsTable.appendChild(row);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching books:', error.message);
                        const resultsTable = document.getElementById('bookResults');
                        resultsTable.innerHTML =
                            '<tr><td colspan="4">Error fetching books. Please try again later.</td></tr>';
                    });
            }
        });

        function selectBook(book) {
            console.log(book); // Tambahkan log untuk memeriksa data yang dikirim
            document.getElementById('book_id').value = book.id;
            document.getElementById('title').value = book.title;
            document.getElementById('publisher').value = book.publisher;
            document.getElementById('author').value = book.author;
            document.getElementById('year').value = book.publication_year;
            document.getElementById('isbn').value = book.isbn;

            // Close modal
            const bookSearchModal = bootstrap.Modal.getInstance(document.getElementById('bookSearchModal'));
            bookSearchModal.hide();
        }
    </script>
    <script>
        // AJAX for User Search
        document.getElementById('userSearchInput').addEventListener('input', function() {
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
            console.log(user);
            document.getElementById('member_id').value = user.id;
            document.getElementById('full_name').value = `${user.first_name} ${user.last_name ?? ""}`;
            document.getElementById('phone').value = user.no_hp;
            document.getElementById('email').value = user.email;
            document.getElementById('identity_type').value = user.jenis_identitas;
            document.getElementById('identity_number').value = user.nomor_identitas;

            // Close modal
            const userSearchModal = bootstrap.Modal.getInstance(document.getElementById('userSearchModal'));
            userSearchModal.hide();
        }
    </script>
@endsection
