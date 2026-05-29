@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Авторизация
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
    <style>
 
  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: var(--font-body);
    background: var(--cream-light);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* ------- LAYOUT ------- */
  .auth-page {
    flex: 1;
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: calc(100vh - 68px);
  }

  /* ------- LEFT PANEL (brand) ------- */
  .auth-panel {
    background: var(--charcoal);
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 52px 56px;
    overflow: hidden;
  }

  /* decorative circles */
  .auth-panel::before {
    content: '';
    position: absolute;
    width: 420px;
    height: 420px;
    border-radius: 50%;
    border: 60px solid rgba(201,168,76,0.07);
    top: -100px;
    right: -100px;
    pointer-events: none;
  }
  .auth-panel::after {
    content: '';
    position: absolute;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    border: 40px solid rgba(201,168,76,0.05);
    bottom: 60px;
    left: -60px;
    pointer-events: none;
  }

  .auth-panel__scissors {
    font-size: 9rem;
    line-height: 1;
    color: rgba(201,168,76,0.12);
    position: absolute;
    bottom: -20px;
    right: 32px;
    pointer-events: none;
    user-select: none;
  }

  .auth-panel__top { position: relative; z-index: 1; }

  .auth-panel__tagline {
    font-family: var(--font-display);
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    font-weight: 900;
    color: var(--white);
    line-height: 1.15;
    margin-top: 48px;
    margin-bottom: 16px;
  }
  .auth-panel__tagline em {
    font-style: italic;
    color: var(--gold-light);
  }

  .auth-panel__sub {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.5);
    line-height: 1.65;
    max-width: 340px;
  }

  .auth-panel__perks {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .auth-perk {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .auth-perk__icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(201,168,76,0.12);
    color: var(--gold-light);
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .auth-perk__text {
    font-size: 0.87rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.45;
  }
  .auth-perk__text strong {
    color: var(--white);
    display: block;
    font-size: 0.9rem;
  }

  /* ------- RIGHT PANEL (form) ------- */
  .auth-form-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 24px;
    background: var(--cream-light);
  }

  .auth-form-wrap {
    width: 100%;
    max-width: 420px;
  }

  .auth-form-wrap .auth-back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    color: var(--text-muted);
    margin-bottom: 28px;
    transition: color var(--transition);
  }
  .auth-form-wrap .auth-back-link:hover { color: var(--charcoal); }

  /* TABS */
  .auth-tabs {
    display: flex;
    border-bottom: 2px solid var(--border);
    margin-bottom: 32px;
  }
  .auth-tab {
    flex: 1;
    text-align: center;
    padding: 12px 8px;
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-muted);
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all var(--transition);
    text-decoration: none;
    display: block;
  }
  .auth-tab:hover { color: var(--charcoal); }
  .auth-tab--active {
    color: var(--charcoal);
    border-bottom-color: var(--gold);
    font-weight: 600;
  }

  /* FORM PANELS */
  .auth-form { display: none; }
  .auth-form--active { display: block; }

  .auth-form__title {
    font-family: var(--font-display);
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--charcoal);
    margin-bottom: 6px;
  }
  .auth-form__sub {
    font-size: 0.87rem;
    color: var(--text-muted);
    margin-bottom: 28px;
    line-height: 1.5;
  }
  .auth-form__sub a { color: var(--gold); }

  /* INPUT GROUP with icon */
  .input-icon-wrap {
    position: relative;
  }
  .input-icon-wrap .form-input {
    padding-left: 44px;
  }
  .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1rem;
    pointer-events: none;
    opacity: 0.4;
  }
  .input-eye {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.85rem;
    cursor: pointer;
    opacity: 0.4;
    color: var(--text-muted);
  }
  .input-eye:hover { opacity: 0.8; }

  /* STRENGTH BAR */
  .password-strength {
    margin-top: 6px;
    display: flex;
    gap: 4px;
    align-items: center;
  }
  .strength-bar {
    height: 3px;
    flex: 1;
    border-radius: 2px;
    background: var(--border);
  }
  .strength-bar--fill-1 { background: var(--error); }
  .strength-bar--fill-2 { background: var(--gold); }
  .strength-bar--fill-3 { background: var(--success); }
  .strength-label {
    font-size: 0.72rem;
    color: var(--text-muted);
    white-space: nowrap;
  }

  /* DIVIDER */
  .auth-or {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0;
    font-size: 0.8rem;
    color: var(--text-muted);
  }
  .auth-or::before,
  .auth-or::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
  }

  /* SOCIAL BUTTONS */
  .social-btns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 4px;
  }
  .social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 16px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--text);
    background: var(--white);
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
  }
  .social-btn:hover {
    border-color: var(--charcoal);
    background: var(--cream);
  }
  .social-btn__icon { font-size: 1rem; }

  /* CHECKBOX */
  .form-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    font-size: 0.83rem;
    color: var(--text-muted);
    line-height: 1.45;
    margin-bottom: 20px;
  }
  .form-checkbox input {
    margin-top: 2px;
    accent-color: var(--gold);
    flex-shrink: 0;
  }
  .form-checkbox a { color: var(--gold); }

  /* FOOTER LINK */
  .auth-switch {
    text-align: center;
    font-size: 0.84rem;
    color: var(--text-muted);
    margin-top: 20px;
  }
  .auth-switch a {
    color: var(--gold);
    font-weight: 500;
    cursor: pointer;
    text-decoration: underline;
    text-underline-offset: 3px;
    background: none;
    border: none;
  }

  .forgot-panel { display: none; }
  .forgot-panel--active { display: block; }


  .auth-success {
    display: none;
    text-align: center;
    padding: 20px 0;
  }
  .auth-success__icon {
    font-size: 3.5rem;
    margin-bottom: 16px;
    display: block;
  }
  .auth-success__title {
    font-family: var(--font-display);
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--charcoal);
    margin-bottom: 8px;
  }
  .auth-success__sub {
    font-size: 0.87rem;
    color: var(--text-muted);
    margin-bottom: 24px;
    line-height: 1.55;
  }

  /* Responsive */
  @media (max-width: 800px) {
    .auth-page { grid-template-columns: 1fr; }
    .auth-panel { display: none; }
    .auth-form-panel { padding: 32px 20px; min-height: calc(100vh - 68px); }
  }
</style>

<div class="auth-page">

  
  <div class="auth-panel">
    <div class="auth-panel__top">
      <a href="{{ route("main") }}" class="logo logo--light">
        <span class="logo__icon">✂</span>
        <span class="logo__text">Scissors</span>
      </a>

      <div class="auth-panel__tagline">
        Ваш стиль —<br>наша <em>забота</em>
      </div>
      <p class="auth-panel__sub">
        Создайте аккаунт, чтобы записываться в один клик,<br>
        получать напоминания и отслеживать историю посещений.
      </p>
    </div>

    <div class="auth-panel__perks">
      <div class="auth-perk">
        <div class="auth-perk__icon">🗓</div>
        <div class="auth-perk__text">
          <strong>Быстрая запись</strong>
          Выберите услугу и время — всё сохранено в кабинете
        </div>
      </div>
      <div class="auth-perk">
        <div class="auth-perk__icon">🔔</div>
        <div class="auth-perk__text">
          <strong>Напоминания</strong>
          SMS и email за 2 часа до визита — не забудете
        </div>
      </div>
      <div class="auth-perk">
        <div class="auth-perk__icon">📋</div>
        <div class="auth-perk__text">
          <strong>История посещений</strong>
          Все стрижки и процедуры в одном месте
        </div>
      </div>
      <div class="auth-perk">
        <div class="auth-perk__icon">🎁</div>
        <div class="auth-perk__text">
          <strong>Акции и скидки</strong>
          Первыми узнавайте о спецпредложениях
        </div>
      </div>
    </div>

    <div class="auth-panel__scissors" aria-hidden="true">✂</div>
  </div>

  
  <div class="auth-form-panel">
    <div class="auth-form-wrap">

      <a href="{{ route("main") }}" class="auth-back-link">← Вернуться на сайт</a>

      
      <div class="auth-tabs">
        <a class="auth-tab auth-tab--active" id="tab-login" onclick="showTab('login'); return false;" href="#">Войти</a>
        <a class="auth-tab" id="tab-register" onclick="showTab('register'); return false;" href="#">Зарегистрироваться</a>
      </div>

      
      <form class="auth-form auth-form--active" method="post" id="form-login" action="{{ route("loginUser") }}">
        @csrf
        <h1 class="auth-form__title">Добро пожаловать!</h1>
        <p class="auth-form__sub">Войдите в личный кабинет, чтобы управлять записями</p>

        <div class="form-group">
          <label class="form-label">Email</label>
          @error("email")
            <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="input-icon-wrap">
            <span class="input-icon">📧</span>
            <input type="email" name="email" class="form-input" placeholder="your@email.com" autocomplete="email">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" style="display:flex;justify-content:space-between;">
            <span>Пароль</span>
          </label>
          @error("password")
            <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="input-icon-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" name="password" class="form-input" placeholder="Введите пароль" id="login-password" autocomplete="current-password">
            <span class="input-eye" onclick="togglePass('login-password', this)">👁</span>
          </div>
        </div>

        <button type="submit" class="btn btn--primary btn--block" style="font-size:0.95rem;padding:14px;">
          Войти в кабинет
        </button>

        <div class="auth-switch">
          Нет аккаунта? <a onclick="showTab('register'); return false;" href="#">Зарегистрируйтесь</a>
        </div>
     </form>
      <form class="auth-form" id="form-register" method="post" action="{{ route("createUser") }}">
        @csrf
        <h1 class="auth-form__title">Создайте аккаунт</h1>
        <p class="auth-form__sub">Быстрая регистрация — запись в один клик</p>
          <div class="form-group">
            <label class="form-label">Имя *</label>
            @error("username")
              <span style="color:var(--error);">{{ $message }}</span>
            @enderror
            <div class="input-icon-wrap">
              <span class="input-icon">👤</span>
              <input type="text" name="username" class="form-input" placeholder="Иван Иванов" autocomplete="given-name">
            </div>
          </div>

        <div class="form-group">
          <label class="form-label">Телефон *</label>
          @error("tel")
            <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="input-icon-wrap">
            <span class="input-icon">📞</span>
            <input type="tel" name="tel" class="form-input" placeholder="+7-900-00-00-000" autocomplete="tel">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Email *</label>
          @error("email")
            <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="input-icon-wrap">
            <span class="input-icon">📧</span>
            <input type="email" name="email" class="form-input" placeholder="your@email.com" autocomplete="email">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Пароль *</label>
          @error("password")
            <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="input-icon-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" name="password" class="form-input" placeholder="Минимум 8 символов" id="reg-password" autocomplete="new-password" oninput="checkPassword(); ">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Повторите пароль *</label>
          <div class="input-icon-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" class="form-input" placeholder="Повторите пароль" id="reg-password2" autocomplete="new-password" oninput="checkPassword()">
          </div>
        </div>

        <button disabled type="submit" id="submit-button" class="btn btn--primary btn--block" style="font-size:0.95rem;padding:14px;background:var(--charcoal-soft);cursor:default;">
          Создать аккаунт
        </button>

        <div class="auth-switch">
          Уже есть аккаунт? <a onclick="showTab('login'); return false;" href="#">Войдите</a>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
@section("scripts")
<script>
  const register     = document.getElementById('form-register');
  const login        = document.getElementById('form-login'   ); 
  const tab_login    = document.getElementById('tab-login'    );
  const tab_register = document.getElementById('tab-register' );
  function showTab(tab) {
    login.classList.       remove('auth-form--active');
    register.classList.    remove('auth-form--active');
    tab_login.classList.   remove('auth-tab--active' );
    tab_register.classList.remove('auth-tab--active' );
    if (tab === 'login') {
      login.classList.        add('auth-form--active');
      tab_login.classList.    add('auth-tab--active' );
    } else {
      register.classList.     add('auth-form--active');
      tab_register.classList. add('auth-tab--active' );
    }
  }
  function checkPassword(inp){
      const target_password  = document.getElementById("reg-password" );
      const checked_password = document.getElementById("reg-password2");
      const submit_button    = document.getElementById("submit-button");
      if(checked_password.value != target_password.value){
          submit_button.style.background = "var(--charcoal-soft)";
          submit_button.style.cursor = "default";
          submit_button.disabled = true;
      }else{
          submit_button.style.background = "";
          submit_button.style.cursor = "pointer";
          submit_button.disabled = false;
      }
  }
</script>
@endsection


