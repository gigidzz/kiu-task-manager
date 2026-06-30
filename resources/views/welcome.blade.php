<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIU Task Manager — Kutaisi International University</title>
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
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%);
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #fff;
            margin: 0;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 22px 40px;
        }
        .topbar .brand { font-weight: 700; font-size: 1.1rem; color: #fff; text-decoration: none; }
        .topbar .brand i { color: var(--accent); }
        .topbar a.nav-btn {
            color: rgba(255,255,255,.8);
            text-decoration: none;
            font-size: .9rem;
            margin-left: 18px;
        }
        .topbar a.nav-btn:hover { color: #fff; }
        .topbar a.signup {
            background: var(--accent);
            padding: 8px 18px;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
        }
        .hero {
            max-width: 760px;
            margin: 0 auto;
            text-align: center;
            padding: 90px 24px 40px;
        }
        .hero h1 { font-size: 3rem; font-weight: 800; line-height: 1.1; margin-bottom: 18px; }
        .hero h1 span { color: var(--accent); }
        .hero p { font-size: 1.15rem; color: rgba(255,255,255,.7); margin-bottom: 36px; }
        .hero .btn-hero {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            padding: 13px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 1.05rem;
            display: inline-block;
            transition: opacity .15s;
        }
        .hero .btn-hero:hover { opacity: .9; }
        .hero .btn-ghost {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 13px 24px;
            margin-left: 8px;
        }
        .hero .btn-ghost:hover { text-decoration: underline; }
        .features {
            max-width: 1000px;
            margin: 30px auto 0;
            padding: 0 24px 80px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .feature {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 14px;
            padding: 26px 22px;
            text-align: left;
        }
        .feature i { font-size: 1.6rem; color: var(--accent); }
        .feature h5 { font-weight: 700; margin: 12px 0 6px; font-size: 1.05rem; }
        .feature p { color: rgba(255,255,255,.6); font-size: .88rem; margin: 0; }
    </style>
</head>
<body>
    <div class="topbar">
        <a href="{{ url('/') }}" class="brand">
            <i class="bi bi-journal-check me-1"></i>KIU Task Manager
        </a>
        <div>
            <a href="{{ route('login') }}" class="nav-btn">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-btn signup">Sign up</a>
            @endif
        </div>
    </div>

    <div class="hero">
        <h1>Stay on top of your <span>studies</span> at KIU</h1>
        <p>A simple task manager for Kutaisi International University students — track assignments, deadlines, priorities and tags, all in one place.</p>
        <a href="{{ route('register') }}" class="btn-hero">
            <i class="bi bi-rocket-takeoff me-1"></i>Get Started
        </a>
        <a href="{{ route('login') }}" class="btn-ghost">I already have an account</a>
    </div>

    <div class="features">
        <div class="feature">
            <i class="bi bi-check2-square"></i>
            <h5>Organize Tasks</h5>
            <p>Create, edit and complete assignments with priorities and subjects.</p>
        </div>
        <div class="feature">
            <i class="bi bi-calendar-event"></i>
            <h5>Track Deadlines</h5>
            <p>See what's due today, this week, or overdue at a glance.</p>
        </div>
        <div class="feature">
            <i class="bi bi-tags"></i>
            <h5>Tag & Filter</h5>
            <p>Label tasks with custom tags and filter your list instantly.</p>
        </div>
        <div class="feature">
            <i class="bi bi-paperclip"></i>
            <h5>Attach Files</h5>
            <p>Keep lab reports and reference images attached to each task.</p>
        </div>
    </div>
</body>
</html>
