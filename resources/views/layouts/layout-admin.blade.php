<!DOCTYPE html>
<html lang="ru">
<head>
  @vite(["resources/css/style.css"])
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scissors — Панель администратора</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="icon" href="{{ asset("static_images/Scissors_ICO.png") }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --charcoal: #1a1a1a; --charcoal-soft: #2d2d2d; --cream: #f5f0e8;
      --cream-light: #faf8f4; --gold: #c9a84c; --gold-light: #e2c97e;
      --gold-pale: #f0e6cc; --warm-gray: #8a8279; --text: #1a1a1a;
      --text-muted: #6b6560; --white: #ffffff; --border: #e4ddd2;
      --success: #4a7c59; --error: #c0392b;
      --font-display: 'Playfair Display', Georgia, serif;
      --font-body: 'DM Sans', system-ui, sans-serif;
      --radius: 4px; --radius-lg: 12px;
      --shadow: 0 4px 24px rgba(26,26,26,0.08);
      --shadow-lg: 0 12px 48px rgba(26,26,26,0.14);
      --transition: 0.25s ease;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { font-size: 16px; }
    body { font-family: var(--font-body); color: var(--text); background: #f0ece4; min-height: 100vh; display: flex; }
    a { color: inherit; text-decoration: none; }
    input, button, select, textarea { font-family: var(--font-body); font-size: 1rem; outline: none; border: none; background: none; }

    .adm-sidebar {
      width: 240px; min-height: 100vh; background: var(--charcoal);
      display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100;
    }
    .adm-logo {
      padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.07);
      display: flex; align-items: center; gap: 10px;
    }
    .adm-logo__icon { font-size: 1.4rem; }
    .adm-logo__text { font-family: var(--font-display); color: var(--white); font-size: 1.15rem; font-weight: 700; }
    .adm-logo__badge { font-size: 0.65rem; background: var(--gold); color: var(--charcoal); padding: 2px 6px; border-radius: 3px; font-weight: 700; letter-spacing: 0.05em; margin-left: auto; }

    .adm-nav { flex: 1; padding: 12px 0; }
    .adm-nav__section { padding: 16px 16px 6px; font-size: 0.65rem; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(255,255,255,0.3); }
    .adm-nav__link {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px; color: rgba(255,255,255,0.65); font-size: 0.88rem;
      transition: all var(--transition); border-left: 3px solid transparent;
    }
    .adm-nav__link:hover { background: rgba(255,255,255,0.05); color: var(--white); }
    .adm-nav__link.active { background: rgba(201,168,76,0.12); color: var(--gold); border-left-color: var(--gold); }
    .adm-nav__icon { font-size: 1rem; width: 20px; text-align: center; }

    .adm-sidebar__footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.07); }
    .adm-sidebar__back {
      display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.5);
      font-size: 0.82rem; transition: color var(--transition);
    }
    .adm-sidebar__back:hover { color: var(--white); }

      
    .adm-main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    .adm-topbar {
      background: var(--white); border-bottom: 1px solid var(--border);
      padding: 0 32px; height: 64px; display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }
    .adm-topbar__title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; }
    .adm-topbar__user { display: flex; align-items: center; gap: 12px; color: var(--text-muted); font-size: 0.88rem; }

    .adm-content { padding: 32px; flex: 1; }

      
    .adm-alert {
      padding: 14px 18px; border-radius: var(--radius); margin-bottom: 20px;
      font-size: 0.9rem; display: flex; align-items: center; gap: 10px;
    }
    .adm-alert--success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .adm-alert--error   { background: #fdecea; color: #c62828; border: 1px solid #ef9a9a; }

      
    .adm-card { background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; margin-bottom: 24px; }
    .adm-card__head { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .adm-card__title { font-family: var(--font-display); font-size: 1rem; font-weight: 700; }
    .adm-card__body { padding: 24px; }

    .adm-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
    .adm-table th { text-align: left; padding: 10px 14px; background: #f7f4ef; color: var(--text-muted); font-weight: 600; font-size: 0.75rem; letter-spacing: 0.06em; text-transform: uppercase; border-bottom: 1px solid var(--border); }
    .adm-table td { padding: 12px 14px; border-bottom: 1px solid #f0ece4; vertical-align: middle; }
    .adm-table tr:last-child td { border-bottom: none; }
    .adm-table tr:hover td { background: #faf8f4; }

   
    .adm-form { display: flex; flex-direction: column; gap: 14px; }
    .adm-form__row { display: grid; gap: 14px; }
    .adm-form__row--2 { grid-template-columns: 1fr 1fr; }
    .adm-form__row--3 { grid-template-columns: 1fr 1fr 1fr; }
    .adm-field { display: flex; flex-direction: column; gap: 5px; }
    .adm-field label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); letter-spacing: 0.04em; text-transform: uppercase; }
    .adm-field input, .adm-field select, .adm-field textarea {
      padding: 10px 13px; border: 1.5px solid var(--border); border-radius: var(--radius);
      font-size: 0.9rem; transition: border-color var(--transition); background: var(--cream-light);
    }
    .adm-field input:focus, .adm-field select:focus, .adm-field textarea:focus { border-color: var(--gold); background: var(--white); }
    .adm-field textarea { min-height: 90px; resize: vertical; }


    .btn-adm {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 9px 18px; border-radius: var(--radius); font-size: 0.85rem; font-weight: 500;
      cursor: pointer; transition: all var(--transition); border: 1.5px solid transparent;
    }
    .btn-adm--primary { background: var(--charcoal); color: var(--white); }
    .btn-adm--primary:hover { background: var(--charcoal-soft); }
    .btn-adm--gold { background: var(--gold); color: var(--charcoal); }
    .btn-adm--gold:hover { background: var(--gold-light); }
    .btn-adm--danger { background: #fdecea; color: var(--error); border-color: #ef9a9a; }
    .btn-adm--danger:hover { background: var(--error); color: var(--white); }
    .btn-adm--ghost { background: transparent; color: var(--text-muted); border-color: var(--border); }
    .btn-adm--ghost:hover { background: var(--cream); color: var(--text); }
    .btn-adm--sm { padding: 6px 12px; font-size: 0.78rem; }
    .btn-adm--success { background: #e8f5e9; color: #2e7d32; border-color: #a5d6a7; }
    .btn-adm--success:hover { background: #2e7d32; color: var(--white); }

    
    .badge-adm { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-adm--user    { background: #e3f2fd; color: #1565c0; }
    .badge-adm--master  { background: var(--gold-pale); color: #7d5c00; }
    .badge-adm--admin   { background: #f3e5f5; color: #6a1b9a; }
    .badge-adm--pending  { background: #fff3e0; color: #e65100; }
    .badge-adm--approved { background: #e8f5e9; color: #2e7d32; }
    .badge-adm--confirmed { background: #e8f5e9; color: #2e7d32; }
    .badge-adm--cancelled { background: #fdecea; color: #c62828; }
    .badge-adm--waiting   { background: #fff3e0; color: #e65100; }

  
    .adm-filters { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .adm-filter-btn { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; border: 1.5px solid var(--border); color: var(--text-muted); cursor: pointer; transition: all var(--transition); background: var(--white); }
    .adm-filter-btn.active, .adm-filter-btn:hover { border-color: var(--gold); color: var(--charcoal); background: var(--gold-pale); }

   
    .adm-search { display: flex; align-items: center; gap: 0; }
    .adm-search input { padding: 8px 14px; border: 1.5px solid var(--border); border-right: none; border-radius: var(--radius) 0 0 var(--radius); font-size: 0.88rem; background: var(--cream-light); }
    .adm-search input:focus { border-color: var(--gold); outline: none; }
    .adm-search button { padding: 8px 14px; background: var(--charcoal); color: var(--white); border-radius: 0 var(--radius) var(--radius) 0; cursor: pointer; font-size: 0.85rem; }

    
    .adm-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
    .adm-modal-overlay.open { display: flex; }
    .adm-modal { background: var(--white); border-radius: var(--radius-lg); padding: 28px; width: 100%; max-width: 500px; box-shadow: var(--shadow-lg); }
    .adm-modal__head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .adm-modal__title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; }
    .adm-modal__close { cursor: pointer; color: var(--text-muted); font-size: 1.3rem; line-height: 1; background: none; border: none; }

   
    .adm-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; background: var(--gold-pale); }

    
    .adm-img-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: var(--radius); border: 1px solid var(--border); }

   
    .adm-empty { text-align: center; padding: 48px; color: var(--text-muted); }
    .adm-empty__icon { font-size: 2.5rem; margin-bottom: 10px; }
    .adm-empty__text { font-size: 0.95rem; }

   
    .adm-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .adm-stat { background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border); padding: 20px 22px; }
    .adm-stat__num { font-family: var(--font-display); font-size: 1.8rem; font-weight: 700; color: var(--charcoal); }
    .adm-stat__label { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
  </style>
</head>
<body>


<aside class="adm-sidebar">
  <div class="adm-logo">
    <span class="adm-logo__icon">✂</span>
    <span class="adm-logo__text">Scissors</span>
    <span class="adm-logo__badge">ADMIN</span>
  </div>

  <nav class="adm-nav">
    <div class="adm-nav__section">Контент</div>
    <a href="{{ route('admin:admin', ['type' => 'products']) }}" class="adm-nav__link {{ request('type','products') === 'products' ? 'active' : '' }}">
      <span class="adm-nav__icon">✂</span> Услуги
    </a>
    <a href="{{ route('admin:admin', ['type' => 'types']) }}" class="adm-nav__link {{ request('type') === 'types' ? 'active' : '' }}">
      <span class="adm-nav__icon">🏷</span> Типы услуг
    </a>
    <a href="{{ route('admin:admin', ['type' => 'news']) }}" class="adm-nav__link {{ request('type') === 'news' ? 'active' : '' }}">
      <span class="adm-nav__icon">📰</span> Новости
    </a>
    <a href="{{ route('admin:admin', ['type' => 'gallery']) }}" class="adm-nav__link {{ request('type') === 'gallery' ? 'active' : '' }}">
      <span class="adm-nav__icon">🖼</span> Галерея
    </a>

    <div class="adm-nav__section">Клиенты</div>
    <a href="{{ route('admin:admin', ['type' => 'bookings']) }}" class="adm-nav__link {{ request('type') === 'bookings' ? 'active' : '' }}">
      <span class="adm-nav__icon">📅</span> Записи
    </a>
    <a href="{{ route('admin:admin', ['type' => 'rewiews']) }}" class="adm-nav__link {{ request('type') === 'rewiews' ? 'active' : '' }}">
      <span class="adm-nav__icon">⭐</span> Отзывы
    </a>
    <a href="{{ route('admin:admin', ['type' => 'users']) }}" class="adm-nav__link {{ request('type') === 'users' ? 'active' : '' }}">
      <span class="adm-nav__icon">👤</span> Пользователи
    </a>
    <a href="{{ route('admin:admin', ['type' => 'workers']) }}" class="adm-nav__link {{ request('type') === 'workers' ? 'active' : '' }}">
      <span class="adm-nav__icon">💈</span> Мастера
    </a>
  </nav>

  <div class="adm-sidebar__footer">
    <a href="{{ route('main') }}" class="adm-sidebar__back">
      ← На сайт
    </a>
  </div>
</aside>


<div class="adm-main">
  <header class="adm-topbar">
    <span class="adm-topbar__title">@yield('page-title', 'Панель управления')</span>
    <div class="adm-topbar__user">
      <span>Администратор</span>
      <a href="{{ route('logoutUser') }}" style="color: var(--error); font-size: 0.82rem;">Выйти</a>
    </div>
  </header>

  <div class="adm-content">
    @if(session('success_message'))
      <div class="adm-alert adm-alert--success">✅ {{ session('success_message') }}</div>
    @endif
    @if(isset($error_message))
      <div class="adm-alert adm-alert--error">⚠️ {{ $error_message }}</div>
    @endif

    @yield('content')
  </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('adm-modal-overlay')) {
    e.target.classList.remove('open');
  }
});
</script>
@yield('scripts')
</body>
</html>
