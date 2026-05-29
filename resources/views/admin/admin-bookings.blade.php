@extends('layouts.layout-admin')
@section('page-title', 'Записи на услуги')

@section('content')
<div class="adm-card">
  <div class="adm-card__head" style="flex-wrap:wrap;gap:12px">
    <span class="adm-card__title">Записи ({{ count($bookings) }})</span>
    <div class="adm-filters">
      @foreach(['all'=>'Все','waiting'=>'Ожидают','confirmed'=>'Подтверждены','cancelled'=>'Отменены'] as $key=>$label)
        <a href="{{ route("admin:admin", ['type'=>'bookings','filter'=>$key]) }}"
           class="adm-filter-btn {{ $filter===$key ? 'active' : '' }}">{{ $label }}</a>
      @endforeach
    </div>
  </div>
  <div style="overflow-x:auto">
  <table class="adm-table">
    <thead>
      <tr><th>ID</th><th>Клиент</th><th>Мастер</th><th>Услуга</th><th>Дата</th><th>Время</th><th>Цена</th><th>Статус</th><th>Действия</th></tr>
    </thead>
    <tbody>
      @forelse($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>
          <strong style="font-size:0.88rem">{{ $b->client_name }}</strong>
          <div style="font-size:0.77rem;color:var(--text-muted)">{{ $b->client_email }}</div>
        </td>
        <td style="font-size:0.88rem">{{ $b->worker_name }}</td>
        <td style="font-size:0.85rem">{{ $b->product_name }}</td>
        <td style="font-size:0.82rem;white-space:nowrap">{{ \Carbon\Carbon::parse($b->date)->format('d.m.Y') }}</td>
        <td style="font-size:0.82rem;white-space:nowrap">{{ $b->time ?? '—' }}</td>
        <td style="font-size:0.85rem;white-space:nowrap">{{ number_format($b->product_cost, 0, ',', ' ') }} ₽</td>
        <td>
          @if($b->status === 'confirmed')
            <span class="badge-adm badge-adm--confirmed">Подтверждена</span>
          @elseif($b->status === 'cancelled')
            <span class="badge-adm badge-adm--cancelled">Отменена</span>
          @else
            <span class="badge-adm badge-adm--waiting">Ожидает</span>
          @endif
        </td>
        <td>
          <div style="display:flex;gap:5px;flex-wrap:wrap">
            @if($b->status === 'waiting')
            <form method="POST" action="{{ route('admin:allowBooking') }}">
              @csrf
              <input type="hidden" name="id" value="{{ $b->id }}">
              <button type="submit" class="btn-adm btn-adm--success btn-adm--sm">✅</button>
            </form>
            <form method="POST" action="{{ route('admin:cancelBooking') }}" onsubmit="return confirm('Отменить запись?')">
              @csrf
              <input type="hidden" name="id" value="{{ $b->id }}">
              <button type="submit" class="btn-adm btn-adm--ghost btn-adm--sm">✖ Отмена</button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin:deleteBooking') }}" onsubmit="return confirm('Удалить запись #{{ $b->id }}?')">
              @csrf
              <input type="hidden" name="id" value="{{ $b->id }}">
              <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="9"><div class="adm-empty"><div class="adm-empty__icon">📅</div><div class="adm-empty__text">Записей нет</div></div></td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
