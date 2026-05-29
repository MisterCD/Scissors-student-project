@props(["types"])
<form id="filter" class="services-filter" style="margin-bottom:0;">
        <input name="stars" hidden>
        <a href="{{ route("rewiews") }}" class="filter-btn">Все</a>
        <button type="button" id="star5" class="filter-btn">★★★★★</button>
        <button type="button" id="star4" class="filter-btn">★★★★</button>
        <button type="button" id="star3" class="filter-btn">★★★</button>
        <button type="button" id="star2" class="filter-btn">★★</button>
        <button type="button" id="star1" class="filter-btn">★</button>
        <select class="filter-select" name="type">
            <option>Все</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}">{{$type->name}}</option>
            @endforeach
        </select>
        <select class="filter-select" style="margin-left:0;">
        <option>Сначала новые</option>
        <option>Сначала старые</option>
        <option>По рейтингу</option>
      </select>
        <button type="submit" class="filter-btn">Фильтровать</button>
</form>