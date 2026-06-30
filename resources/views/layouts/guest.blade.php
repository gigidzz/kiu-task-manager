<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KIU Task Manager' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #1e2a3a;
            --navy-soft: #273446;
            --accent: #4f8ef7;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%);
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 24px;
        }
        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 18px 50px rgba(0,0,0,.25);
            width: 100%;
            max-width: 430px;
            overflow: hidden;
        }
        .auth-head {
            text-align: center;
            padding: 32px 32px 8px;
        }
        .auth-head .brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--navy);
        }
        .auth-head .brand i { color: var(--accent); }
        .auth-head .subtitle { color: #8693a4; font-size: .875rem; margin-top: 4px; }
        .auth-body { padding: 16px 32px 32px; }
        .form-label { font-weight: 600; font-size: .85rem; color: #2d3748; }
        .form-control { border-radius: 8px; padding: 10px 12px; }
        .btn-accent {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            border: none;
            transition: opacity .15s;
        }
        .btn-accent:hover { opacity: .9; color: #fff; }
        .auth-foot { text-align: center; font-size: .85rem; color: #8693a4; margin-top: 18px; }
        .auth-foot a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .auth-foot a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-head">
            <a href="{{ url('/') }}" class="brand text-decoration-none">
                <i class="bi bi-journal-check me-1"></i>KIU Task Manager
            </a>
            <div class="subtitle">{{ $subtitle ?? 'Kutaisi International University' }}</div>
        </div>
        <div class="auth-body">
            @yield('content')
        </div>
    </div>
</body>
</html>
