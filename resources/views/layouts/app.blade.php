<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bug Tracker') }} - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #212529;
            --sidebar-hover: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            padding-top: 0;
            overflow-y: auto;
            z-index: 1040;
            transition: transform 0.3s ease;
        }

        .sidebar .brand {
            padding: 20px 20px;
            border-bottom: 1px solid #343a40;
        }

        .sidebar .brand h4 {
            color: #fff;
            margin: 0;
            font-weight: 700;
        }

        .sidebar .brand small {
            color: #adb5bd;
            font-size: 0.75rem;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-radius: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: var(--sidebar-hover);
        }

        .sidebar .nav-link.active {
            border-left: 3px solid #0d6efd;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-section {
            color: #6c757d;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 15px 20px 5px;
            font-weight: 600;
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 25px;
        }

        .content-wrapper {
            padding: 25px;
        }

        /* ── Stat Cards ── */
        .stat-card {
            border: none;
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .card-body {
            padding: 20px;
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .stat-card .stat-label {
            color: #6c757d;
            font-size: 0.85rem;
        }

        /* ── Table ── */
        .table th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
            border-bottom-width: 1px;
        }

        /* ── Responsive ── */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        @include('layouts.partials.navbar')

        <!-- Content -->
        <div class="content-wrapper">
            @include('layouts.partials.alerts')
            @yield('content')
        </div>
    </div>

    <!-- Sidebar overlay for mobile -->
    <div class="sidebar-overlay d-lg-none" onclick="document.querySelector('.sidebar').classList.remove('show')"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1035;">
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            if (toggler) {
                toggler.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
