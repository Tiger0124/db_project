<?php
// Start session and handle dark mode toggle
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_GET['toggle_dm'])) {
    $_SESSION['darkmode'] = !($_SESSION['darkmode'] ?? false);
    header('Location: ' . preg_replace('/[?&]toggle_dm(=1)?/i', '', $_SERVER['REQUEST_URI']));
    exit;
}

// Inject necessary elements if dark mode is active
if ($_SESSION['darkmode'] ?? false): ?>
    <style>
        /* ===== Enhanced Dark Mode ===== */
        body {
            background: #121826 !important;
            color: #e0e4ec !important;
        }

        main#content {
            background: linear-gradient(135deg, #0d1525 0%, #1a2439 100%) !important;
        }

        .rounded-box {
            background: linear-gradient(135deg, #1e3a5f 0%, #2a4d7a 100%) !important;
            box-shadow: 0 15px 40px rgba(30, 58, 95, 0.4) !important;
        }

        table {
            background: #1a2439 !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
        }

        thead th {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
        }

        tbody td {
            color: #d0d8e8 !important;
            border-color: #2a3a55 !important;
        }

        tbody tr:hover {
            background-color: #222e45 !important;
        }

        .system-button {
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 25px rgba(30, 58, 95, 0.4) !important;
        }

        a[download] {
            background: linear-gradient(135deg, #3a6ea5 0%, #2a4d7a 100%) !important;
            box-shadow: 0 6px 20px rgba(42, 77, 122, 0.5) !important;
        }

        /* ===== Toggle Button - Light Mode Style ===== */
        .darkmode-btn {
            margin-left: auto;
            padding: 10px 20px !important;
            background: linear-gradient(135deg, #FFD700 0%, #f5be11 100%) !important;
            color: #2c3e50 !important;
            border: none !important;
            border-radius: 50px !important;
            cursor: pointer !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            box-shadow: 0 4px 15px rgba(245, 190, 17, 0.4) !important;
            transition: all 0.3s ease !important;
            text-align: center;
        }

        .darkmode-btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 20px rgba(245, 190, 17, 0.6) !important;
        }
    </style>
    <script>
        // Add toggle button and dark mode class
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('dark-mode');
            const navbar = document.querySelector('.navbar');
            if (navbar && !document.querySelector('.darkmode-btn')) {
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'darkmode-btn';
                toggleBtn.innerHTML = '☀️ 切換亮色模式';
                toggleBtn.onclick = () => window.location.href = '?toggle_dm=1';
                navbar.appendChild(toggleBtn);
            }
        });
    </script>
<?php else: ?>
    <style>
        /* ===== Toggle Button - Dark Mode Style ===== */
        .darkmode-btn {
            margin-left: auto;
            padding: 10px 20px !important;
            background: linear-gradient(135deg, #2a4d7a 0%, #1e3a5f 100%) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 50px !important;
            cursor: pointer !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            box-shadow: 0 4px 15px rgba(30, 58, 95, 0.4) !important;
            transition: all 0.3s ease !important;
            text-align: center;
        }

        .darkmode-btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.6) !important;
        }
    </style>
    <script>
        // Just add toggle button
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            if (navbar && !document.querySelector('.darkmode-btn')) {
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'darkmode-btn';
                toggleBtn.innerHTML = '🌙 切換暗色模式';
                toggleBtn.onclick = () => window.location.href = '?toggle_dm=1';
                navbar.appendChild(toggleBtn);
            }
        });
    </script>
<?php endif; ?>