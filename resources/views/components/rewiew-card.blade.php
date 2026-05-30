@props(["rewiew"])
<div class="review-card">
        <div class="review-card__stars">
          @for($i = 1; $i <= $rewiew->stars; $i++)
            ★ 
          @endfor
        </div>
        <p class="review-card__text">«{{ $rewiew->description }}»</p>
        <div class="review-card__author"><span class="review-card__avatar"><img src="{{ $rewiew->avatar }}"></span><div><strong>{{ $rewiew->username }}</strong><span>{{ $rewiew->date }}</span></div></div>
        <div style="margin-top:12px;font-size:0.78rem;color:var(--gold);">{{ $rewiew->username }}</div>
</div>








