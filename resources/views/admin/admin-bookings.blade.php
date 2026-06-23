@extends('layouts.layout-admin')
@section('page-title', 'Записи на услуги')

@section('content')

@php
  $all       = collect($bookings);
  $waiting   = $all->where('status', 0)->count();
  $confirmed = $all->where('status', 1)->count();
  $cancelled = $all->where('status', 2)->count();
  $total     = count($bookings);
  $revenue   = $all->where('status', 1)->sum('product_cost');
@endphp

  
@if(session('success_message'))
  <div style="padding:14px 18px;background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7;border-radius:8px;margin-bottom:18px;font-size:0.9rem">
    ✅ {{ session('success_message') }}
  </div>
@endif
@if(session('error_message'))
  <div style="padding:14px 18px;background:#fdecea;color:#c62828;border:1px solid #ef9a9a;border-radius:8px;margin-bottom:18px;font-size:0.9rem">
    ⚠️ {{ session('error_message') }}
  </div>
@endif

  
<div class="adm-stats" style="margin-bottom:24px">
  <div class="adm-stat">
    <div style="font-size:1.3rem;margin-bottom:6px">📅</div>
    <div class="adm-stat__num">{{ $total }}</div>
    <div class="adm-stat__label">Всего записей</div>
  </div>
  <div class="adm-stat">
    <div style="font-size:1.3rem;margin-bottom:6px">⏳</div>
    <div class="adm-stat__num" style="color:#e65100">{{ $waiting }}</div>
    <div class="adm-stat__label">Ожидают решения</div>
  </div>
  <div class="adm-stat">
    <div style="font-size:1.3rem;margin-bottom:6px">✅</div>
    <div class="adm-stat__num" style="color:#2e7d32">{{ $confirmed }}</div>
    <div class="adm-stat__label">Подтверждено</div>
  </div>
  <div class="adm-stat">
    <div style="font-size:1.3rem;margin-bottom:6px">💰</div>
    <div class="adm-stat__num">{{ number_format($revenue, 0, ',', ' ') }} ₽</div>
    <div class="adm-stat__label">Выручка</div>
  </div>
</div>

  
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
  <div class="adm-filters">
    @foreach(['all'=>'Все',0=>"Ожидают ($waiting)",1=>"Подтверждены ($confirmed)",2=>"Отменены ($cancelled)"] as $key=>$label)
      <a href="{{ route('admin:admin', ['type'=>'bookings','filter'=>$key]) }}"
         class="adm-filter-btn {{ $filter===$key ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
  </div>
  <span style="font-size:0.82rem;color:var(--text-muted)">{{ $total }} записей</span>
</div>

  
@forelse($bookings as $b)
@php
  $status      = $b->status;
  $isPending   = $status === 0;
  $isConfirmed = $status === 1;
  $isCancelled = $status === 2;
  $accent      = $isConfirmed ? '#4a7c59' : ($isCancelled ? '#c0392b' : '#c9a84c');
@endphp

<div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);margin-bottom:12px;display:flex;overflow:hidden">

    
  <div style="width:5px;background:{{ $accent }};flex-shrink:0"></div>

    
  <div style="flex:1;padding:18px 22px">

      
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px">
      <span style="font-size:0.72rem;font-weight:700;color:var(--text-muted);background:#f7f4ef;border:1px solid var(--border);border-radius:4px;padding:2px 8px">#{{ $b->id }}</span>

      @if($isConfirmed)
        <span class="badge-adm badge-adm--confirmed">✅ Подтверждена</span>
      @elseif($isCancelled)
        <span class="badge-adm badge-adm--cancelled">✖ Отменена</span>
      @else
        <span class="badge-adm badge-adm--waiting">⏳ Ожидает</span>
      @endif

      <span style="font-size:0.84rem;color:var(--text-muted);margin-left:auto">
        🗓 {{ \Carbon\Carbon::parse($b->date)->format('d.m.Y') }}
        @if($b->time) &nbsp;·&nbsp; 🕐 {{ $b->time }} @endif
      </span>
    </div>

      
    <div style="display:flex;gap:16px;align-items:stretch">

        
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;flex:1">
        <div style="background:#faf8f4;border:1px solid var(--border);border-radius:6px;padding:11px 14px">
          <div style="font-size:0.67rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:5px">👤 Клиент</div>
          <div style="font-size:0.9rem;font-weight:600">{{ $b->client_name }}</div>
          <div style="font-size:0.77rem;color:var(--text-muted);margin-top:2px">{{ $b->client_email }}</div>
        </div>
        <div style="background:#faf8f4;border:1px solid var(--border);border-radius:6px;padding:11px 14px">
          <div style="font-size:0.67rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:5px">💈 Мастер</div>
          <div style="font-size:0.9rem;font-weight:600">{{ $b->worker_name }}</div>
        </div>
        <div style="background:#faf8f4;border:1px solid var(--border);border-radius:6px;padding:11px 14px">
          <div style="font-size:0.67rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:5px">✂ Услуга</div>
          <div style="font-size:0.9rem;font-weight:600">{{ $b->product_name }}</div>
          <div style="font-size:0.88rem;color:var(--gold);font-weight:700;margin-top:2px">{{ number_format($b->product_cost, 0, ',', ' ') }} ₽</div>
        </div>
      </div>

        
      <div style="display:flex;flex-direction:column;gap:7px;min-width:138px;flex-shrink:0">

        @if($isPending)
          <form method="POST" action="{{ route('admin:allowBooking') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $b->id }}">
            <button type="submit" class="btn-adm btn-adm--success" style="width:100%;display:flex;justify-content:center">
              ✅ Подтвердить
            </button>
          </form>
          <form method="POST" action="{{ route('admin:cancelBooking') }}" onsubmit="return confirm('Отменить запись #{{ $b->id }}?')">
            @csrf
            <input type="hidden" name="id" value="{{ $b->id }}">
            <button type="submit" class="btn-adm btn-adm--ghost" style="width:100%;display:flex;justify-content:center">
              ✖ Отменить
            </button>
          </form>

        @elseif($isConfirmed)
          <form method="POST" action="{{ route('admin:cancelBooking') }}" onsubmit="return confirm('Отменить подтверждённую запись #{{ $b->id }}?')">
            @csrf
            <input type="hidden" name="id" value="{{ $b->id }}">
            <button type="submit" class="btn-adm btn-adm--ghost" style="width:100%;display:flex;justify-content:center">
              ✖ Отменить
            </button>
          </form>

        @elseif($isCancelled)
          <form method="POST" action="{{ route('admin:allowBooking') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $b->id }}">
            <button type="submit" class="btn-adm btn-adm--success" style="width:100%;display:flex;justify-content:center">
              ↩ Восстановить
            </button>
          </form>
        @endif

        <form method="POST" action="{{ route('admin:deleteBooking') }}" onsubmit="return confirm('Удалить запись #{{ $b->id }} без возможности восстановления?')">
          @csrf
          <input type="hidden" name="id" value="{{ $b->id }}">
          <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm" style="width:100%;display:flex;justify-content:center">
            🗑 Удалить
          </button>
        </form>

      </div>
    </div>
  </div>
</div>

@empty
<div class="adm-card">
  <div class="adm-empty" style="padding:64px">
    <div class="adm-empty__icon">📅</div>
    <div class="adm-empty__text">
      @if($filter==='waiting') Нет записей, ожидающих подтверждения
      @elseif($filter==='confirmed') Нет подтверждённых записей
      @elseif($filter==='cancelled') Нет отменённых записей
      @else Записей пока нет
      @endif
    </div>
  </div>
</div>
@endforelse

@endsection
