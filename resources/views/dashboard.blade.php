<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Radiant | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #396068;
            --primary-dark: #2a474d;
            --accent: #b4955e;
            --accent-soft: rgba(180, 149, 94, 0.1);
            --bg: #f4f7f7;
            --white: #ffffff;
            --sidebar-width: 280px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-md: 0 20px 40px rgba(0,0,0,0.04);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; min-height: 100vh; width: 100%; color: #1a2e32; overflow-x: hidden; }

        /* --- SIDEBAR --- */
        .sidebar { 
            width: var(--sidebar-width); background: var(--primary); position: fixed; 
            top: 0; left: 0; height: 100vh; padding: 40px 24px; z-index: 2000;
            transition: var(--transition);
        }
        .sidebar-brand { color: white; font-weight: 800; font-size: 1.2rem; margin-bottom: 50px; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand span { color: var(--accent); }
        
        .nav-link { 
            display: flex; align-items: center; gap: 12px; padding: 14px 18px; 
            color: rgba(255,255,255,0.6); text-decoration: none; font-weight: 600; 
            border-radius: 14px; transition: 0.3s; margin-bottom: 8px; font-size: 14px;
        }
        .nav-link:hover { color: var(--white); background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent); color: var(--primary); }

        /* --- MOBILE HEADER (Same as Inquiry Page) --- */
        .mobile-header {
            display: none; width: 100%; background: var(--primary); padding: 15px 20px;
            position: fixed; top: 0; left: 0; z-index: 1500; align-items: center; color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .menu-trigger { background: none; border: none; color: white; font-size: 28px; cursor: pointer; margin-right: 15px; }

        /* --- MAIN WRAPPER --- */
        .main-wrapper { 
            flex: 1; margin-left: var(--sidebar-width); padding: 50px; 
            width: 100%; transition: var(--transition); 
        }

        .header-top { margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-top h1 { font-weight: 800; font-size: 2.2rem; color: var(--primary); letter-spacing: -1px; }

        /* Stats Cards */
        .stats-grid { 
            display: grid; grid-template-columns: repeat(4, 1fr); 
            gap: 25px; margin-bottom: 40px; 
        }
        .stat-card { 
            background: var(--white); padding: 30px; border-radius: 32px; 
            border: 1px solid rgba(0,0,0,0.02); box-shadow: var(--shadow-md); 
            transition: var(--transition);
        }
        .stat-val { font-size: 2.2rem; font-weight: 800; color: var(--primary); display: block; margin-top: 5px; }
        .stat-label { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }

        /* Action Hub Card */
        .hub-card {
            background: var(--white); border-radius: 35px; padding: 60px 40px;
            text-align: center; border: 1px solid rgba(0,0,0,0.02);
            box-shadow: var(--shadow-md);
        }
        .btn-group { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-top: 35px; }
        .btn-action { 
            background: var(--primary); color: white; padding: 16px 35px; border-radius: 18px; 
            text-decoration: none; font-weight: 800; font-size: 14px; display: inline-flex; 
            align-items: center; gap: 10px; transition: 0.3s;
        }

        /* User Pill */
        .user-pill {
            background: var(--white); padding: 8px 8px 8px 20px; border-radius: 50px; 
            display: flex; align-items: center; gap: 12px; border: 1px solid #eef2f2;
        }
        .user-avatar { width: 35px; height: 35px; background: var(--primary); color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; }

        /* Alert Toast */
        .alert-toast {
            position: fixed; top: 30px; right: 30px; background: var(--white); 
            border-left: 5px solid #ef4444; padding: 20px; border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); display: flex; 
            align-items: center; gap: 15px; z-index: 1600;
        }

        /* Sidebar Mask */
        .sidebar-mask { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1900; }
        .sidebar-mask.active { display: block; }

        /* --- RESPONSIVE QUERIES --- */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .sidebar { left: -100%; }
            .sidebar.active { left: 0; }
            .main-wrapper { margin-left: 0; padding: 100px 20px 40px; }
            .mobile-header { display: flex; }
            .header-top h1 { font-size: 1.8rem; }
        }

        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr; }
            .hub-card { padding: 40px 20px; }
            .btn-action { width: 100%; justify-content: center; }
            .alert-toast { left: 20px; right: 20px; top: 80px; }
        }
    </style>
</head>
<body>

<header class="mobile-header">
    <button class="menu-trigger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div style="font-weight: 800; font-size: 1.1rem;">RADIANT HUB</div>
</header>

<div class="sidebar-mask" id="mask" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand"><i class="bi bi-cpu-fill"></i> RADIANT<span>SOLUTION</span></div>
    <nav>
        <a href="{{ route('dashboard') }}" class="nav-link active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="{{ route('admin.inquiries.index') }}" class="nav-link"><i class="bi bi-chat-left-dots-fill"></i> Inquiries</a>
        <a href="{{ route('jobs.index') }}" class="nav-link"><i class="bi bi-briefcase-fill"></i> Career</a>
        <a href="#" class="nav-link"><i class="bi bi-people-fill"></i> Team Management</a>
    </nav>
</aside>

<main class="main-wrapper">

    @if($stats['pending'] > 0)
    <div class="alert-toast" id="alertBox">
        <div style="background: #fee2e2; padding: 10px; border-radius: 12px; color: #ef4444;">
            <i class="bi bi-bell-fill"></i>
        </div>
        <div>
            <h4 style="margin: 0; font-size: 13px; font-weight: 800;">Attention!</h4>
            <p style="margin: 0; color: #64748b; font-size: 11px;">You have <strong>{{ $stats['pending'] }}</strong> new inquiries.</p>
        </div>
        <button onclick="this.parentElement.remove()" style="background:none; border:none; color:#cbd5e1; cursor:pointer; font-size: 24px;">&times;</button>
    </div>
    @endif

    <div class="header-top">
        <div>
            <p style="color: var(--accent); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">System Overview</p>
            <h1>Admin Dashboard</h1>
        </div>

        <div class="user-pill">
            <span style="font-weight: 700; font-size: 13px; color: var(--primary);">{{ Auth::user()->name }}</span>
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </div>

    <section class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Total Inquiries</span>
            <span class="stat-val">{{ $stats['total'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Pending Response</span>
            <span class="stat-val" style="color: #ef4444;">{{ $stats['pending'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">In Processing</span>
            <span class="stat-val">{{ $stats['working'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Success Rate</span>
            <span class="stat-val">98%</span>
        </div>
    </section>

    <div class="hub-card">
        <i class="bi bi-shield-check" style="font-size: 4rem; color: var(--accent); margin-bottom: 25px; display: block;"></i>
        <h2 style="color: var(--primary); font-size: 28px; font-weight: 800; margin-bottom: 15px;">Operational Control</h2>
        <p style="color: #94a3b8; max-width: 550px; margin: 0 auto; line-height: 1.6; font-size: 15px;">
            Manage your service flow and career opportunities from one unified interface. All system nodes are currently healthy.
        </p>
        <div class="btn-group">
            <a href="{{ route('admin.inquiries.index') }}" class="btn-action">
                View Inquiries <i class="bi bi-arrow-right"></i>
            </a>
            <a href="{{ route('jobs.index') }}" class="btn-action" style="background: var(--accent); color: var(--primary);">
                Job Portal <i class="bi bi-briefcase"></i>
            </a>
        </div>
    </div>

</main>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('mask').classList.toggle('active');
    }
</script>

</body>
</html>