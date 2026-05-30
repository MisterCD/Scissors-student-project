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


      <form class="booking-form" action="{{ route("createBooking") }}" method="post">
        @csrf
        <h2 class="form-title">Форма записи</h2>
        <div class="form-section">
          <div class="form-section__title">1. Выберите услугу</div>
          @error("product_id")
           <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="form-group">
            <label class="form-label">Услуга *</label>
            <select class="form-select" name="product_id">
              <option value="">— Выберите услугу —</option>
              @foreach ($Products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="form-section">
          <div class="form-section__title">2. Выберите мастера</div>
          @error("worker_id")
           <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="masters-radio">
            <label class="master-radio">
              <input type="radio" name="worker_id" value="any" checked>
              <span class="master-radio-label">
                <span class="master-mini-avatar" style="background:var(--gold);">✂</span>
                <span><span class="master-mini-name">Любой мастер</span><span class="master-mini-spec" style="display:block;">Первый свободный</span></span>
              </span>
            </label>
            @foreach ($workers as $worker)
              <label class="master-radio">
              <input type="radio" name="worker_id" value="{{ $worker->user_id }}">
              <span class="master-radio-label">
                <span class="master-mini-avatar" style="background:var(--gold);">✂</span>
                <span><span class="master-mini-name">{{ $worker->username }}</span></span>
              </span>
            </label>
            @endforeach
          </div>
        </div>
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
              <input type="date" class="form-input" name="date" value="2026-05-15">
            </div>
            <div class="form-group">
              <label class="form-label">Время *</label>
              <input type="time" class="form-input" name="time" value="2026-05-15">
            </div>
          </div>
        </div>


        <div class="form-section">
          <div class="form-section__title">4. Комментарий</div>
          @error("description")
           <span style="color:var(--error);">{{ $message }}</span>
          @enderror
          <div class="form-group">
            <label class="form-label">Пожелания (необязательно)</label>
            <textarea class="form-textarea" name="description" placeholder="Опишите желаемый результат, укажите особые пожелания..."></textarea>
          </div>
        </div>
        @if($errors->any())
          @foreach ($errors->all() as $error)
           <span style="color:var(--error);">{{ $error }}</span>
          @endforeach
        @endif
        <button class="btn btn--primary btn--block" style="font-size:1rem;padding:16px;">
          Подтвердить запись
        </button>
      </form>

      </div>
    </div>
  </div>
</section>
@endsection
