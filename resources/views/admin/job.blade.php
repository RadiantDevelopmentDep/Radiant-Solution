<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Radiant | Career Hub Control</title>
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
            --text-dark: #1a2e32;
            --sidebar-width: 280px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-md: 0 20px 40px rgba(0,0,0,0.04);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); display: flex; color: var(--text-dark); min-height: 100vh; overflow-x: hidden; }

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
        .nav-link:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { background: var(--accent); color: var(--primary); }

        /* --- MOBILE HEADER (Left Button) --- */
        .mobile-header {
            display: none; width: 100%; background: var(--primary); padding: 15px 20px;
            position: fixed; top: 0; left: 0; z-index: 1500; align-items: center; color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .menu-trigger { background: none; border: none; color: white; font-size: 28px; cursor: pointer; margin-right: 15px; }

        /* --- MAIN CONTENT --- */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); padding: 50px; transition: var(--transition); width: 100%; }

        .header-top { margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-top h1 { font-weight: 800; font-size: 2.2rem; color: var(--primary); letter-spacing: -1px; }

        .hub-container { display: grid; grid-template-columns: 380px 1fr; gap: 40px; align-items: start; }

        /* --- CARDS & FORMS --- */
        .glass-card { background: var(--white); border-radius: 32px; padding: 35px; border: 1px solid rgba(0,0,0,0.02); box-shadow: var(--shadow-md); position: sticky; top: 40px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 10px; font-weight: 800; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase; }
        input, textarea { width: 100%; padding: 14px 18px; border-radius: 16px; border: 1px solid #eef2f2; background: #f8fafc; font-weight: 600; font-size: 14px; color: var(--primary); outline: none; }

        .btn-save { width: 100%; background: var(--primary); color: white; border: none; padding: 18px; border-radius: 18px; font-weight: 800; cursor: pointer; transition: 0.4s; }
        .btn-save:hover { background: var(--primary-dark); transform: translateY(-3px); }

        /* --- JOBS DISPLAY --- */
        .job-section-card { background: white; border-radius: 32px; margin-bottom: 20px; border: 1px solid rgba(0,0,0,0.02); overflow: hidden; box-shadow: var(--shadow-md); }
        .job-header { padding: 30px; background: #fcfdfd; display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: 0.2s; }
        
        .chevron-icon { transition: transform 0.3s ease; color: var(--accent); }
        .job-section-card.active .chevron-icon { transform: rotate(180deg); }

        .applicants-list { display: none; border-top: 1px solid #f1f5f9; background: #fff; }
        .job-section-card.active .applicants-list { display: block; }

        .applicant-row { padding: 25px 30px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f8fafc; gap: 15px; }
        .status-select { padding: 10px 14px; border-radius: 12px; font-size: 11px; font-weight: 800; border: 1px solid #e2e8f0; cursor: pointer; text-transform: uppercase; outline: none; }

        .cv-link { color: var(--primary); text-decoration: none; font-weight: 800; font-size: 11px; display: flex; align-items: center; gap: 8px; background: #f1f5f9; padding: 10px 15px; border-radius: 12px; transition: 0.3s; }
        .cv-link:hover { background: var(--accent-soft); }
        .badge-count { background: var(--accent-soft); color: var(--primary); padding: 8px 16px; border-radius: 12px; font-size: 12px; font-weight: 800; }

        /* --- SIDEBAR MASK --- */
        .sidebar-mask { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1900; backdrop-filter: blur(4px); }
        .sidebar-mask.active { display: block; }

        /* --- MEDIA QUERIES --- */
        @media (max-width: 1150px) {
            .hub-container { grid-template-columns: 1fr; }
            .glass-card { position: static; margin-bottom: 30px; }
        }

        @media (max-width: 992px) {
            .sidebar { left: -100%; }
            .sidebar.active { left: 0; }
            .main-wrapper { margin-left: 0; padding: 100px 20px 40px; }
            .mobile-header { display: flex; }
        }

        @media (max-width: 600px) {
            .header-top h1 { font-size: 1.8rem; }
            .job-header { flex-direction: column; align-items: flex-start; gap: 15px; }
            .applicant-row { flex-direction: column; align-items: flex-start; gap: 20px; }
            .applicant-row > div:last-child { width: 100%; justify-content: space-between; gap: 10px; }
            .status-select { flex: 1; font-size: 10px; }
        }
    </style>
</head>
<body>

<header class="mobile-header">
    <button class="menu-trigger" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div style="font-weight: 800; letter-spacing: 1px;">RADIANT HUB</div>
</header>

<div class="sidebar-mask" id="mask" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand"><i class="bi bi-cpu-fill"></i> RADIANT<span>SOLUTION</span></div>
    <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="{{ route('admin.inquiries.index') }}" class="nav-link"><i class="bi bi-chat-left-dots-fill"></i> Inquiries</a>
        <a href="{{ route('jobs.index') }}" class="nav-link active"><i class="bi bi-briefcase-fill"></i> Career</a>
        <a href="#" class="nav-link"><i class="bi bi-people-fill"></i> Team Management</a>
    </nav>
</aside>

<main class="main-wrapper">
    <div class="header-top">
        <div>
            <h1>Active Vacancies</h1>
            <p style="color: var(--accent); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px;">Talent Acquisition Pipeline</p>
        </div>
        <div class="badge-count">Total Openings: {{ $jobs->count() }}</div>
    </div>

    <div class="hub-container">
        <div class="glass-card">
            <div style="font-weight:800; margin-bottom:25px; color: var(--primary); display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-plus-circle-fill" style="color: var(--accent);"></i> NEW VACANCY
            </div>
            <form action="{{ route('jobs.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Position Name</label>
                    <input type="text" name="title" required placeholder="e.g. Full Stack Developer">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" required placeholder="Islamabad (Remote)">
                </div>
                <div class="form-group">
                    <label>Job Description</label>
                    <textarea name="description" rows="4" placeholder="Role requirements..."></textarea>
                </div>
                <button type="submit" class="btn-save">PUBLISH JOB</button>
            </form>
        </div>

        <div class="jobs-display">
            @forelse($jobs as $job)
            <div class="job-section-card" id="job-card-{{ $job->id }}">
                <div class="job-header" onclick="toggleApplicants('{{ $job->id }}')">
                    <div>
                        <div style="font-weight:800; font-size:1.2rem; color:var(--primary)">
                            {{ $job->title }} 
                            <i class="bi bi-chevron-down chevron-icon" style="font-size: 1rem; margin-left: 8px;"></i>
                        </div>
                        <div style="font-size:11px; color:var(--accent); font-weight:700;"><i class="bi bi-geo-alt"></i> {{ $job->location }}</div>
                    </div>
                    <div style="display:flex; gap:10px; align-items:center;" onclick="event.stopPropagation();">
                        <span class="badge-count" style="background: #f1f5f9;">{{ $job->applications->count() }} Apps</span>
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Delete this job listing?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none; background:#fee2e2; color:#ef4444; padding:8px 12px; border-radius:10px; cursor:pointer;"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </div>

                <div class="applicants-list">
                    @forelse($job->applications as $app)
                    <div class="applicant-row">
                        <div class="app-info">
                            <h4 style="font-size:14px; font-weight: 800;">{{ $app->applicant_name }}</h4>
                            <p style="font-size:11px; color:#94a3b8;"><i class="bi bi-envelope"></i> {{ $app->applicant_email }}</p>
                        </div>

                        <div style="display: flex; align-items: center; gap: 15px;">
                            <form action="{{ route('jobs.applications.updateStatus', $app->id) }}" method="POST" id="status-form-{{ $app->id }}">
                                @csrf @method('PATCH')
                                <select name="status" 
                                    onchange="handleStatusChange(this, '{{ $app->id }}', '{{ $app->applicant_name }}', '{{ $app->applicant_email }}', '{{ $job->title }}')" 
                                    class="status-select" 
                                    style="
                                        background: {{ $app->status == 'onboard' ? '#dcfce7' : ($app->status == 'rejected' ? '#fee2e2' : ($app->status == 'interview' ? '#dbeafe' : '#f8fafc')) }};
                                        color: {{ $app->status == 'onboard' ? '#16a34a' : ($app->status == 'rejected' ? '#dc2626' : ($app->status == 'interview' ? '#2563eb' : '#64748b')) }};
                                    ">
                                    <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $app->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="interview" {{ $app->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="onboard" {{ $app->status == 'onboard' ? 'selected' : '' }}>Onboard ✨</option>
                                    <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Rejected ❌</option>
                                </select>
                            </form>

                            <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="cv-link">
                                <i class="bi bi-file-earmark-pdf"></i> CV
                            </a>

                            <form action="{{ route('jobs.applications.destroy', $app->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" style="border:none; background:none; color:#cbd5e1; cursor:pointer;"><i class="bi bi-x-circle-fill"></i></button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div style="padding: 40px; text-align: center; color: #94a3b8; font-size: 13px;">No applications yet.</div>
                    @endforelse
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:80px; background: white; border-radius: 32px; color: #94a3b8;">
                No active job listings found.
            </div>
            @endforelse
        </div>
    </div>
</main>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

<script type="text/javascript">
   // EmailJS Init
   (function(){ emailjs.init("n9lqa65RPzV_vtWvK"); })();

   // Mobile Sidebar Toggle
   function toggleSidebar() {
       document.getElementById('sidebar').classList.toggle('active');
       document.getElementById('mask').classList.toggle('active');
   }

   // Accordion Logic
   function toggleApplicants(jobId) {
       const card = document.getElementById('job-card-' + jobId);
       card.classList.toggle('active');
   }

   // Email & Status Logic (No skips!)
   function handleStatusChange(selectElement, appId, appName, appEmail, jobTitle) {
       const newStatus = selectElement.value;
       const form = document.getElementById('status-form-' + appId);
       
       if (newStatus === 'onboard' || newStatus === 'rejected') {
           let subject = newStatus === 'onboard' ? `Congratulations! You're Onboarded ✨` : `Application Update - ${jobTitle}`;
           let messageBody = newStatus === 'onboard' 
                ? `Dear ${appName},\n\nWelcome to the Radiant family! You've been selected for ${jobTitle}.` 
                : `Dear ${appName},\n\nThank you for applying for ${jobTitle}. We won't be moving forward at this time.`;

           emailjs.send('service_x2os94m', 'template_a3ws7tz', {
               subject: subject,
               applicant_name: appName,
               applicant_email: appEmail,
               job_title: jobTitle,
               message_body: messageBody
           }).then(() => form.submit(), () => form.submit());
       } else {
           form.submit();
       }
   }
</script>

</body>
</html>