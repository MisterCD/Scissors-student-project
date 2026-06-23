@props(["event"])

@if($event->type_id == 0)
        <article class="news-card news-card--big">
          <div class="news-card__img news-card__img--placeholder">
            <span class="news-card__tag">Акция</span>
            <img src="{{ "storage/".$event->title_image_path }}">
          </div>
          <div class="news-card__body">
          <time class="news-card__date">{{ $event->date }}</time>
          <h3 class="news-card__title">{{ $event->name }}</h3>
              <p class="news-card__text">{{ $event->description_title }}</p>
               
            </div>
          </article>
          @elseif($event->type_id == 1)
          <article class="news-card">
            <div class="news-card__img news-card__img--sm news-card__img--placeholder2">
              <span class="news-card__tag">Новость</span>
              <img src="{{ "storage/".$event->title_image_path }}">
            </div>
            <div class="news-card__body">
              <time class="news-card__date">{{ $event->date }}</time>
              <h3 class="news-card__title">{{ $event->name }}</h3>
              <p class="news-card__text">{{ $event->description_title }}</p>
               
            </div>
          </article>
          @elseif($event->type_id == 2)
          <article class="news-card">
            <div class="news-card__img news-card__img--sm news-card__img--placeholder3">
              <span class="news-card__tag">Спецпредложение</span>
              <img src="{{ "storage/".$event->title_image_path }}">
            </div>
            <div class="news-card__body">
              <time class="news-card__date">{{ $event->date }}</time>
              <h3 class="news-card__title">{{ $event->name }}</h3>
              <p class="news-card__text">{{ $event->description_title }}</p>
               
            </div>
          </article>
@endif