@extends('layouts.layout-admin')
@section('page-title', 'Типы услуг')

@section('content')
<div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start">

  <div class="adm-card">
    <div class="adm-card__head">
      <span class="adm-card__title">Типы услуг ({{ count($types) }})</span>
    </div>
    <table class="adm-table">
      <thead>
        <tr><th>ID</th><th>Название</th><th>Услуг</th><th>Действия</th></tr>
      </thead>
      <tbody>
        @forelse($types as $t)
        <tr>
          <td>{{ $t->id }}</td>
          <td><strong>{{ $t->name }}</strong></td>
          <td><span class="badge-adm badge-adm--master">{{ $t->product_count }}</span></td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn-adm btn-adm--ghost btn-adm--sm" onclick="openEditType({{ $t->id }}, '{{ addslashes($t->name) }}')">✏️ Изм.</button>
              @if($t->product_count == 0)
              <form method="POST" action="{{ route('admin:deleteType') }}" onsubmit="return confirm('Удалить тип «{{ $t->name }}»?')">
                @csrf
                <input type="hidden" name="id" value="{{ $t->id }}">
                <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑</button>
              </form>
              @else
              <button class="btn-adm btn-adm--ghost btn-adm--sm" disabled title="Нельзя удалить: есть услуги" style="opacity:0.4">🗑</button>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="4"><div class="adm-empty"><div class="adm-empty__icon">🏷</div><div class="adm-empty__text">Типы не найдены</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="display:flex;flex-direction:column;gap:16px">
    <!-- ADD TYPE -->
    <div class="adm-card">
      <div class="adm-card__head"><span class="adm-card__title">Добавить тип</span></div>
      <div class="adm-card__body">
        <form method="POST" action="{{ route('admin:createType') }}" class="adm-form">
          @csrf
          <div class="adm-field">
            <label>Название типа</label>
            <input type="text" name="name" required maxlength="120" placeholder="Стрижки">
          </div>
          <button type="submit" class="btn-adm btn-adm--gold">+ Создать тип</button>
        </form>
      </div>
    </div>

    <!-- EDIT TYPE -->
    <div class="adm-card" id="edit-type-card" style="display:none">
      <div class="adm-card__head">
        <span class="adm-card__title">Редактировать тип</span>
        <button class="btn-adm btn-adm--ghost btn-adm--sm" onclick="document.getElementById('edit-type-card').style.display='none'">×</button>
      </div>
      <div class="adm-card__body">
        <form method="POST" action="{{ route('admin:changeType') }}" class="adm-form" id="form-edit-type">
          @csrf
          <input type="hidden" name="id" id="edit-type-id">
          <div class="adm-field">
            <label>Название типа</label>
            <input type="text" name="name" id="edit-type-name" required maxlength="120">
          </div>
          <button type="submit" class="btn-adm btn-adm--primary">Сохранить</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openEditType(id, name) {
  document.getElementById('edit-type-id').value = id;
  document.getElementById('edit-type-name').value = name;
  document.getElementById('edit-type-card').style.display = '';
  document.getElementById('edit-type-card').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection
