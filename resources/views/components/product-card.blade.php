@props(["product"])

<div class="service-row">
        <div class="service-row__info">
          <div class="service-row__title">{{ $product->name }}</div>
          <div class="service-row__desc">{{ $product->description_title }}</div>
        </div>
        <div class="service-row__meta">
          <span class="service-row__price">{{ $product->cost }} ₽</span>
          <span class="service-row__time">⏱ {{ $product->time }} мин</span>
          <a href="booking.html" class="btn btn--sm btn--primary">Записаться</a>
        </div>
</div>