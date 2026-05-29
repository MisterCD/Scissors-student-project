@extends("layouts/layout")
@section("title")
  Scissors — Парикмахерская | Контакты
@endsection
@section("description")
  Парикмахерская Scissors — профессиональные услуги стрижки и укладки в вашем городе. Запись онлайн.
@endsection
@section("content")
<div class="breadcrumb"><div class="container breadcrumb__inner">
  <a href="{{ route("main") }}">Главная</a><span class="breadcrumb__sep">›</span><span>Контакты</span>
</div></div>

<section class="page-hero"><div class="container">
  <p class="page-hero__eyebrow">Где нас найти</p>
  <h1 class="page-hero__title">Контакты</h1>
  <p class="page-hero__sub">Приходите к нам или свяжитесь удобным способом</p>
</div></section>

<section class="section" style="background:var(--cream);">
  <div class="container">
    <div class="contacts-layout">

      
      <div>
        <div class="contact-info-card">
          <h2>Как с нами связаться</h2>
          <div class="contact-item">
            <div class="contact-item__icon">📍</div>
            <div>
              <div class="contact-item__label">Адрес</div>
              <div class="contact-item__value">{{ $contact != null ? $contact->adress : "undefinted" }}</div>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-item__icon">📞</div>
            <div>
              <div class="contact-item__label">Телефон</div>
              <div class="contact-item__value">
                <a href="tel:{{ $contact != null ? $contact->tel : "undefinted" }}">{{ $contact != null ? $contact->tel : "undefinted" }}</a>
              </div>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-item__icon">✉</div>
            <div>
              <div class="contact-item__label">Почта</div>
              <div class="contact-item__value"><a href="mailto:info@scissors.ru">{{ $contact != null ? $contact->email : "undefinted" }}</a></div>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-item__icon">🕐</div>
            <div>
              <div class="contact-item__label">Режим работы</div>
              <div class="contact-item__value">
                <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                  <div style="display:flex;justify-content:space-between;font-size:0.87rem;padding:5px 0;border-bottom:1px solid var(--border);">
                    <span style="color:var(--text-muted);">Понедельник – Пятница</span><span style="font-weight:500;">9:00 – 20:00</span>
                  </div>
                  <div style="display:flex;justify-content:space-between;font-size:0.87rem;padding:5px 0;border-bottom:1px solid var(--border);">
                    <span style="color:var(--text-muted);">Суббота</span><span style="font-weight:500;">10:00 – 18:00</span>
                  </div>
                  <div style="display:flex;justify-content:space-between;font-size:0.87rem;padding:5px 0;border-bottom:1px solid var(--border);">
                    <span style="color:var(--text-muted);">Воскресенье</span><span style="font-weight:500;">10:00 – 17:00</span>
                  </div>
                  <div style="display:flex;justify-content:space-between;font-size:0.87rem;padding:5px 0;">
                    <span style="color:var(--text-muted);">Праздничные дни</span><span style="color:var(--error);font-weight:500;">Выходной</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

       
        <div class="map-placeholder" style="margin-top:24px;">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4478.969304396977!2d37.35427146229886!3d55.85425727648325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b547122a25e6a7%3A0x6cfa86e6cc515d5!2z0KLQpiAi0JzQsNC90LTQsNGA0LjQvSI!5e0!3m2!1sru!2sus!4v1779464102657!5m2!1sru!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      
      <div>
        <div style="background:var(--charcoal);border-radius:var(--radius-lg);padding:28px;margin-top:24px;text-align:center;position:sticky;top:0;">
          <div style="font-size:2rem;margin-bottom:10px;">✂</div>
          <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--white);margin-bottom:8px;">Хотите записаться?</h3>
          <p style="font-size:0.85rem;color:rgba(255,255,255,0.5);margin-bottom:18px;">Онлайн-запись — быстро и удобно, скидка 15%</p>
          <a href="booking.html" class="btn btn--gold btn--block">Записаться онлайн</a>
          <a href="tel:+79001234567" class="btn btn--outline-white btn--block" style="margin-top:10px;">📞 Позвонить</a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection