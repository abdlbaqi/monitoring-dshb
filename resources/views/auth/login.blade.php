<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Dishub Kota Bandar Lampung</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header {
            background: linear-gradient(to right, #004B97, #007BFF);
            color: #fff;
            padding: 20px 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .main {
            display: flex;
            flex: 1;
            height: calc(100vh - 70px); /* tinggi sisa di bawah header */
        }

        .left {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            padding: 40px;
            z-index: 1;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .form-box .logo {
            width: 70px;
            display: block;
            margin: 0 auto 20px;
        }

        .form-box .instansi {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #007BFF;
            margin-bottom: 25px;
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #004B97;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .right {
            flex: 1;
            background: url('{{ asset("images/dishub-bg.jpg") }}') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .right::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 75, 151, 0.5); /* biru transparan */
            backdrop-filter: blur(3px);
        }

        @media (max-width: 768px) {
            .main {
                flex-direction: column;
            }

            .right {
                height: 200px;
            }
        }
    </style>
</head>
<body>

    <header>
        Indikator Kinerja Dinas Perhubungan Kota Bandar Lampung
    </header>

    <div class="main">
        <div class="left">
            <div class="form-box">
                <img src="{{ asset('images/logo-dishub.png') }}" alt="Logo Dishub" class="logo">
                <div class="instansi">Dinas Perhubungan Kota Bandar Lampung</div>
                <h2>Login</h2>

                @if ($errors->any())
                    <div class="error-message">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <button type="submit">Masuk</button>
                </form>

                <div class="footer">
                    © {{ date('Y') }} Dinas Perhubungan Kota Bandar Lampung
                </div>
            </div>
        </div>

        <div class="right"></div>
    </div>

</body>
</html>
