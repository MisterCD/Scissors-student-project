@props(["Products"])
@if(!empty(session("user_id")))
<section class="section" style="background:var(--cream);">
  <form class="container" method="post" action="{{ route("createRewiew") }}">
    @csrf
    <div class="section__head"><p class="section__eyebrow">Поделитесь мнением</p><h2 class="section__title">Оставить отзыв</h2></div>
    <div class="review-form-card">
      <div class="form-group"><label class="form-label">Услуга</label>
        <select name="product_id" class="form-select">
          <option>— Выберите услугу —</option>
          @foreach ($Products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
          @endforeach
        </select>
        @error("prouct_id")
          <span style="color:var(--error);">{{ $message }}</span>
        @enderror
        
      </div>
      <div class="form-group"><label class="form-label">Оценка *</label>
        <input type="number" name="stars" id="stars_value" hidden>
        @error("stars")
          <span style="color:var(--error);">{{ $message }}</span>
        @enderror
        <div class="rating-select">
          <span class="star-input">★</span><span class="star-input">★</span><span class="star-input">★</span><span class="star-input">★</span><span class="star-input">★</span>
        </div>
      </div>
      <div class="form-group"><label class="form-label">Ваш отзыв *</label>
        @error("description")
          <span style="color:var(--error);">{{ $message }}</span>
        @enderror
      <textarea name="description" class="form-textarea" placeholder="Расскажите о вашем визите..." style="min-height:120px;"></textarea></div>
      <button type="submit" class="btn btn--primary btn--block">Отправить отзыв</button>
      <p style="font-size:0.78rem;color:var(--text-muted);text-align:center;margin-top:10px;">Отзыв будет опубликован после проверки модератором</p>
    </div>
  </form>
</section>
@endif