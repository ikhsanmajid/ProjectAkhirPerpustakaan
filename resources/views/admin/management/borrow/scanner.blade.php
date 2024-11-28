@extends('layouts.app')

@section('content')
    <div class="col-12 bg-white py-2 rounded-3">

        <div class="row p-3">
            <div class="col-12">
                <h2>Scanning Peminjaman</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div id="reader" style="width: 500px;"></div>
            </div>
        </div>

    </div>
@endsection

@section('script-js')
    <script src="{{ asset('storage/js/html5qrcode.js') }}" type="text/javascript"></script>
    <script>
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 30,
                qrbox: 600,
                supportedScanTypes: [
                    Html5QrcodeScanType.SCAN_TYPE_CAMERA
                ],
            });

        function onScanSuccess(decodedText, decodedResult) {
            window.open(
                decodedText,
                '_blank'
            );
        }
        html5QrcodeScanner.render(onScanSuccess);
    </script>
@endsection
