@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Услуги
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
<div class="breadcrumb">
  <div class="container breadcrumb__inner">
    <a href="{{ route("main") }}">Главная</a>
    <span class="breadcrumb__sep">›</span>
    <span>Услуги</span>
  </div>
</div>

<section class="page-hero">
  <div class="container">
    <p class="page-hero__eyebrow">Наш прайс-лист</p>
    <h1 class="page-hero__title">Услуги<br><em style="font-style:italic; color:var(--gold-light)">и цены</em></h1>
    <p class="page-hero__sub">Профессиональные услуги по доступным ценам. Запишитесь онлайн и получите скидку 15%.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="services-filter">
      <a href = "{{route("menu")}}" class="filter-btn">Все категории</a>
      @foreach ($types as $type)
         <a href = "{{route("menu", ["type" => $type->id])}}" class="filter-btn">{{$type->name}}</a>
      @endforeach
      <form action="{{ route("menu") }}">
      <select class="filter-select">
        <option>Сортировать: по умолчанию</option>
        <option>По цене: возрастание</option>
        <option>По цене: убывание</option>
        <option>По популярности</option>
      </select>
      <select class="filter-select">
        <option>Мастер:все</option>
        
      </select>
      </form>
    </div>
     <h2 style="font-family:var(--font-display);font-size:1.1rem;color:var(--charcoal);margin-bottom:16px;padding-top:8px;">Все категории</h2>
    <div class="services-list" style="margin-bottom:36px;">
      @foreach ($Products as $product)
        <x-product-card :product="$product"/>
      @endforeach
    </div>
    <div class="section__cta" style="margin-top:48px;">
      <a href="booking.html" class="btn btn--primary" style="font-size:1rem;padding:16px 36px;">Записаться онлайн → скидка 15%</a>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="container cta-section__inner">
    <div class="cta-section__text">
      <h2 class="cta-section__title">Не знаете, что выбрать?</h2>
      <p class="cta-section__sub">Позвоните нам — поможем подобрать услугу под ваш запрос</p>
    </div>
    <div class="cta-section__actions">
      <a href="booking.html" class="btn btn--white">Записаться онлайн</a>
      <a href="tel:+79001234567" class="btn btn--outline-white">📞 Позвонить</a>
    </div>
  </div>
</section>
@endsection