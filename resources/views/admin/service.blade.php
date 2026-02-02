<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Radiant | Inquiry Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #396068;
            --accent: #b4955e;
            --bg: #f4f7f7;
            --white: #ffffff;
            --sidebar-width: 280px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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
            border-radius: 14px; margin-bottom: 8px; font-size: 14px;
        }
        .nav-link.active { background: var(--accent); color: var(--primary); }

        /* --- MOBILE HEADER --- */
        .mobile-header {
            display: none; width: 100%; background: var(--primary); padding: 15px 20px;
            position: fixed; top: 0; left: 0; z-index: 1500; align-items: center; color: white;
        }
        .menu-trigger { background: none; border: none; color: white; font-size: 28px; cursor: pointer; margin-right: 15px; }

        /* --- MAIN CONTENT --- */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); padding: 50px; transition: var(--transition); width: 100%; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .header-info h1 { font-size: 2.2rem; font-weight: 800; color: var(--primary); letter-spacing: -1px; }

        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 30px; border-radius: 28px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.01); }
        .stat-card small { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; }
        .stat-card h2 { font-size: 2.4rem; color: var(--primary); margin-top: 10px; font-weight: 800; }

        /* Toolbar */
        .toolbar-container { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; gap: 20px; flex-wrap: wrap; }
        .filter-tabs { display: flex; background: #e2e8f0; padding: 5px; border-radius: 16px; }
        .filter-tab { padding: 12px 24px; border-radius: 12px; font-size: 11px; font-weight: 800; text-decoration: none; color: #64748b; }
        .filter-tab.active { background: var(--white); color: var(--primary); box-shadow: 0 4px 15px rgba(0,0,0,0.08); }

        /* Table */
        .data-card { background: var(--white); border-radius: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.04); overflow: hidden; }
        .table-responsive { width: 100%; overflow-x: auto; }
        .custom-table { width: 100%; border-collapse: collapse; min-width: 950px; }
        .custom-table th { padding: 25px 30px; background: #fcfdfd; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; }
        .custom-table td { padding: 25px 30px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }

        .status-select { padding: 10px 18px; border-radius: 14px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; cursor: pointer; text-transform: uppercase; }

        /* --- MODAL FIX (CENTERED & HIDDEN) --- */
        .modal-overlay { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(57, 96, 104, 0.4); backdrop-filter: blur(8px); 
            display: none; /* Default hidden */
            align-items: center; justify-content: center; z-index: 3000; padding: 20px; 
        }
        .modal-card { 
            background: var(--white); width: 100%; max-width: 500px; 
            border-radius: 32px; padding: 40px; position: relative; 
            box-shadow: 0 30px 60px rgba(0,0,0,0.2);
            animation: modalPop 0.4s ease; 
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 992px) {
            .sidebar { left: -100%; }
            .sidebar.active { left: 0; }
            .main-wrapper { margin-left: 0; padding: 100px 20px 40px; }
            .mobile-header { display: flex; }
        }
        @media (max-width: 600px) { .stats-grid { grid-template-columns: 1fr; } }

        .sidebar-mask { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1900; }
        .sidebar-mask.active { display: block; }
        @keyframes modalPop { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body>

<header class="mobile-header">
    <button class="menu-trigger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div style="font-weight: 800;">RADIANT HUB</div>
</header>

<div class="sidebar-mask" id="mask" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand"><i class="bi bi-cpu-fill"></i> RADIANT<span>SOLUTION</span></div>
    <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="{{ route('admin.inquiries.index') }}" class="nav-link active"><i class="bi bi-chat-left-dots-fill"></i> Inquiries</a>
        <a href="{{ route('jobs.index') }}" class="nav-link"><i class="bi bi-briefcase-fill"></i> Career</a>
        <a href="#" class="nav-link"><i class="bi bi-people-fill"></i> Team Management</a>
    </nav>
</aside>

<main class="main-wrapper">
    <header class="page-header">
        <div class="header-info">
            <h1>Inquiry Console</h1>
            <p style="font-size: 11px; color: var(--accent); font-weight: 800; text-transform: uppercase;">Lead Tracking System</p>
        </div>
        <div style="background: white; padding: 8px 8px 8px 20px; border-radius: 50px; display: flex; align-items: center; gap: 12px; border: 1px solid #eef2f2;">
            <span style="font-weight: 700; font-size: 13px;">{{ Auth::user()->name }}</span>
            <div style="width: 35px; height: 35px; background: var(--primary); color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <div class="stats-grid">
        <div class="stat-card"><small>Total Leads</small><h2>{{ $messages->count() }}</h2></div>
        <div class="stat-card"><small>Pending</small><h2>{{ $messages->where('status', 'pending')->count() }}</h2></div>
        <div class="stat-card"><small>Working</small><h2>{{ $messages->where('status', 'in_progress')->count() }}</h2></div>
        <div class="stat-card"><small>Completed</small><h2 style="color: #16a34a;">{{ $messages->where('status', 'completed')->count() }}</h2></div>
    </div>

    <div class="toolbar-container">
        <div class="filter-tabs">
            <a href="{{ route('admin.inquiries.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">ALL</a>
            <a href="?status=pending" class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">PENDING</a>
            <a href="?status=in_progress" class="filter-tab {{ request('status') == 'in_progress' ? 'active' : '' }}">WORKING</a>
            <a href="?status=completed" class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}">COMPLETED</a>
        </div>
        <form action="{{ route('admin.inquiries.index') }}" method="GET" style="display:flex; background:white; padding:10px 18px; border-radius:15px; border: 1px solid #eef2f2;">
            <i class="bi bi-calendar3" style="color: var(--accent); margin-right: 10px;"></i>
            <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" style="border:none; outline:none; font-weight:700; font-size:12px;">
        </form>
    </div>

    <div class="data-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Timeline</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr>
                        <td>
                            <div style="font-weight: 800; font-size: 15px;">{{ $msg->name }}</div>
                            <div style="font-size: 12px; color: #94a3b8;">{{ $msg->email }}</div>
                        </td>
                        <td style="font-weight: 700; font-size: 13px;">{{ strtoupper(str_replace('-', ' ', $msg->service_slug)) }}</td>
                        <td style="font-size: 12px; color: #64748b;">{{ $msg->created_at->format('d M, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.inquiries.update-status', $msg->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="status-select"
                                    style="background: {{ $msg->status == 'completed' ? '#dcfce7' : ($msg->status == 'in_progress' ? '#dbeafe' : '#f8fafc') }};
                                           color: {{ $msg->status == 'completed' ? '#16a34a' : ($msg->status == 'in_progress' ? '#2563eb' : '#64748b') }};">
                                    <option value="pending" {{ $msg->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $msg->status == 'in_progress' ? 'selected' : '' }}>Working</option>
                                    <option value="completed" {{ $msg->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <button onclick="openModal('{{ addslashes($msg->name) }}', '{{ $msg->email }}', '{{ addslashes($msg->message) }}')" style="background:var(--primary); color:white; border:none; padding:12px 25px; border-radius:14px; cursor:pointer; font-size:11px; font-weight:800;">REVIEW</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center; padding:100px;">No leads found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal-overlay" id="detailModal">
    <div class="modal-card">
        <button style="position:absolute; top:20px; right:20px; border:none; background:#f1f5f9; width:35px; height:35px; border-radius:50%; cursor:pointer;" onclick="closeModal()"><i class="bi bi-x"></i></button>
        <h2 id="m-name" style="color: var(--primary); font-size: 22px; font-weight: 800;">---</h2>
        <p id="m-email" style="font-weight: 700; color: var(--accent); margin-bottom: 20px;">---</p>
        <div id="m-message" style="background: #f8fafc; padding: 20px; border-radius: 20px; margin: 20px 0; font-size: 14px; line-height: 1.6; border: 1px solid #eee; max-height: 250px; overflow-y: auto;">---</div>
        <a id="m-reply-btn" href="#" style="width:100%; background:var(--primary); color:white; padding:16px; border-radius:16px; font-weight:800; text-decoration:none; display:block; text-align:center;">RESPOND VIA EMAIL</a>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('mask').classList.toggle('active');
    }
    function openModal(name, email, message) {
        document.getElementById('m-name').innerText = name;
        document.getElementById('m-email').innerText = email;
        document.getElementById('m-message').innerText = message;
        document.getElementById('m-reply-btn').href = "mailto:" + email;
        document.getElementById('detailModal').style.display = 'flex';
    }
    function closeModal() { document.getElementById('detailModal').style.display = 'none'; }
    window.onclick = function(e) { if(e.target.id == 'detailModal') closeModal(); }
</script>

</body>
</html>