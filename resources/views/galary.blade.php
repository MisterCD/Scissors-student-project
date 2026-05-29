@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Галерея
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
  @endsection
@section("content")
<div class="breadcrumb"><div class="container breadcrumb__inner">
  <a href="{{ route("main") }}">Главная</a><span class="breadcrumb__sep">›</span><span>Галерея</span>
</div></div>
<section class="page-hero"><div class="container">
  <p class="page-hero__eyebrow">Наши работы</p>
  <h1 class="page-hero__title">Галерея</h1>
  <p class="page-hero__sub">Фотографии выполненных работ и интерьера нашего салона</p>
</div></section>

<section class="section">
  <div class="container">
    <div class="services-filter" style="margin-bottom:32px;">
      <a href = "{{route("menu")}}" class="filter-btn">Все категории</a>
      @foreach ($types as $type)
         <a href = "{{route("menu", ["type" => $type->id])}}" class="filter-btn">{{$type->name}}</a>
      @endforeach
    </div>
    <div class="gallery-grid">
      @foreach ($images as $image)
        <x-image-card :image="$image"/>
      @endforeach
    </div>
    <div class="section__cta">
      <a href="booking.html" class="btn btn--primary">Хочу такой же результат — Записаться</a>
    </div>
  </div>
</section>

@endsection