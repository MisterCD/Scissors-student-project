@extends("layouts/layout")
@section("content")
    <section style="background:var(--cream);padding:48px 0 0;">
  <div class="container cabinet-layout">

    
    <div class="cabinet-sidebar">
      <div class="cabinet-user">
        @if($user->avatar === "")
            <div class="cabinet-avatar">Нет</div>
        @else
            <img src="{{$user->avatar}}">
        @endif
        <div class="cabinet-user__name">{{ $user->username }}</div>
        <div class="cabinet-user__email">{{ $user->email }}</div>
      </div>
      <nav class="cabinet-nav" style="display: flex; flex-direction: column; gap:10px; align-items: center; justify-content:center;">
        <button class="filter-btn" >🗓 Мои записи</button>
        <button class="filter-btn" >⭐ Мои отзывы</button>
        <button class="filter-btn" >📋 История посещений</button>
        <button class="filter-btn" >🔔 Уведомления </button>
        <button class="filter-btn" >👤 Профиль</button>
        <a class="filter-btn" href="{{ route("logoutUser") }}" style="margin-top:12px;color:var(--error);">→ Выйти</a>
        @if ($user->status_id == 2 || $user->status_id == 1)
         <a class="filter-btn" href="{{ route("admin:admin") }}">Админ</a>
        @endif
      </nav>
    </div>
    <div class="cabinet-main">
      <div class="cabinet-card active-section" id="booking_active" >
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
          <h2 class="cabinet-card__title" style="margin-bottom:0;">Предстоящие записи</h2>
          <a href="{{ route("booking") }}" class="btn btn--sm btn--primary">+ Новая запись</a>
        </div>

        @foreach ($bookings as $booking)
        @if($booking->status != 3 || $booking->status != 2 || $booking->status != 4)
        <div style="background:var(--gold-pale);border:1px solid var(--gold);border-radius:var(--radius-lg);padding:20px;margin-bottom:16px;">
          <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:16px;">
              <div class="booking-date" style="background:var(--gold);">
                <div class="booking-date__month">{{ $booking->date }}</div>
              </div>
              <div>
                <div class="booking-info__service">{{ $booking->product_name }}</div>
                <div class="booking-info__meta">{{ $booking->product_cost }} ₽ · {{ $booking->worker_name }} · {{ $booking->time }}</div>
                  @if($booking->status == 0)
                  <span class="booking-status status--pending">
                      ⏳ Ожидает потдверждения
                  </span>
                  @elseif($booking->status == 1)
                  <span class="booking-status status--confirmed">
                      Потверждена
                  </span>
                  @endif
                </span>
              </div>
            </div>
            <div style="display:flex;gap:8px;">
              <button class="action-btn">Перенести</button>
              <button class="action-btn action-btn--danger">Отменить</button>
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
      <div class="cabinet-card active-section" style="display: none;">
        <h2 class="cabinet-card__title">Отзывы</h2>
      @foreach ($rewiews as $rewiew)
        <x-rewiew-card :rewiew="$rewiew"/>
      @endforeach
      </div>
      
      <div class="cabinet-card active-section" id="booking_history" style="display: none;">
        <h2 class="cabinet-card__title">История посещений</h2>
        @foreach ($bookings as $booking)
        <div class="booking-history-item">
          <div class="booking-date">{{ $booking->date }}</div>
          <div class="booking-info">
            <div class="booking-info__service">{{ $booking->product_name }}</div>
            <div class="booking-info__meta">{{ $booking->worker_name }} · {{ $booking->product_cost }} ₽</div>
          </div>
          @if($booking->status == 0)
                  <span class="booking-status status--pending">
                      ⏳ Ожидает потдверждения
                  </span>
                  @elseif($booking->status == 1)
                  <span class="booking-status status--confirmed">
                      Потверждена
                  </span>
            @endif
          <a href="{{ route("rewiews") }}" style="font-size:0.8rem;color:var(--gold);margin-left:12px;">Оставить отзыв</a>
        </div>
        @endforeach
      </div>

      
      <div class="cabinet-card active-section" id="notifications" style="display: none;">
        <h2 class="cabinet-card__title">Уведомления</h2>
        <div style="display:flex;flex-direction:column;gap:12px;">
          @foreach ($notifications as $notification)
          <div style="display:flex;gap:14px;padding:14px;background:var(--gold-pale);border:1px solid var(--gold);border-radius:var(--radius);position:relative;">
            <span style="font-size:1.2rem;">🔔</span>
            <div>
              <div style="font-size:0.87rem;font-weight:600;color:var(--charcoal);margin-bottom:2px;">{{ $notification->title }}</div>
              <div style="font-size:0.82rem;color:var(--text-muted);">{{ $notification->description }}</div>
              <div style="font-size:0.75rem;color:var(--warm-gray);margin-top:4px;">{{ $notification->date }}</div>
            </div>
            <span style="position:absolute;top:8px;right:12px;width:8px;height:8px;border-radius:50%;background:var(--gold);"></span>
          </div>
          @endforeach
        </div>
      </div>

      
      <div class="cabinet-card active-section" id="profile" style="display: none;">
        <h2 class="cabinet-card__title">Профиль</h2>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Имя</label><input type="text" class="form-input" value="{{ $user->username }}"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Телефон</label><input type="tel" class="form-input" value="{{ $user->tel }}"></div>
          <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-input" value="{{ $user->email }}"></div>
        </div>
        <button class="btn btn--primary">Сохранить изменения</button>
      </div>

    </div>
  </div>
</section>

<div style="height:48px;background:var(--cream);"></div>

@endsection
@section("scripts")
<script>
  const sections = document.querySelectorAll(".active-section");
  const buttons  = document.querySelectorAll(".filter-btn");
  let i = 0;
  buttons.forEach(el => {
    let g = i;
    el.onclick = () => {
      sections.forEach(el => {
        el.style.display = "none";
      })
      sections[g].style.display = "";
    };
    i++;
  })
</script>
@endsection
