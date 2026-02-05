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
        }
        .sidebar-brand { color: white; font-weight: 800; font-size: 1.2rem; margin-bottom: 50px; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand span { color: var(--accent); }
        .nav-link { 
            display: flex; align-items: center; gap: 12px; padding: 14px 18px; 
            color: rgba(255,255,255,0.6); text-decoration: none; font-weight: 600; 
            border-radius: 14px; margin-bottom: 8px; font-size: 14px;
        }
        .nav-link.active { background: var(--accent); color: var(--primary); }

        /* --- MAIN CONTENT --- */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); padding: 50px; width: 100%; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .header-info h1 { font-size: 2.2rem; font-weight: 800; color: var(--primary); letter-spacing: -1px; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 30px; border-radius: 28px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); text-align: center; }
        .stat-card small { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; }
        .stat-card h2 { font-size: 2.4rem; color: var(--primary); margin-top: 10px; font-weight: 800; }

        /* Tabs Styling */
        .tab-nav { display: flex; gap: 10px; margin-bottom: 25px; background: #e2e8f0; padding: 5px; border-radius: 18px; width: fit-content; }
        .tab-btn { padding: 12px 24px; border-radius: 14px; border: none; font-weight: 800; font-size: 11px; cursor: pointer; color: #64748b; background: transparent; transition: 0.3s; }
        .tab-btn.active { background: white; color: var(--primary); box-shadow: 0 4px 15px rgba(0,0,0,0.05); }

        /* Table */
        .data-card { background: var(--white); border-radius: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.04); overflow: hidden; display: none; }
        .data-card.active { display: block; }
        .custom-table { width: 100%; border-collapse: collapse; }
        .custom-table th { padding: 25px 30px; background: #fcfdfd; text-align: left; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; }
        .custom-table td { padding: 25px 30px; border-bottom: 1px solid #f8fafc; font-size: 14px; }

        .status-select { padding: 8px 15px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; cursor: pointer; }
        .badge-mix { font-size: 10px; background: #f1f5f9; padding: 4px 8px; border-radius: 6px; margin-right: 4px; color: var(--primary); font-weight: 700; }

        /* Modal */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(57, 96, 104, 0.4); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; z-index: 3000; }
        .modal-card { background: white; width: 100%; max-width: 500px; border-radius: 32px; padding: 40px; position: relative; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand"><i class="bi bi-cpu-fill"></i> RADIANT<span>SOLUTION</span></div>
    <nav>
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="{{ route('admin.inquiries.index') }}" class="nav-link active"><i class="bi bi-chat-left-dots-fill"></i> Inquiries</a>
        <a href="{{ route('jobs.index') }}" class="nav-link"><i class="bi bi-briefcase-fill"></i> Career</a>
    </nav>
</aside>

<main class="main-wrapper">
    <header class="page-header">
        <div class="header-info">
            <h1>Inquiry Console</h1>
            <p style="font-size: 11px; color: var(--accent); font-weight: 800; text-transform: uppercase;">Lead Management</p>
        </div>
    </header>

    <div class="stats-grid">
        <div class="stat-card"><small>Gross Leads</small><h2>{{ $stats['total'] }}</h2></div>
        <div class="stat-card"><small>Pending</small><h2>{{ $stats['pending'] }}</h2></div>
        <div class="stat-card"><small>Working</small><h2>{{ $stats['working'] }}</h2></div>
        <div class="stat-card"><small>Completed</small><h2 style="color: #16a34a;">{{ $stats['completed'] }}</h2></div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div class="tab-nav">
            <button class="tab-btn active" onclick="showTab('services', this)">SERVICES</button>
            <button class="tab-btn" onclick="showTab('multi', this)">MULTI-SERVICE</button>
            <button class="tab-btn" onclick="showTab('contact', this)">CONTACT US</button>
        </div>
        
        <div style="display: flex; gap: 10px; background: white; padding: 5px; border-radius: 15px;">
            <a href="{{ route('admin.inquiries.index') }}" style="text-decoration:none; font-size:11px; font-weight:800; padding:8px 15px; color:{{ !request('status') ? 'var(--accent)' : '#94a3b8' }}">ALL</a>
            <a href="?status=pending" style="text-decoration:none; font-size:11px; font-weight:800; padding:8px 15px; color:{{ request('status')=='pending' ? 'var(--accent)' : '#94a3b8' }}">PENDING</a>
            <a href="?status=in_progress" style="text-decoration:none; font-size:11px; font-weight:800; padding:8px 15px; color:{{ request('status')=='in_progress' ? 'var(--accent)' : '#94a3b8' }}">WORKING</a>
            <a href="?status=completed" style="text-decoration:none; font-size:11px; font-weight:800; padding:8px 15px; color:{{ request('status')=='completed' ? 'var(--accent)' : '#94a3b8' }}">COMPLETED</a>
        </div>
    </div>

    <div id="services" class="data-card active">
        <table class="custom-table">
            <thead>
                <tr><th>Client</th><th>Target Service</th><th>Status</th><th style="text-align:right">Action</th></tr>
            </thead>
            <tbody>
                @forelse($serviceInquiries as $msg)
                <tr>
                    <td><b>{{ $msg->name }}</b><br><small style="color:#94a3b8">{{ $msg->email }}</small></td>
                    <td><span class="badge-mix">{{ strtoupper(str_replace('-', ' ', $msg->service_slug)) }}</span></td>
                    <td>
                        <form action="{{ route('admin.inquiries.update-status', $msg->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="status-select">
                                <option value="pending" {{ $msg->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $msg->status == 'in_progress' ? 'selected' : '' }}>Working</option>
                                <option value="completed" {{ $msg->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td style="text-align:right"><button onclick="openModal('{{ addslashes($msg->name) }}', '{{ $msg->email }}', '{{ addslashes($msg->message) }}')" style="background:var(--primary); color:white; border:none; padding:10px 20px; border-radius:12px; cursor:pointer; font-weight:800; font-size:11px;">REVIEW</button></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:50px">No service inquiries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="multi" class="data-card">
        <table class="custom-table">
            <thead>
                <tr><th>Client</th><th>Selected Mix</th><th>Status</th><th style="text-align:right">Action</th></tr>
            </thead>
            <tbody>
                @forelse($multiMessages as $multi)
                <tr>
                    <td><b>{{ $multi->name }}</b><br><small style="color:#94a3b8">{{ $multi->email }}</small></td>
                    <td>
                        @if(is_array($multi->services))
                            @foreach($multi->services as $s) <span class="badge-mix">{{ strtoupper($s) }}</span> @endforeach
                        @elseif(is_string($multi->services))
                             <span class="badge-mix">{{ strtoupper($multi->services) }}</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.multi-inquiries.update-status', $multi->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="status-select">
                                <option value="pending" {{ $multi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="working" {{ $multi->status == 'working' ? 'selected' : '' }}>Working</option>
                                <option value="finished" {{ $multi->status == 'finished' ? 'selected' : '' }}>Finished</option>
                            </select>
                        </form>
                    </td>
                    <td style="text-align:right"><button onclick="openModal('{{ addslashes($multi->name) }}', '{{ $multi->email }}', '{{ addslashes($multi->message) }}')" style="background:var(--primary); color:white; border:none; padding:10px 20px; border-radius:12px; cursor:pointer; font-weight:800; font-size:11px;">REVIEW</button></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:50px">No multi-service leads found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="contact" class="data-card">
        <table class="custom-table">
            <thead>
                <tr><th>Client</th><th>Topic</th><th>Status</th><th style="text-align:right">Action</th></tr>
            </thead>
            <tbody>
                @forelse($contactInquiries as $con)
                <tr>
                    <td><b>{{ $con->name }}</b><br><small style="color:#94a3b8">{{ $con->email }}</small></td>
                    <td><span class="badge-mix">SUPPORT / CONTACT</span></td>
                    <td>
                        <form action="{{ route('admin.inquiries.update-status', $con->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="status-select">
                                <option value="pending" {{ $con->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $con->status == 'in_progress' ? 'selected' : '' }}>Working</option>
                                <option value="completed" {{ $con->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td style="text-align:right"><button onclick="openModal('{{ addslashes($con->name) }}', '{{ $con->email }}', '{{ addslashes($con->message) }}')" style="background:var(--primary); color:white; border:none; padding:10px 20px; border-radius:12px; cursor:pointer; font-weight:800; font-size:11px;">REVIEW</button></td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:50px">No contact messages.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<div class="modal-overlay" id="detailModal">
    <div class="modal-card">
        <h2 id="m-name" style="color: var(--primary); font-weight: 800;">---</h2>
        <p id="m-email" style="font-weight: 700; color: var(--accent); margin-bottom: 20px;">---</p>
        <div id="m-message" style="background: #f8fafc; padding: 20px; border-radius: 20px; font-size: 14px; line-height: 1.6; border: 1px solid #eee; margin-bottom: 20px; max-height: 300px; overflow-y: auto;">---</div>
        <button onclick="closeModal()" style="width:100%; background:var(--primary); color:white; padding:15px; border-radius:15px; border:none; font-weight:800; cursor:pointer;">CLOSE BRIEF</button>
    </div>
</div>

<script>
    // Tab Switching Logic
    function showTab(tabId, btn) {
        document.querySelectorAll('.data-card').forEach(card => card.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

    // Modal Logic
    function openModal(name, email, message) {
        document.getElementById('m-name').innerText = name;
        document.getElementById('m-email').innerText = email;
        document.getElementById('m-message').innerText = message;
        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeModal() { document.getElementById('detailModal').style.display = 'none'; }
    
    // Close modal on outside click
    window.onclick = function(e) { if(e.target.id == 'detailModal') closeModal(); }
</script>

</body>
</html>