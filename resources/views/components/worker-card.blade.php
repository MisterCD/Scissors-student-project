@props(["worker"])
<div class="master-card">
        <div class="master-card__photo master-card__photo--1"><img src="{{ $worker->avatar }}"></div>
        <h3 class="master-card__name">{{ $worker->username }}</h3>
        <p class="master-card__role">{{ $worker->specilization }}</p>
        <p class="master-card__exp">{{ $worker->description_title }}</p>
        <a href="booking.html" class="master-card__btn">Записаться</a>
</div>