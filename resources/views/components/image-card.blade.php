@props(["image", "count" => 0])
@if($count == 0)
      <div class="gallery-item gallery-item--wide"><img src="{{asset("storage/".$image->path) }}"><div class="gallery-placeholder gallery-placeholder--1">✂</div></div>
      @elseif($count == 1)
      <div class="gallery-item gallery-item--tall"><img src="{{ asset("storage/".$image->path) }}"><div class="gallery-placeholder gallery-placeholder--2">💇</div></div>
      @elseif($count == 2 || $count == 3)
      <div class="gallery-item"><img src="{{ asset("storage/".$image->path) }}"><div class="gallery-placeholder gallery-placeholder--3">🎨</div></div>
@endif