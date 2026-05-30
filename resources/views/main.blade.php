@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Главная
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
<style>
  .hero__placeholder{
    position: relative;
  }
  .hero__placeholder img{
    position: absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
  }
</style>
<section class="hero">
  <div class="hero__bg">
    <div class="hero__stripe hero__stripe--1"></div>
    <div class="hero__stripe hero__stripe--2"></div>
    <div class="hero__stripe hero__stripe--3"></div>
  </div>
  <div class="container hero__inner">
    <div class="hero__content">
      <p class="hero__eyebrow">Профессиональная парикмахерская</p>
      <h1 class="hero__title">Искусство <em>стрижки</em><br>в каждом движении</h1>
      <p class="hero__subtitle">Мы создаём образы, которые говорят о вас лучше слов. Запишитесь онлайн прямо сейчас.</p>
      <div class="hero__btns">
        <a href="{{ route("booking") }}" class="btn btn--primary">Записаться онлайн</a>
      </div>
      <div class="hero__stats">
        <div class="stat">
          <span class="stat__num">8+</span>
          <span class="stat__label">лет работы</span>
        </div>
        <div class="stat__divider"></div>
        <div class="stat">
          <span class="stat__num">2400+</span>
          <span class="stat__label">довольных клиентов</span>
        </div>
        <div class="stat__divider"></div>
      </div>
    </div>
    <div class="hero__visual">
      <div class="hero__card">
        <div class="hero__card-img">
          <div class="hero__placeholder">
            <span>✂</span>
            <img src="{{ asset("static_images/title.png") }}">
          </div>
        </div>
        <div class="hero__card-badge">
          <span class="badge badge--gold" id="rating"></span>
          <span class="badge__text">Рейтинг</span>
        </div>
      </div>
      <div class="hero__float hero__float--1">Стрижка от 600₽</div>
      <div class="hero__float hero__float--2">Запись за 2 минуты</div>
    </div>
  </div>
</section>


<section class="promo-strip">
  <div class="container">
    <div class="promo-strip__inner">
      @foreach ($News as $event)
      @if($event->type_id == 1)
      <div class="promo-item">
        <span class="promo-item__icon">🎁</span>
        <div>
          <strong>Акция!</strong> {{ $event->title }}
        </div>
      </div>
      @else($event->type_id == 2)
      <div class="promo-item">
        <span class="promo-item__icon">⭐</span>
        <div>
          <strong>Специальное предложение</strong> — {{ $event->title }}
        </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</section>


<section class="section services-preview" id="products">
  <div class="container">
    <div class="section__head">
      <p class="section__eyebrow">Что мы предлагаем</p>
      <h2 class="section__title">Популярные услуги</h2>
    </div>
    <div class="services-grid" style="grid-template-columns:1fr;">
      @foreach ($Products as $product)
        <x-product-card :product="$product"/>
      @endforeach
    </div>
    <div class="section__cta">
      <a href="{{ route("menu") }}" class="btn btn--outline">Все услуги</a>
    </div>
  </div>
</section>


<section class="section news-section" id="news">
  <div class="container">
    <div class="section__head">
      <p class="section__eyebrow">Актуальное</p>
      <h2 class="section__title">Акции и новости</h2>
    </div>
    <div class="news-grid">
      @foreach ($News as $event)
        <x-news-card :event="$event"/>
      @endforeach
    </div>
  </div>
</section>


<section class="section masters-section">
  <div class="container">
    <div class="section__head">
      <p class="section__eyebrow">Наша команда</p>
      <h2 class="section__title">Мастера</h2>
    </div>
    <div class="masters-grid">
      @foreach ($Workers as $Worker)
        <x-worker-card :worker="$Worker"/>  
      @endforeach
    </div>
    <div class="section__cta">
      <a href="{{ route("about") }}" class="btn btn--outline">Вся команда</a>
    </div>
  </div>
</section>


<section class="section reviews-section">
  <div class="container">
    <div class="section__head">
      <p class="section__eyebrow">Мнения клиентов</p>
      <h2 class="section__title">Отзывы</h2>
    </div>
    <div class="reviews-grid">
      @foreach ($Rewiews as $rewiew)
         <x-rewiew-card :rewiew="$rewiew"/>
      @endforeach
    </div>
    <div class="section__cta">
      <a href="{{ route("rewiews") }}" class="btn btn--outline">Все отзывы</a>
    </div>
  </div>
</section>


<section class="cta-section">
  <div class="container cta-section__inner">
    <div class="cta-section__text">
      <h2 class="cta-section__title">Готовы к новому образу?</h2>
      <p class="cta-section__sub">Запишитесь онлайн за 2 минуты — без ожидания на телефоне</p>
    </div>
    <div class="cta-section__actions">
      <a href="{{ route("booking") }}" class="btn btn--white">Записаться онлайн</a>
      <a href="tel:+79001234567" class="btn btn--outline-white">📞 +7 (900) 123-45-67</a>
    </div>
  </div>
</section>
@endsection
@section("scripts")
  <script>
    globalThis.stars = 0;
    globalThis.starsCount = {{ $stars->count() }}
    @foreach( $stars as $star )
      stars += {{ $star->stars }}
    @endforeach
    const rating = document.getElementById("rating");
    rating.textContent = "★" + (stars / starsCount)
  </script>
@endsection













