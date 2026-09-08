<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | {{ \App\Models\Setting::get('site_name', 'Malfaur Engineering Products') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset(\App\Models\Setting::get('favicon', 'favicon.ico')) }}">
    
    <style>
        :root {
            --navy-deep: #040c17;
            --navy-card: #081528;
            --navy-input: #0e2038;
            --navy-border: #1e324d;
            --accent-gold: #EAB308;
            --accent-gold-hover: #F59E0B;
            --text-main: #FFFFFF;
            --text-muted: #94A3B8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--navy-deep);
            background-image: 
                radial-gradient(ellipse at 50% 0%, rgba(234, 179, 8, 0.12) 0%, transparent 65%),
                radial-gradient(circle at 100% 100%, rgba(14, 32, 56, 0.5) 0%, transparent 50%),
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 36px 36px, 36px 36px;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--navy-card);
            border: 1px solid var(--navy-border);
            border-radius: 16px;
            padding: 2.5rem 2.2rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.04);
            animation: cardFadeUp 0.35s ease;
        }

        @keyframes cardFadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            height: 48px;
            width: auto;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .login-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: -0.015em;
            margin-bottom: 0.35rem;
        }

        .login-subtitle {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #E2E8F0;
            margin-bottom: 0.45rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 0.9rem;
            width: 17px;
            height: 17px;
            color: #64748B;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 0.72rem 0.9rem 0.72rem 2.4rem;
            background: var(--navy-input);
            border: 1px solid var(--navy-border);
            border-radius: 9px;
            font-size: 0.88rem;
            color: #FFFFFF;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-input:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.18);
            background: #112744;
        }

        .form-input::placeholder {
            color: #475569;
        }

        .password-toggle {
            position: absolute;
            right: 0.85rem;
            background: none;
            border: none;
            color: #64748B;
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #E2E8F0;
        }

        .form-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.8rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox {
            accent-color: var(--accent-gold);
            width: 15px;
            height: 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: var(--accent-gold);
            color: #040c17;
            border: none;
            border-radius: 9px;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: var(--accent-gold-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(234, 179, 8, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #FCA5A5;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #6EE7B7;
        }

        .login-footer {
            margin-top: 1.75rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            padding-top: 1.25rem;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.78rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: color 0.15s ease;
        }

        .back-link:hover {
            color: #FFFFFF;
        }

        .cred-hint {
            margin-top: 1.25rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-align: center;
        }

        .cred-hint strong {
            color: var(--accent-gold);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset(\App\Models\Setting::get('logo', 'images/logo-transparent.png')) }}" alt="Malfaur Engineering" class="login-logo" onerror="this.src='{{ asset('images/logo-transparent.png') }}'">
            <h1 class="login-title">Admin Control Panel</h1>
            <p class="login-subtitle">Sign in to manage products, customer enquiries, and website settings.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="list-style:none;padding:0;margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrap">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@malfaurengineering.co.uk') }}" required autofocus class="form-input" placeholder="admin@malfaurengineering.co.uk" autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input type="password" id="password" name="password" required class="form-input" placeholder="••••••••" autocomplete="current-password">
                    <button type="button" class="password-toggle" id="togglePasswordBtn" aria-label="Toggle password visibility">
                        <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            <div class="form-extras">
                <label class="remember-label">
                    <input type="checkbox" name="remember" value="1" class="remember-checkbox" checked>
                    <span>Keep me signed in</span>
                </label>
            </div>

            <button type="submit" class="btn-login">
                <span>Sign In to Dashboard</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        <div class="cred-hint">
            Default Login: <strong>admin@malfaurengineering.co.uk</strong> / <strong>admin12345</strong>
        </div>

        <div class="login-footer">
            <a href="{{ route('home') }}" class="back-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Back to Malfaur Website</span>
            </a>
        </div>
    </div>

    <script>
        document.getElementById('togglePasswordBtn').addEventListener('click', function() {
            const pwd = document.getElementById('password');
            if (pwd.type === 'password') {
                pwd.type = 'text';
            } else {
                pwd.type = 'password';
            }
        });
    </script>
</body>
</html>
