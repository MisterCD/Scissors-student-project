@props(["type" => "products", "types", "Workers"])
@if($type == "products")
<div class="services-filter">
      <a href = "{{route("menu")}}" class="filter-btn">Все категории</a>
      <form action="{{ route("menu") }}">
      <select name="type" class="filter-select">
         @foreach ($types as $type)
           <option value="{{ $type->id }}">{{$type->name}}</option>
         @endforeach
      </select>
      <select class="filter-select">
        <option>Сортировать: по умолчанию</option>
        <option>По цене: возрастание</option>
        <option>По цене: убывание</option>
        <option>По популярности</option>
      </select>
      <select name="master" class="filter-select">
        <option>Мастер:все</option>
        @foreach ($Workers as $worker)
            <option value="{{ $worker->user_id }}">{{ $worker->username }}</option>
        @endforeach
      </select>
      <button type="submit" class="filter-btn">Фильтровать</button>
      </form>
      
    </div>
@elseif($type == "rewiews")
<form id="filter" class="services-filter" style="margin-bottom:0;">
        <input name="stars" id="stars" hidden>
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
@elseif($type == "galary")
<div class="services-filter" style="margin-bottom:32px;">
      <a href = "{{route("menu")}}" class="filter-btn">Все категории</a>
      @foreach ($types as $type)
         <a href = "{{route("menu", ["type" => $type->id])}}" class="filter-btn">{{$type->name}}</a>
      @endforeach
</div>
@endif