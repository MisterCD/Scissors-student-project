<!DOCTYPE html>
<html lang="ru">
<head>
@vite(["resources/css/style.css"])
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="@yield("description")">
<title>@yield("title")</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" href="{{ asset("static_images/Scissors_ICO.png") }}" type="image/x-icon">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

<header class="header">
  <div class="header__inner container">
    <a href="{{ route("main") }}" class="logo"><span class="logo__icon"><img width="45" height="45" style="border-radius:50%; border:2px solid var(--gold)" src="{{ asset("static_images/scissors.png") }}"></span><span class="logo__text">Scissors</span></a>
    <nav class="nav">
      <a href="{{ route("main") }}" class="nav__link">Главная</a>
      <a href="{{ route("about") }}" class="nav__link">О нас</a>
      <a href="{{ route("menu") }}" class="nav__link">Услуги</a>
      <a href="{{ route("booking") }}" class="nav__link">Запись</a>
      <a href="{{ route("galary") }}" class="nav__link">Галерея</a>
      <a href="{{ route("rewiews") }}" class="nav__link">Отзывы</a>
      <a href="{{ route("contacts") }}" class="nav__link">Контакты</a>
    </nav>
    <div class="header__actions">
      <a href="tel:+79001234567" class="btn-call"><span class="btn-call__icon">📞</span><span>Позвонить</span></a>
      @if(!empty(session("user_id")))
      <a href="{{ route("user") }}" class="btn-cabinet">Кабинет</a>
      @else
      <a href="{{ route("login") }}" class="btn-cabinet">Авторизация</a>
      @endif
    </div>
  </div>
</header>
<main>
    @yield("content")
</main>
<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__brand">
      <a href="{{ route("main") }}" class="logo logo--light"><span class="logo__icon">✂</span><span class="logo__text">Scissors</span></a>
      <p class="footer__tagline">Профессиональная парикмахерская</p>
    </div>
    <div class="footer__nav"><h4>Меню</h4>
      <a href="{{ route("main") }}">Главная</a><a href="{{ route("about") }}">О нас</a><a href="{{ route("menu") }}">Услуги</a><a href="{{ route("booking") }}">Запись</a><a href="{{ route("contacts") }}">Контакты</a>
    </div>
    <div class="footer__contact"><h4>Контакты</h4>
      <p>📞 <a href="tel:+79001234567">+7 (900) 123-45-67</a></p>
      <p>🕐 Пн–Пт: 9:00–20:00</p><p>🕐 Сб–Вс: 10:00–18:00</p>
    </div>
  </div>
  <div class="footer__bottom"><div class="container footer__bottom-inner">
    <p>© 2026 Scissors. Все права защищены.</p>
  </div></div>
</footer>
<a href="tel:+79001234567" class="floating-call"><span>📞</span></a>
@yield("scripts")
</body>
</html>
