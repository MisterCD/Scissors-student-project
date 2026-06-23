@extends('layouts.layout-admin')
@section('page-title', 'Отзывы')

@section('content')

 
@php
  $total    = count($rewiews);
  $pending  = collect($rewiews)->where('allowed', 0)->count();
  $approved = collect($rewiews)->where('allowed', 1)->count();
  $avgStars = $total > 0 ? round(collect($rewiews)->avg('stars'), 1) : 0;
@endphp

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px">
  @foreach([
    ['num' => $total,    'label' => 'Всего отзывов',      'icon' => '⭐'],
    ['num' => $pending,  'label' => 'Ожидают проверки',   'icon' => '⏳'],
    ['num' => $approved, 'label' => 'Опубликовано',       'icon' => '✅'],
    ['num' => $avgStars, 'label' => 'Средняя оценка',     'icon' => '★'],
  ] as $s)
  <div class="adm-stat">
    <div style="font-size:1.4rem;margin-bottom:4px">{{ $s['icon'] }}</div>
    <div class="adm-stat__num">{{ $s['num'] }}</div>
    <div class="adm-stat__label">{{ $s['label'] }}</div>
  </div>
  @endforeach
</div>

 
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
  <div class="adm-filters">
    @foreach(['all'=>'Все','pending'=>'На проверке','approved'=>'Опубликованы'] as $key=>$label)
      <a href="{{ route('admin:admin', ['type'=>'rewiews','filter'=>$key]) }}"
         class="adm-filter-btn {{ $filter===$key ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
  </div>
  <span style="font-size:0.82rem;color:var(--text-muted)">{{ $total }} {{ $total === 1 ? 'отзыв' : ($total < 5 ? 'отзыва' : 'отзывов') }}</span>
</div>

 
@forelse($rewiews as $r)
<div class="adm-card" style="margin-bottom:14px;transition:box-shadow 0.2s" onmouseover="this.style.boxShadow='var(--shadow)'" onmouseout="this.style.boxShadow=''">
  <div style="display:grid;grid-template-columns:auto 1fr auto;gap:0">

     
    <div style="width:4px;background:{{ $r->allowed ? '#4a7c59' : '#c9a84c' }};border-radius:var(--radius-lg) 0 0 var(--radius-lg)"></div>

     
    <div style="padding:20px 22px">

       
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;flex-wrap:wrap">

         
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0">
          @if($r->avatar)
            <img style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1.5px solid var(--border)"
                 src="{{ Str::startsWith($r->avatar,'http') ? $r->avatar : asset('storage/'.$r->avatar) }}" alt="">
          @else
            <div style="width:40px;height:40px;border-radius:50%;background:var(--gold-pale);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">👤</div>
          @endif
          <div>
            <div style="font-weight:600;font-size:0.92rem">{{ $r->username }}</div>
            <div style="font-size:0.78rem;color:var(--text-muted)">{{ \Carbon\Carbon::parse($r->date)->format('d.m.Y') }}</div>
          </div>
        </div>

         
        <div style="background:var(--cream);border:1px solid var(--border);border-radius:20px;padding:3px 12px;font-size:0.78rem;color:var(--text-muted);white-space:nowrap">
          ✂ {{ $r->product_name }}
        </div>

         
        <div style="display:flex;align-items:center;gap:4px;margin-left:auto">
          <span style="letter-spacing:2px;font-size:1.1rem;color:#f0a500">
            @for($i=0;$i<5;$i++){{ $i < $r->stars ? '★' : '☆' }}@endfor
          </span>
          <span style="font-size:0.78rem;color:var(--text-muted);font-weight:600">{{ $r->stars }}/5</span>
        </div>

         
        @if($r->allowed)
          <span class="badge-adm badge-adm--approved">✅ Опубликован</span>
        @else
          <span class="badge-adm badge-adm--pending">⏳ Ожидает</span>
        @endif
      </div>

       
      <div style="background:var(--cream-light);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;font-size:0.92rem;line-height:1.7;color:var(--text);position:relative">
        <span style="position:absolute;top:8px;left:10px;font-size:1.6rem;color:var(--gold-light);line-height:1;font-family:Georgia,serif;user-select:none">"</span>
        <div style="padding-left:18px">{{ $r->description }}</div>
      </div>
    </div>

     
    <div style="display:flex;flex-direction:column;justify-content:center;gap:8px;padding:20px 20px 20px 0;min-width:110px;align-items:flex-end">
      @if(!$r->allowed)
      <form method="POST" action="{{ route('admin:allowRewiew') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $r->id }}">
        <button type="submit" class="btn-adm btn-adm--success btn-adm--sm" style="white-space:nowrap;width:100%">
          ✅ Одобрить
        </button>
      </form>
      @endif
      <form method="POST" action="{{ route('admin:deleteRewiew') }}" onsubmit="return confirm('Удалить отзыв от «{{ addslashes($r->username) }}»?')">
        @csrf
        <input type="hidden" name="id" value="{{ $r->id }}">
        <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm" style="width:100%">
          🗑 Удалить
        </button>
      </form>
    </div>

  </div>
</div>
@empty
<div class="adm-card">
  <div class="adm-empty" style="padding:64px">
    <div class="adm-empty__icon">⭐</div>
    <div class="adm-empty__text">
      @if($filter === 'pending') Нет отзывов, ожидающих проверки
      @elseif($filter === 'approved') Нет опубликованных отзывов
      @else Отзывов пока нет
      @endif
    </div>
  </div>
</div>
@endforelse

@endsection
