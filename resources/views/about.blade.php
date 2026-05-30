@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | О нас
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
<div class="breadcrumb"><div class="container breadcrumb__inner">
  <a href="{{ route("main") }}">Главная</a><span class="breadcrumb__sep">›</span><span>О нас</span>
</div></div>

<section class="page-hero">
  <div class="container">
    <p class="page-hero__eyebrow">Наша история</p>
    <h1 class="page-hero__title">О парикмахерской<br><em style="font-style:italic;color:var(--gold-light)">Scissors</em></h1>
    <p class="page-hero__sub">Более 8 лет мы помогаем людям выглядеть и чувствовать себя лучше.</p>
  </div>
</section>
<style>
  .about-visual{
    position: relative;
    overflow: hidden;
  }
  .about-visual img{
    position: absolute;
    top:0;
    left:0;
    width: 100%;
    height: 100%;
    ima
  }
</style>
<section class="section">
  <div class="container">
    <div class="about-layout">
      <div class="about-visual">✂
        <img src="{{ asset("static_images/collective.png") }}">
      </div>
      <div class="about-content">
        <h2>Мастерство, которое говорит за себя</h2>
        <p>Парикмахерская Scissors открылась в 2018 году с простой идеей: создать место, где каждый клиент чувствует себя особенным. Мы начинали с двух мастеров и небольшого зала, а сегодня наша команда насчитывает 12 профессионалов.</p>
        <p>За 8 лет работы мы создали более 24 000 стрижек и укладок. Каждый наш мастер проходит регулярное обучение и следит за мировыми тенденциями в индустрии красоты.</p>
        <p>Мы используем профессиональную косметику ведущих мировых брендов: Wella, L'Oréal, Davines, Kerastase — только лучшее для ваших волос.</p>
        <div class="about-values">
          <div class="value-item">
            <div class="value-item__icon">🏆</div>
            <div class="value-item__title">Качество</div>
            <div class="value-item__text">Никаких компромиссов — только профессиональный результат</div>
          </div>
          <div class="value-item">
            <div class="value-item__icon">💬</div>
            <div class="value-item__title">Внимание</div>
            <div class="value-item__text">Слушаем каждое пожелание и воплощаем ваш образ</div>
          </div>
          <div class="value-item">
            <div class="value-item__icon">🌿</div>
            <div class="value-item__title">Безопасность</div>
            <div class="value-item__text">Гипоаллергенные, сертифицированные материалы</div>
          </div>
          <div class="value-item">
            <div class="value-item__icon">⚡</div>
            <div class="value-item__title">Удобство</div>
            <div class="value-item__text">Онлайн-запись, напоминания, личный кабинет</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="section" style="background:var(--cream);">
  <div class="container">
    <div class="section__head">
      <p class="section__eyebrow">Профессионалы</p>
      <h2 class="section__title">Наша команда</h2>
    </div>
    <div class="masters-grid">
      @foreach ($Workers as $worker)
        <x-worker-card :worker="$worker"/>
      @endforeach
    </div>
    {{ $Workers->links() }}
  </div>
</section>

<section class="cta-section">
  <div class="container cta-section__inner">
    <div class="cta-section__text">
      <h2 class="cta-section__title">Познакомимся лично?</h2>
      <p class="cta-section__sub">Запишитесь к любому из наших мастеров онлайн</p>
    </div>
    <div class="cta-section__actions">
      <a href="{{route("booking")}}" class="btn btn--white">Записаться онлайн</a>
      <a href="tel:+79001234567" class="btn btn--outline-white">📞 Позвонить</a>
    </div>
  </div>
</section>
@endsection
