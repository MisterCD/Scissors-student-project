@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Запись
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
    <style>
  .booking-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 32px;
    align-items: start;
  }
  .booking-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: sticky;
    top: 84px;
  }
  @media (max-width: 860px) {
    .booking-layout { grid-template-columns: 1fr; }
    .booking-sidebar { position: static; }
  }
</style>
<div class="breadcrumb">
  <div class="container breadcrumb__inner">
    <a href="{{ route("main") }}">Главная</a><span class="breadcrumb__sep">›</span><span>Запись онлайн</span>
  </div>
</div>

<section class="page-hero">
  <div class="container">
    <p class="page-hero__eyebrow">Запись онлайн</p>
    <h1 class="page-hero__title">Запишитесь<br><em style="font-style:italic;color:var(--gold-light)">за 2 минуты</em></h1>
    <p class="page-hero__sub">Выберите услугу, мастера, дату и время. Подтверждение придёт на почту.</p>
  </div>
</section>

<section class="section" style="background:var(--cream);">
  <div class="container">
    <div class="booking-layout">


      <form class="booking-form" action="{{ route("changeBooking") }}" method="post">
        @csrf
        <input type="number" name="id" value="{{ $booking->id }}" hidden>
        <h2 class="form-title">Изменить запись</h2>


        
        <div class="form-section">
          <div class="form-section__title">3. Дата и время</div>
          @error("date")
           <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          @error("time")
           <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Дата *</label>
              <input type="date" class="form-input" name="date" value="{{ $booking->date }}">
            </div>
            <div class="form-group">
              <label class="form-label">Время *</label>
              <input type="time" class="form-input" name="time" value="{{ $booking->time }}">
            </div>
          </div>
        </div>
        @if($errors->any())
          @foreach ($errors->all() as $error)
           <span style="color:var(--error);">{{ $error }}</span>
          @endforeach
        @endif
        <button class="btn btn--primary btn--block" style="font-size:1rem;padding:16px;">
          Изменить запись
        </button>
      </form>
      <form class="booking-form" action="{{ route("deleteUserBooking") }}" method="post">
        @csrf
        <input type="number" name="id" value="{{ $booking->id }}" hidden>
        <span>Удалить запись?</span>
        <button>Удалить</button>
      </form>

      </div>
    </div>
  </div>
</section>
@endsection
