@extends('layouts.layout-admin')
@section('page-title', 'Отзывы')

@section('content')
<div class="adm-card">
  <div class="adm-card__head" style="flex-wrap:wrap;gap:12px">
    <span class="adm-card__title">Отзывы ({{ count($rewiews) }})</span>
    <div class="adm-filters">
      @foreach(['all'=>'Все','pending'=>'Ожидают публикации','approved'=>'Опубликованы'] as $key=>$label)
        <a href="{{ route("admin:admin", ['type'=>'rewiews','filter'=>$key]) }}"
           class="adm-filter-btn {{ $filter===$key ? 'active' : '' }}">{{ $label }}</a>
      @endforeach
    </div>
  </div>
  <div style="overflow-x:auto">
  <table class="adm-table">
    <thead>
      <tr><th>Клиент</th><th>Услуга</th><th>Оценка</th><th>Отзыв</th><th>Дата</th><th>Статус</th><th>Действия</th></tr>
    </thead>
    <tbody>
      @forelse($rewiews as $r)
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:8px">
            @if($r->avatar)
              <img class="adm-avatar" style="width:28px;height:28px" src="{{ Str::startsWith($r->avatar,'http') ? $r->avatar : asset('storage/'.$r->avatar) }}" alt="">
            @endif
            <span style="font-size:0.88rem">{{ $r->username }}</span>
          </div>
        </td>
        <td style="font-size:0.85rem;color:var(--text-muted)">{{ $r->product_name }}</td>
        <td>
          <span style="color:#f0a500;letter-spacing:1px">
            @for($i=0;$i<5;$i++){{ $i < $r->stars ? '★' : '☆' }}@endfor
          </span>
        </td>
        <td style="max-width:220px;font-size:0.83rem">{{ Str::limit($r->description, 80) }}</td>
        <td style="font-size:0.8rem;color:var(--text-muted);white-space:nowrap">{{ \Carbon\Carbon::parse($r->date)->format('d.m.Y') }}</td>
        <td>
          @if($r->allowed)
            <span class="badge-adm badge-adm--approved">Опубликован</span>
          @else
            <span class="badge-adm badge-adm--pending">Ожидает</span>
          @endif
        </td>
        <td>
          <div style="display:flex;gap:6px;flex-wrap:wrap">
            @if(!$r->allowed)
            <form method="POST" action="{{ route('admin:allowRewiew') }}">
              @csrf
              <input type="hidden" name="id" value="{{ $r->id }}">
              <button type="submit" class="btn-adm btn-adm--success btn-adm--sm">✅ Одобрить</button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin:deleteRewiew') }}" onsubmit="return confirm('Удалить отзыв?')">
              @csrf
              <input type="hidden" name="id" value="{{ $r->id }}">
              <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7"><div class="adm-empty"><div class="adm-empty__icon">⭐</div><div class="adm-empty__text">Отзывов нет</div></div></td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
