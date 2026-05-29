@props(["image", "count" => 0])
@if($count == 0)
      <div class="gallery-item gallery-item--wide"><div class="gallery-placeholder gallery-placeholder--1">✂</div></div>
      @php
        $count++;
      @endphp
      @elseif($count == 1)
      <div class="gallery-item gallery-item--tall"><div class="gallery-placeholder gallery-placeholder--2">💇</div></div>
      @php
        $count++;
      @endphp
      @elseif($count == 2)
      <div class="gallery-item"><div class="gallery-placeholder gallery-placeholder--3">🎨</div></div>
      @php
        $count = 0;
      @endphp
@endif