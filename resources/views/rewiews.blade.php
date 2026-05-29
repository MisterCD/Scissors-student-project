@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Отзывы
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
<div class="breadcrumb"><div class="container breadcrumb__inner">
  <a href="{{ route("main") }}">Главная</a><span class="breadcrumb__sep">›</span><span>Отзывы</span>
</div></div>

<section class="page-hero"><div class="container">
  <p class="page-hero__eyebrow">Мнения клиентов</p>
  <h1 class="page-hero__title">Отзывы</h1>
  <p class="page-hero__sub">Нам доверяют более 2400 клиентов. Узнайте, что они говорят о нас.</p>
</div></section>




<section class="section">
  <div class="container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
      <x-rewiew-filter :types="$types"/>
    </div>
    <div class="reviews-page-grid">
      @foreach ($rewiews as $rewiew)
        @if($rewiew->status != 0)
          <x-rewiew-card :rewiew="$rewiew"/>
        @endif
      @endforeach
    </div>
    {{ $rewiews->links("pagination.pagination") }}
  </div>
</section>

<x-rewiew-form :Products="$Products"/>

@endsection
@section("scripts")
  <script>
    star5.onclick = () => {
        stars.value = 5;
    }
    star4.onclick = () => {
        stars.value = 4;
    }
    star3.onclick = () => {
        stars.value = 3;
    }
    star2.onclick = () => {
        stars.value = 2;
    }
    star1.onclick = () => {
        stars.value = 1;
    }
    const stars_form = document.querySelectorAll(".star-input");
    let i = 0;
    stars_form.forEach(element => {
      i++;
      let g = i;
      element.onclick = () => {
        for(let y = 0; y < stars_form.length; y++){
          stars_form[y].style.color = "var(--gold)";
          if(element == stars_form[y]){
            break
          }

        }
        stars_value.value = g;
        for(let y = stars_form.length - 1; y > 0; y--){
          if(element == stars_form[y]){
            break
          }
          stars_form[y].style.color = z;

        }
      };
    });
  </script>
@endsection