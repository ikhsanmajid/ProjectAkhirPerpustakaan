@extends('layouts.main')

@section('content')
    <div class="col-12 mt-5">
        <div class="row h-100">
            <div class="d-flex w-100 justify-content-center">
                <div class="card w-25">
                    <div class="card-header text-center fw-bolder">
                        Register
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password">
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name">
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
                const name = $("#name").val()

                if (email == "") {
                    errors.push("Email Kosong")
                }
                if (password == "") {
                    errors.push("Password Kosong")
                }
                if (name == "") {
                    errors.push("Nama Kosong")
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
                            name: name
                        }
                    })

                    if (submit.type == "success") {
                        type = "success"
                    } else {
                        type = "danger"
                    }

                    message.html(`
                            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                ${submit.message}
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
