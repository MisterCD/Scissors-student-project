@props(["event"])

@if($event->type_id == 0)
        <article class="news-card news-card--big">
          <div class="news-card__img news-card__img--placeholder">
            <span class="news-card__tag">Акция</span>
          </div>
          <div class="news-card__body">
          <time class="news-card__date">{{ $event->date }}</time>
          <h3 class="news-card__title">{{ $event->title }}</h3>
              <p class="news-card__text">{{ $event->description_title }}</p>
              <a href="{{ route("event", ["id" => $event->id]) }}" class="news-card__more">Подробнее →</a>
            </div>
          </article>
          @elseif($event->type_id == 1)
          <article class="news-card">
            <div class="news-card__img news-card__img--sm news-card__img--placeholder2">
              <span class="news-card__tag">Новость</span>
            </div>
            <div class="news-card__body">
              <time class="news-card__date">{{ $event->date }}</time>
              <h3 class="news-card__title">{{ $event->title }}</h3>
              <p class="news-card__text">{{ $event->description_title }}</p>
              <a href="{{ route("event", ["id" => $event->id]) }}" class="news-card__more">Подробнее →</a>
            </div>
          </article>
          @elseif($event->type_id == 2)
          <article class="news-card">
            <div class="news-card__img news-card__img--sm news-card__img--placeholder3">
              <span class="news-card__tag">Спецпредложение</span>
            </div>
            <div class="news-card__body">
              <time class="news-card__date">{{ $event->date }}</time>
              <h3 class="news-card__title">{{ $event->title }}</h3>
              <p class="news-card__text">{{ $event->description_title }}</p>
              <a href="{{ route("event", ["id" => $event->id]) }}" class="news-card__more">Подробнее →</a>
            </div>
          </article>
@endif