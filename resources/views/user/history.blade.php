@extends('layouts.main')

@section('content')
    <div class="col-12 bg-white py-2 rounded-3">

        <div class="row p-3">
            <div class="col-12">
                <h2>History User</h2>
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header fw-bold">
                        Daftar Riwayat Peminjaman Buku
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle table-striped border">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Judul Buku</th>
                                        <th scope="col">Tanggal Rencana Pinjam</th>
                                        <th scope="col">Tanggal Pinjam</th>
                                        <th scope="col">Tanggal Rencana Kembali</th>
                                        <th scope="col">Tanggal Kembali</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($history as $item)
                                        <tr>
                                            <th scope="row">
                                                {{ ($history->currentPage() - 1) * $history->perPage() + $loop->iteration }}
                                            </th>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->rencana_ambil }}</td>
                                            <td>{{ $item->tanggal_ambil ?? '-' }}</td>
                                            <td>{{ $item->rencana_kembali }}</td>
                                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                                            <td>{{ $item->status ?? '-' }}</td>
                                            <td>
                                                @if ($item->status == "menunggu")
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="showQR({{ $item->id }})">
                                                        Lihat QR Code
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="QRModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">QR Code</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <div id="qrcode"></div>
                            </div><br />
                            <h4 class="text-center">Tunjukkan QR Code kepada Admin</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>



    </div>
@endsection

@section('script-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
        integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript"></script>
    <script>
        let qrcode = new QRCode(document.getElementById("qrcode"));

        const modalQR = new bootstrap.Modal(document.getElementById('QRModal'), {
            keyboard: false
        });

        function showQR(id) {
            qrcode.clear();
            qrcode.makeCode(`${id}`);

            modalQR.show();
        }
    </script>
@endsection
