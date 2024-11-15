@extends('layouts.main')

@section('content')
    <div class="col-12 mt-5">
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex w-100 justify-content-center">
                    <div class="card w-50">
                        <div class="card-header text-center fw-bolder">
                            Register
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div">
                                                <label for="first_name" class="form-label">Nama Depan</label>
                                                <input type="text" class="form-control" id="first_name">
                                        </div>

                                        <div class="col-6">
                                            <div">
                                                <label for="last_name" class="form-label">Nama Belakang</label>
                                                <input type="text" class="form-control" id="last_name">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-3">
                                            <div">
                                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                                                <select class="form-select" id="jenis_identitas">
                                                    <option value="ktp">KTP</option>
                                                    <option value="sim">SIM</option>
                                                    <option value="kartu_pelajar">Kartu Pelajar</option>
                                                    <option value="passport">Passport</option>
                                                </select>
                                        </div>

                                        <div class="col-9">
                                            <div">
                                                <label for="nomor_identitas" class="form-label">Nomor Kartu
                                                    Identitas</label>
                                                <input type="text" class="form-control" id="nomor_identitas">
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email"
                                            aria-describedby="emailHelp" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password">
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No. Hp</label>
                                        <input type="tel" class="form-control" id="no_hp">
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" aria-describedby="alamat"></textarea>
                                    </div>

                                    <div class="mb-3" id="message">
                                    </div>

                                    <div class="mb-3 d-flex justify-content-end">
                                        <button type="submit" id="submit" class="btn btn-primary">Register</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    <script>
        $(document).ready(function() {
            const submitBtn = $("#submit")

            submitBtn.click(async function(e) {
                e.preventDefault()

                const errors = []
                const message = $("#message")

                // Form Value
                const email = $("#email").val()
                const password = $("#password").val()
                const firstName = $("#first_name").val()
                const lastName = $("#last_name").val()
                const jenisIdentitas = $("#jenis_identitas").val()
                const nomorIdentitas = $("#nomor_identitas").val()
                const noHp = $("#no_hp").val()
                const alamat = $("#alamat").val()

                if (email == "") {
                    errors.push("Email Kosong")
                }
                if (password == "") {
                    errors.push("Password Kosong")
                }
                if (firstName == "") {
                    errors.push("Nama Depan Kosong")
                }
                if (lastName == "") {
                    errors.push("Nama Belakang Kosong")
                }
                if (jenisIdentitas == "") {
                    errors.push("Jenis Identitas Kosong")
                }
                if (nomorIdentitas == "") {
                    errors.push("Nomor Identitas Kosong")
                }
                if (noHp == "") {
                    errors.push("No. Hp Kosong")
                }
                if (alamat == "") {
                    errors.push("Alamat Kosong")
                }

                if (errors.length > 0) {
                    return message.html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                Kesalahan:
                                <ul>
                                    ${errors.map(item => `<li>${item}</li>`).join('')}
                                </ul>
                        </div>
                    `)
                }

                try {
                    let type

                    const submit = await $.ajax({
                        url: "/register",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            email: email,
                            password: password,
                            first_name: firstName,
                            last_name: lastName,
                            jenis_identitas: jenisIdentitas,
                            nomor_identitas: nomorIdentitas,
                            no_hp: noHp,
                            alamat: alamat
                        }
                    })

                    if (submit.type == "success") {
                        type = "success"
                        link = '<a href="/login" class="alert-link">Log in</a>';
                    } else {
                        type = "danger"
                    }

                    message.html(`
                            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                ${submit.message} ${link}
                            </div>
                            `)

                } catch (e) {
                    message.html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            Backend Error!
                        </div>
                        `)

                    console.log(e)
                }





            })
        })
    </script>
@endsection
