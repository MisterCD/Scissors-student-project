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

@php
$count = 0;
@endphp

<section class="section">
  <div class="container">
    <x-filter :type="'galary'" :types="$types"/>
    <div class="gallery-grid">
      @foreach ($images as $image)
        <x-image-card :image="$image" :count="$count"/>
        @php
          if($count == 3){
           $count = 0;
          }else{
           $count++;
          }
        @endphp
      @endforeach
    </div>
    <div class="section__cta">
      <a href="{{route("booking")}}" class="btn btn--primary">Хочу такой же результат — Записаться</a>
    </div>
    <div>
      {{ $images->links("pagination.pagination") }}
    </div>
  </div>
</section>

@endsection