<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hub</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:        #0e0e11;
      --surface:   #16161a;
      --border:    #232329;
      --accent:    #c8f135;
      --accent2:   #3dffd0;
      --text:      #eeeef0;
      --muted:     #6b6b7a;
      --nav-w:     240px;
      --nav-w-col: 68px;
      --radius:    14px;
      --transition: 0.3s cubic-bezier(.4,0,.2,1);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      overflow: hidden;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: var(--nav-w);
      min-height: 100vh;
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      padding: 24px 0;
      position: fixed;
      left: 0; top: 0;
      z-index: 100;
      transition: width var(--transition);
    }

    .sidebar.collapsed { width: var(--nav-w-col); }

    /* logo */
    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0 18px 28px;
      border-bottom: 1px solid var(--border);
      margin-bottom: 16px;
      overflow: hidden;
      white-space: nowrap;
    }
    .logo-icon {
      width: 36px; height: 36px;
      background: var(--accent);
      border-radius: 10px;
      display: grid; place-items: center;
      flex-shrink: 0;
    }
    .logo-icon svg { width: 20px; height: 20px; }
    .logo-text {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.15rem;
      letter-spacing: -0.03em;
      color: var(--text);
      opacity: 1;
      transition: opacity var(--transition);
    }
    .sidebar.collapsed .logo-text { opacity: 0; pointer-events: none; }

    /* nav items */
    .nav-section { padding: 0 10px; margin-bottom: 8px; }
    .nav-label {
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      padding: 6px 8px 4px;
      white-space: nowrap;
      overflow: hidden;
      opacity: 1;
      transition: opacity var(--transition);
    }
    .sidebar.collapsed .nav-label { opacity: 0; }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 10px;
      border-radius: 10px;
      cursor: pointer;
      color: var(--muted);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      white-space: nowrap;
      overflow: hidden;
      position: relative;
      transition: background var(--transition), color var(--transition);
      user-select: none;
    }
    .nav-item:hover { background: rgba(255,255,255,.05); color: var(--text); }
    .nav-item.active { background: rgba(200,241,53,.1); color: var(--accent); }
    .nav-item.active .nav-icon { color: var(--accent); }

    .nav-icon {
      width: 36px; height: 36px;
      display: grid; place-items: center;
      border-radius: 8px;
      flex-shrink: 0;
      transition: background var(--transition);
    }
    .nav-item:hover .nav-icon { background: rgba(255,255,255,.06); }
    .nav-item.active .nav-icon { background: rgba(200,241,53,.15); }

    .nav-icon svg { width: 18px; height: 18px; }

    .nav-text {
      opacity: 1;
      transition: opacity var(--transition);
    }
    .sidebar.collapsed .nav-text { opacity: 0; }

    .badge {
      margin-left: auto;
      background: var(--accent);
      color: #0e0e11;
      font-size: 0.65rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 20px;
      flex-shrink: 0;
      transition: opacity var(--transition);
    }
    .sidebar.collapsed .badge { opacity: 0; }

    /* toggle button */
    .toggle-btn {
      margin: auto 10px 0;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 10px;
      border-radius: 10px;
      cursor: pointer;
      color: var(--muted);
      font-size: 0.9rem;
      font-weight: 500;
      border: none;
      background: none;
      width: calc(100% - 20px);
      overflow: hidden;
      white-space: nowrap;
      transition: background var(--transition), color var(--transition);
    }
    .toggle-btn:hover { background: rgba(255,255,255,.05); color: var(--text); }
    .toggle-icon {
      width: 36px; height: 36px;
      display: grid; place-items: center;
      flex-shrink: 0;
    }
    .toggle-icon svg {
      transition: transform var(--transition);
    }
    .sidebar.collapsed .toggle-icon svg { transform: rotate(180deg); }
    .toggle-text { opacity:1; transition: opacity var(--transition); }
    .sidebar.collapsed .toggle-text { opacity:0; }

    /* ── MAIN ── */
    .main {
      margin-left: var(--nav-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      transition: margin-left var(--transition);
    }
    .main.shifted { margin-left: var(--nav-w-col); }

    /* topbar */
    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 32px;
      border-bottom: 1px solid var(--border);
      background: var(--bg);
      position: sticky; top: 0; z-index: 50;
    }
    .topbar-left h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 1.4rem;
      letter-spacing: -0.02em;
    }
    .topbar-left p { font-size: 0.82rem; color: var(--muted); margin-top: 2px; }

    .topbar-right { display: flex; align-items: center; gap: 12px; }

    .search-bar {
      display: flex; align-items: center; gap: 8px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 8px 14px;
      color: var(--muted);
      font-size: 0.85rem;
      font-family: 'DM Sans', sans-serif;
      cursor: text;
      transition: border-color .2s;
    }
    .search-bar:hover { border-color: #3a3a45; }
    .search-bar input {
      background: none; border: none; outline: none;
      color: var(--text); font-size: 0.85rem;
      font-family: 'DM Sans', sans-serif;
      width: 160px;
    }
    .search-bar input::placeholder { color: var(--muted); }

    .avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
      display: grid; place-items: center;
      font-family: 'Syne', sans-serif;
      font-weight: 700; font-size: 0.8rem;
      color: #0e0e11; cursor: pointer;
      flex-shrink: 0;
    }

    .icon-btn {
      width: 36px; height: 36px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 10px;
      display: grid; place-items: center;
      cursor: pointer; color: var(--muted);
      transition: color .2s, border-color .2s;
    }
    .icon-btn:hover { color: var(--text); border-color: #3a3a45; }
    .icon-btn svg { width: 18px; height: 18px; }

    /* ── CONTENT ── */
    .content { padding: 32px; flex: 1; }

    /* stat cards */
    .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 16px; margin-bottom: 32px; }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 22px;
      position: relative;
      overflow: hidden;
      transition: border-color .2s, transform .2s;
      cursor: default;
    }
    .stat-card:hover { border-color: #3a3a45; transform: translateY(-2px); }
    .stat-card::after {
      content: '';
      position: absolute; top: 0; left: 0; right: 0;
      height: 2px;
    }
    .stat-card:nth-child(1)::after { background: var(--accent); }
    .stat-card:nth-child(2)::after { background: var(--accent2); }
    .stat-card:nth-child(3)::after { background: #ff7eb3; }
    .stat-card:nth-child(4)::after { background: #a78bfa; }

    .stat-label { font-size: 0.75rem; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 10px; }
    .stat-value {
      font-family: 'Syne', sans-serif;
      font-size: 2rem; font-weight: 800;
      letter-spacing: -0.04em;
    }
    .stat-delta { font-size: 0.78rem; margin-top: 6px; }
    .up { color: var(--accent); } .down { color: #ff7eb3; }

    /* two-col grid */
    .grid2 { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }
    @media (max-width: 900px) { .grid2 { grid-template-columns: 1fr; } }

    /* panel */
    .panel {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 22px;
    }
    .panel-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 20px;
    }
    .panel-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700; font-size: 1rem;
      letter-spacing: -0.01em;
    }
    .panel-action { font-size: 0.78rem; color: var(--accent); cursor: pointer; }
    .panel-action:hover { text-decoration: underline; }

    /* activity list */
    .activity-item {
      display: flex; align-items: flex-start; gap: 12px;
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
      width: 8px; height: 8px; border-radius: 50%;
      margin-top: 5px; flex-shrink: 0;
    }
    .activity-body { flex: 1; }
    .activity-body strong { font-size: 0.85rem; font-weight: 500; }
    .activity-body p { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }
    .activity-time { font-size: 0.72rem; color: var(--muted); white-space: nowrap; }

    /* quick actions */
    .actions-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .action-btn {
      background: rgba(255,255,255,.03);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 14px;
      display: flex; flex-direction: column; align-items: flex-start; gap: 8px;
      cursor: pointer;
      transition: background .2s, border-color .2s;
    }
    .action-btn:hover { background: rgba(255,255,255,.07); border-color: #3a3a45; }
    .action-btn svg { width: 20px; height: 20px; }
    .action-btn span { font-size: 0.78rem; color: var(--muted); font-weight: 500; }

    /* bar chart */
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 80px; margin-top: 16px; }
    .bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; height: 100%; justify-content: flex-end; }
    .bar {
      width: 100%; border-radius: 4px 4px 0 0;
      transition: opacity .2s;
    }
    .bar:hover { opacity: .8; }
    .bar-label { font-size: 0.65rem; color: var(--muted); }

    /* table */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
      text-align: left; font-size: 0.7rem; font-weight: 600;
      text-transform: uppercase; letter-spacing: .08em;
      color: var(--muted); padding: 0 12px 12px;
    }
    tbody tr { border-top: 1px solid var(--border); transition: background .15s; }
    tbody tr:hover { background: rgba(255,255,255,.025); }
    tbody td { padding: 12px; font-size: 0.85rem; }
    .chip {
      display: inline-block; padding: 3px 10px;
      border-radius: 20px; font-size: 0.72rem; font-weight: 600;
    }
    .chip-green { background: rgba(200,241,53,.15); color: var(--accent); }
    .chip-blue  { background: rgba(61,255,208,.12); color: var(--accent2); }
    .chip-red   { background: rgba(255,126,179,.12); color: #ff7eb3; }

    /* page-switch animation */
    .page { display: none; animation: fadeIn .25s ease; }
    .page.active { display: block; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
  </style>
</head>
<body>

<!-- ══════════ SIDEBAR ══════════ -->
<nav class="sidebar" id="sidebar">

  <div class="logo">
    <div class="logo-icon">
      <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 10L10 3L17 10V17H13V13H7V17H3V10Z" fill="#0e0e11"/>
      </svg>
    </div>
    <span class="logo-text">NexHub</span>
  </div>

  <div class="nav-section">
    <div class="nav-label">Principal</div>

    <a class="nav-item active" href="#" data-page="dashboard">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
      </span>
      <span class="nav-text">Dashboard</span>
    </a>

    <a class="nav-item" href="#" data-page="analytics">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
      </span>
      <span class="nav-text">Analytics</span>
    </a>

    <a class="nav-item" href="#" data-page="projetos">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
      </span>
      <span class="nav-text">Projetos</span>
      <span class="badge">3</span>
    </a>

    <a class="nav-item" href="#" data-page="tarefas">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="9 11 12 14 22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
      </span>
      <span class="nav-text">Tarefas</span>
    </a>
  </div>

  <div class="nav-section">
    <div class="nav-label">Gestão</div>

    <a class="nav-item" href="#" data-page="equipe">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
      </span>
      <span class="nav-text">Equipe</span>
    </a>

    <a class="nav-item" href="#" data-page="mensagens">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
      </span>
      <span class="nav-text">Mensagens</span>
      <span class="badge">9</span>
    </a>

    <a class="nav-item" href="#" data-page="arquivos">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
        </svg>
      </span>
      <span class="nav-text">Arquivos</span>
    </a>
  </div>

  <div class="nav-section" style="margin-top:auto; margin-bottom: 8px;">
    <a class="nav-item" href="#" data-page="configuracoes">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="3"/>
          <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
      </span>
      <span class="nav-text">Configurações</span>
    </a>
  </div>

  <button class="toggle-btn" id="toggleBtn">
    <span class="toggle-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
    </span>
    <span class="toggle-text">Recolher</span>
  </button>
</nav>

<!-- ══════════ MAIN ══════════ -->
<div class="main" id="main">

  <!-- Topbar -->
  <header class="topbar">
    <div class="topbar-left">
      <h1 id="pageTitle">Dashboard</h1>
      <p id="pageSubtitle">Bem-vindo de volta, Ana ✦</p>
    </div>
    <div class="topbar-right">
      <div class="search-bar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" placeholder="Buscar…">
      </div>
      <div class="icon-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
      </div>
      <div class="avatar">AN</div>
    </div>
  </header>

  <!-- Pages -->
  <div class="content">

    <!-- Dashboard -->
    <div class="page active" id="page-dashboard">
      <div class="stats">
        <div class="stat-card">
          <div class="stat-label">Receita Total</div>
          <div class="stat-value">R$48,2k</div>
          <div class="stat-delta up">↑ 12,4% este mês</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Usuários Ativos</div>
          <div class="stat-value">3.841</div>
          <div class="stat-delta up">↑ 8,1% este mês</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Tarefas Abertas</div>
          <div class="stat-value">27</div>
          <div class="stat-delta down">↑ 3 desde ontem</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Taxa de Conclusão</div>
          <div class="stat-value">91%</div>
          <div class="stat-delta up">↑ 2% este mês</div>
        </div>
      </div>

      <div class="grid2">
        <div>
          <!-- Atividade recente -->
          <div class="panel" style="margin-bottom:20px;">
            <div class="panel-header">
              <span class="panel-title">Atividade Recente</span>
              <span class="panel-action">Ver tudo</span>
            </div>
            <div class="activity-item">
              <div class="activity-dot" style="background:var(--accent)"></div>
              <div class="activity-body">
                <strong>Deploy realizado com sucesso</strong>
                <p>Projeto Alpha · v2.4.1 em produção</p>
              </div>
              <div class="activity-time">2 min</div>
            </div>
            <div class="activity-item">
              <div class="activity-dot" style="background:var(--accent2)"></div>
              <div class="activity-body">
                <strong>Lucas comentou em #design</strong>
                <p>"Aprovado! Podemos avançar para dev."</p>
              </div>
              <div class="activity-time">18 min</div>
            </div>
            <div class="activity-item">
              <div class="activity-dot" style="background:#ff7eb3"></div>
              <div class="activity-body">
                <strong>Bug crítico reportado</strong>
                <p>Login OAuth falhou em Safari 17</p>
              </div>
              <div class="activity-time">1h</div>
            </div>
            <div class="activity-item">
              <div class="activity-dot" style="background:#a78bfa"></div>
              <div class="activity-body">
                <strong>Novo membro adicionado</strong>
                <p>Carla Mendes entrou no time de Design</p>
              </div>
              <div class="activity-time">3h</div>
            </div>
          </div>

          <!-- Tabela -->
          <div class="panel">
            <div class="panel-header">
              <span class="panel-title">Projetos Ativos</span>
              <span class="panel-action">Novo projeto</span>
            </div>
            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Projeto</th>
                    <th>Responsável</th>
                    <th>Prazo</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Redesign App</td>
                    <td>Ana Lima</td>
                    <td>12 Mai</td>
                    <td><span class="chip chip-green">Em dia</span></td>
                  </tr>
                  <tr>
                    <td>API v3</td>
                    <td>Bruno Costa</td>
                    <td>28 Mai</td>
                    <td><span class="chip chip-blue">Em andamento</span></td>
                  </tr>
                  <tr>
                    <td>Campanha Q2</td>
                    <td>Carla Dias</td>
                    <td>05 Mai</td>
                    <td><span class="chip chip-red">Atrasado</span></td>
                  </tr>
                  <tr>
                    <td>Dashboard BI</td>
                    <td>Diego Nunes</td>
                    <td>20 Jun</td>
                    <td><span class="chip chip-green">Em dia</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Sidebar direita -->
        <div>
          <div class="panel" style="margin-bottom:20px;">
            <div class="panel-header">
              <span class="panel-title">Ações Rápidas</span>
            </div>
            <div class="actions-grid">
              <div class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                <span>Nova Tarefa</span>
              </div>
              <div class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent2)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                  <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <span>Enviar Arquivo</span>
              </div>
              <div class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="#ff7eb3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                  <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                  <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span>Agendar</span>
              </div>
              <div class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                  <circle cx="9" cy="7" r="4"/>
                  <line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/>
                </svg>
                <span>Convidar</span>
              </div>
            </div>
          </div>

          <div class="panel">
            <div class="panel-header">
              <span class="panel-title">Performance Semanal</span>
            </div>
            <div class="bar-chart">
              <div class="bar-wrap">
                <div class="bar" style="height:45%;background:rgba(200,241,53,.3)"></div>
                <div class="bar-label">S</div>
              </div>
              <div class="bar-wrap">
                <div class="bar" style="height:70%;background:var(--accent)"></div>
                <div class="bar-label">T</div>
              </div>
              <div class="bar-wrap">
                <div class="bar" style="height:55%;background:rgba(200,241,53,.3)"></div>
                <div class="bar-label">Q</div>
              </div>
              <div class="bar-wrap">
                <div class="bar" style="height:90%;background:var(--accent)"></div>
                <div class="bar-label">Q</div>
              </div>
              <div class="bar-wrap">
                <div class="bar" style="height:65%;background:rgba(200,241,53,.3)"></div>
                <div class="bar-label">S</div>
              </div>
              <div class="bar-wrap">
                <div class="bar" style="height:30%;background:rgba(200,241,53,.2)"></div>
                <div class="bar-label">S</div>
              </div>
              <div class="bar-wrap">
                <div class="bar" style="height:15%;background:rgba(200,241,53,.15)"></div>
                <div class="bar-label">D</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Outras páginas (placeholder) -->
    <div class="page" id="page-analytics">
      <div class="panel"><div class="panel-header"><span class="panel-title">Analytics</span></div><p style="color:var(--muted);font-size:.9rem">Métricas detalhadas aparecerão aqui.</p></div>
    </div>
    <div class="page" id="page-projetos">
      <div class="panel"><div class="panel-header"><span class="panel-title">Projetos</span></div><p style="color:var(--muted);font-size:.9rem">Gerencie seus projetos aqui.</p></div>
    </div>
    <div class="page" id="page-tarefas">
      <div class="panel"><div class="panel-header"><span class="panel-title">Tarefas</span></div><p style="color:var(--muted);font-size:.9rem">Suas tarefas aparecerão aqui.</p></div>
    </div>
    <div class="page" id="page-equipe">
      <div class="panel"><div class="panel-header"><span class="panel-title">Equipe</span></div><p style="color:var(--muted);font-size:.9rem">Membros da equipe aparecerão aqui.</p></div>
    </div>
    <div class="page" id="page-mensagens">
      <div class="panel"><div class="panel-header"><span class="panel-title">Mensagens</span></div><p style="color:var(--muted);font-size:.9rem">Suas mensagens aparecerão aqui.</p></div>
    </div>
    <div class="page" id="page-arquivos">
      <div class="panel"><div class="panel-header"><span class="panel-title">Arquivos</span></div><p style="color:var(--muted);font-size:.9rem">Seus arquivos aparecerão aqui.</p></div>
    </div>
    <div class="page" id="page-configuracoes">
      <div class="panel"><div class="panel-header"><span class="panel-title">Configurações</span></div><p style="color:var(--muted);font-size:.9rem">Preferências da conta aparecerão aqui.</p></div>
    </div>

  </div><!-- /content -->
</div><!-- /main -->

<script>
  const sidebar  = document.getElementById('sidebar');
  const main     = document.getElementById('main');
  const toggleBtn= document.getElementById('toggleBtn');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    main.classList.toggle('shifted');
  });

  const titles = {
    dashboard:     ['Dashboard',    'Bem-vindo de volta, Ana ✦'],
    analytics:     ['Analytics',    'Visão geral de métricas'],
    projetos:      ['Projetos',     'Gerencie seus projetos'],
    tarefas:       ['Tarefas',      'Suas tarefas pendentes'],
    equipe:        ['Equipe',       'Membros e permissões'],
    mensagens:     ['Mensagens',    '9 mensagens não lidas'],
    arquivos:      ['Arquivos',     'Todos os arquivos'],
    configuracoes: ['Configurações','Preferências da conta'],
  };

  document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', e => {
      e.preventDefault();
      const page = item.dataset.page;

      document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
      item.classList.add('active');

      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      document.getElementById('page-' + page).classList.add('active');

      const [title, sub] = titles[page] || [page, ''];
      document.getElementById('pageTitle').textContent = title;
      document.getElementById('pageSubtitle').textContent = sub;
    });
  });
</script>
</body>
</html>