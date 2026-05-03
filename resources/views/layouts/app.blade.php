<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIU Student Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #1e2a3a;
            --navy-soft: #273446;
            --accent: #4f8ef7;
            --bg: #f5f6fa;
            --card-bg: #ffffff;
            --muted: #8693a4;
            --border: #e8eaed;
        }

        body { background: var(--bg); font-family: 'Segoe UI', system-ui, sans-serif; color: #2d3748; }

        /* Navbar */
        .navbar { background: var(--navy) !important; border-bottom: 1px solid var(--navy-soft); padding: 14px 0; }
        .navbar-brand { font-weight: 700; font-size: 1.05rem; color: #fff !important; letter-spacing: .2px; }
        .navbar-brand i { color: var(--accent); }
        .nav-link-item { color: rgba(255,255,255,.65) !important; font-size: .875rem; text-decoration: none; padding: 6px 12px; border-radius: 6px; transition: all .15s; }
        .nav-link-item:hover, .nav-link-item.active { color: #fff !important; background: rgba(255,255,255,.1); }
        .btn-nav-new { background: var(--accent); color: #fff; font-size: .8rem; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: opacity .15s; }
        .btn-nav-new:hover { opacity: .88; color: #fff; }

        /* Cards */
        .card { border: 1px solid var(--border); border-radius: 12px; box-shadow: none; background: var(--card-bg); }

        /* Table */
        .table > thead th { background: var(--navy); color: rgba(255,255,255,.85); font-weight: 500; font-size: .8rem; letter-spacing: .5px; text-transform: uppercase; border: none; }
        .table > tbody > tr { border-color: var(--border); }
        .table-hover > tbody > tr:hover > td { background-color: #f8f9ff; }

        /* Priority colours */
        .priority-high   { color: #e53e3e; font-weight: 600; }
        .priority-medium { color: #d97706; font-weight: 600; }
        .priority-low    { color: #38a169; font-weight: 600; }

        /* Status badges */
        .badge-done    { background: #d1fae5; color: #065f46; font-weight: 600; }
        .badge-pending { background: #f3f4f6; color: #6b7280; font-weight: 600; }

        /* Overdue row */
        tr.row-overdue > td { background-color: #fff5f5; }

        /* Toggle button */
        .toggle-btn { min-width: 90px; font-size: .78rem; font-weight: 600; border-radius: 20px; padding: 4px 12px; transition: all .15s; }
        .toggle-btn.spinning { opacity: .5; pointer-events: none; }

        /* Deadline overdue text */
        .deadline-overdue { color: #e53e3e; font-weight: 600; }

        /* Page heading */
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--navy); }
        .page-subtitle { color: var(--muted); font-size: .875rem; }

        /* Flash */
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-journal-check me-2"></i>KIU Task Manager
            </a>
            <div class="ms-auto d-flex align-items-center gap-1">
                <a href="{{ route('dashboard') }}" class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('tasks.index') }}" class="nav-link-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                    Tasks
                </a>
                <a href="{{ route('tasks.create') }}" class="btn-nav-new ms-2">
                    + New Task
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-4" style="max-width: 1100px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
