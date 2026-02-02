<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #396068;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            background: #ffffff;
            border-radius: 3rem;
            overflow: hidden;
            display: flex;
            box-shadow: 0 40px 80px rgba(0,0,0,0.25);
        }

        /* LEFT PANEL */
        .left {
            width: 45%;
            background: linear-gradient(160deg, #396068, #2d4d54);
            padding: 60px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            text-transform: uppercase;
        }

        .left span {
            display: block;
            margin-top: 12px;
            font-size: 1.1rem;
            color: #f3e5ab;
            font-weight: 600;
        }

        .left p {
            margin-top: 24px;
            color: #d1d5db;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* RIGHT PANEL */
        .right {
            width: 55%;
            padding: 70px;
            background: #fcfcfc;
        }

        .logo {
            margin-bottom: 40px;
        }

        .logo img {
            height: 48px;
        }

        .title {
            font-size: 2rem;
            font-weight: 900;
            color: #396068;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.2em;
            color: #6b7280;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            font-weight: 600;
            outline: none;
            background: white;
        }

        input:focus {
            border-color: #b4955e;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .actions a {
            color: #396068;
            font-weight: 700;
            text-decoration: none;
        }

        .actions a:hover {
            color: #b4955e;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(to right, #396068, #2d4d54);
            color: white;
            font-weight: 900;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .btn:hover {
            background: #b4955e;
            color: #396068;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #9ca3af;
        }

        @media (max-width: 900px) {
            .login-wrapper {
                flex-direction: column;
            }
            .left {
                display: none;
            }
            .right {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT BRAND PANEL -->
    <div class="left">
        <h1>Admin</h1>
        <span>Control Panel</span>
        <p>
            Secure access to manage company content, services,
            portfolio and client inquiries.
        </p>
    </div>

    <!-- RIGHT FORM -->
    <div class="right">
        <div class="logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Company Logo">
        </div>

        <div class="title">Sign In</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="actions">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot?</a>
                @endif
            </div>

            <button class="btn">Login</button>
        </form>

        <div class="footer">
            © {{ date('Y') }} Company Admin
        </div>
    </div>

</div>

</body>
</html>
