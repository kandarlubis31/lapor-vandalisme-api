<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Admin Panel') }} - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Variabel CSS untuk konsistensi warna */
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --success-color: #10b981;
            --success-hover: #059669;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Reset dan dasar */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
        }

        /* Header */
        .header {
            background-color: white;
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header h1 {
            color: var(--gray-900);
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .header h1 i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        /* Navigasi */
        .header nav {
            display: flex;
            gap: 1.5rem;
        }

        .header nav a {
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .header nav a:hover {
            color: var(--primary-color);
            background-color: var(--gray-100);
        }

        /* Tombol Logout */
        .btn-logout {
            background-color: var(--gray-600);
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: var(--gray-700);
        }

        .btn-logout i {
            margin-right: 0.5rem;
        }

        /* Konten Utama */
        .main-content {
            padding: 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Tabel */
        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        tr:hover {
            background-color: var(--gray-50);
        }

        /* Gambar */
        img {
            max-width: 150px;
            height: auto;
            border-radius: 0.375rem;
            box-shadow: var(--shadow-sm);
        }

        /* Aksi */
        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .actions button {
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .actions button i {
            margin-right: 0.375rem;
        }

        .btn-validate {
            background-color: var(--success-color);
            color: white;
        }

        .btn-validate:hover {
            background-color: var(--success-hover);
        }

        .btn-reject {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-reject:hover {
            background-color: var(--danger-hover);
        }

        /* Status Processing */
        tr.processing {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        tr.processing::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            
            .header nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 600px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-tachometer-alt"></i> {{ config('app.name', 'Admin Panel') }}</h1>
        <nav>
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-chart-line"></i> Dashboard Laporan
            </a> 
            <a href="{{ route('users.index') }}">
                <i class="fas fa-users"></i> Manajemen User
            </a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
    
    <div class="main-content">
        @yield('content')
    </div>
    
    @stack('scripts')
    
    <script>
        // Fungsi untuk menangani form submission dengan loading state
        document.addEventListener('DOMContentLoaded', function() {
            const actionButtons = document.querySelectorAll('.actions button');
            
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    if (form) {
                        const row = this.closest('tr');
                        row.classList.add('processing');
                        
                        // Tambahkan spinner ke tombol
                        const originalContent = this.innerHTML;
                        this.innerHTML = '<span class="spinner"></span> Processing...';
                        this.disabled = true;
                        
                        // Jika form tidak disubmit secara otomatis, submit manual
                        if (!form.hasAttribute('data-auto-submit')) {
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>