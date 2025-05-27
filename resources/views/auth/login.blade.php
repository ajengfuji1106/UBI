<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universitas Bakti Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex vh-100">
        <div class="d-flex flex-column flex-md-row w-100 bg-white rounded-4 shadow overflow-hidden">
            
            <!-- Bagian Kiri - Form Login -->
            <div class="p-5 flex-fill d-flex flex-column justify-content-center">
                <div class ="d-flex align-items-center mb-4">
                    <img src="{{ asset('assets/UBI.png') }}" alt="Logo UBI" class="img-fluid me-3" style="max-width: 50px; height: auto;">
                    <h5 class="fw-bold">Universitas Bakti Indonesia</h5>
                </div>
                <h2 class="fw-semibold">Login</h2>
                <p class="text-muted mb-4">Login to access your account</p>

                 <!-- Pesan Error Login -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-semibold text-dark">Login</button>
                </form>
            </div>

            <!-- Ilustrasi -->
            <!-- Ilustrasi -->
<div class="d-none d-md-flex justify-content-center align-items-center bg-light flex-fill">
    <img src="{{ asset('assets/ilustrasi.png') }}" alt="Secure Login" class="img-fluid" style="max-width: 400px; max-height: 400px;">
</div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
