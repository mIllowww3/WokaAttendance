<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Woka Login</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #4338ca, #6366f1, #8b5cf6, #ec4899);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 380px;
            padding: 45px 35px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.35);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
        }

        .avatar {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.28);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar i {
            font-size: 45px;
            opacity: 0.85;
        }

        h4 {
            letter-spacing: 1px;
            font-weight: 500;
            margin-bottom: 35px;
        }

        /* 🔥 FINAL — INPUT GROUP RATA TENGAH DAN SIMETRIS */
        .input-group {
            width: 100%;
            position: relative;
            margin-bottom: 28px;

            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 10px;

            padding: 12px 15px;
            padding-left: 45px;
            /* ruang icon agar pas */
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);

            box-sizing: border-box;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
        }

        .input-group input {
            width: 100%;
            background: transparent;
            border: none;
            color: white;
            font-size: 14px;
            outline: none;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.75);
        }

        .tools {
            width: 100%;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-top: -8px;
        }

        .tools a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 30px;
            margin-top: 30px;
            font-size: 14px;
            font-weight: 600;
            background: linear-gradient(90deg, #6d28d9, #7c3aed, #6366f1);
            color: white;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            opacity: 0.92;
        }

        .alert-box {
            width: 100%;
            background: rgba(255, 80, 80, 0.75);
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="avatar">
            <i class="fa fa-user"></i>
        </div>

        <h4>USER LOGIN</h4>

        @if($errors->any())
        <div class="alert-box">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Masukan Email " value="{{ old('email') }}" required>
            </div>
            @error('email')
            <div class="alert-box">{{ $message }}</div>
            @enderror

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Masukan Password" required>
            </div>
            @error('password')
            <div class="alert-box">{{ $message }}</div>
            @enderror
            
            <button class="login-btn">LOGIN</button>
        </form>

    </div>

</body>

</html>