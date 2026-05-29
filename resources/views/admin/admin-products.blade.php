@extends('layouts.layout-admin')
@section('page-title', 'Услуги')

@section('content')
<div class="adm-card">
  <div class="adm-card__head">
    <span class="adm-card__title">Список услуг ({{ count($products) }})</span>
    <button class="btn-adm btn-adm--gold" onclick="openModal('modal-add-product')">+ Добавить услугу</button>
  </div>
  <div style="overflow-x:auto">
  <table class="adm-table">
    <thead>
      <tr>
        <th>ID</th><th>Название</th><th>Тип</th><th>Цена</th><th>Время (мин)</th><th>Краткое описание</th><th>Действия</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td><strong>{{ $p->name }}</strong></td>
        <td><span class="badge-adm badge-adm--master">{{ $p->type_name }}</span></td>
        <td>{{ number_format($p->cost, 0, ',', ' ') }} ₽</td>
        <td>{{ $p->time }} мин</td>
        <td style="max-width:200px; color:var(--text-muted); font-size:0.83rem;">{{ Str::limit($p->description_title ?? '', 60) }}</td>
        <td>
          <div style="display:flex;gap:6px;flex-wrap:wrap">
            <button class="btn-adm btn-adm--ghost btn-adm--sm" onclick="openEditProduct({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->description_title ?? '') }}', '{{ $p->cost }}', '{{ $p->time }}', '{{ $p->type_id }}', '{{ $p->description }}')">✏️ Изм.</button>
            <form method="POST" action="{{ route('admin:deleteProduct') }}" onsubmit="return confirm('Удалить услугу «{{ $p->name }}»?')">
              @csrf
              <input type="hidden" name="id" value="{{ $p->id }}">
              <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑 Удалить</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7"><div class="adm-empty"><div class="adm-empty__icon">✂</div><div class="adm-empty__text">Услуги не найдены</div></div></td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>

<!-- MODAL: ADD PRODUCT -->
<div class="adm-modal-overlay" id="modal-add-product">
  <div class="adm-modal" style="max-width:600px">
    <div class="adm-modal__head">
      <span class="adm-modal__title">Новая услуга</span>
      <button class="adm-modal__close" onclick="closeModal('modal-add-product')">×</button>
    </div>
    <form method="POST" action="{{ route('admin:createProduct') }}" class="adm-form">
      @csrf
      <div class="adm-form__row adm-form__row--2">
        <div class="adm-field">
          <label>Название</label>
          <input type="text" name="name" required maxlength="120" placeholder="Мужская стрижка">
        </div>
        <div class="adm-field">
          <label>Тип</label>
          <select name="type_id" required>
            <option value="">— Выберите тип —</option>
            @foreach($types as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="adm-form__row adm-form__row--2">
        <div class="adm-field">
          <label>Цена (₽)</label>
          <input type="number" name="cost" required min="0" placeholder="1500">
        </div>
        <div class="adm-field">
          <label>Время (минут)</label>
          <input type="number" name="time" required min="1" placeholder="60">
        </div>
      </div>
      <div class="adm-field">
        <label>Краткое описание</label>
        <input type="text" name="description_title" required maxlength="200" placeholder="Профессиональная стрижка с укладкой">
      </div>
      <div class="adm-field">
        <label>Полное описание </label>
        <textarea name="description" required placeholder="#title hello world #endtitle"></textarea>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end">
        <button type="button" class="btn-adm btn-adm--ghost" onclick="closeModal('modal-add-product')">Отмена</button>
        <button type="submit" class="btn-adm btn-adm--gold">Создать услугу</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT PRODUCT -->
<div class="adm-modal-overlay" id="modal-edit-product">
  <div class="adm-modal" style="max-width:600px">
    <div class="adm-modal__head">
      <span class="adm-modal__title">Редактировать услугу</span>
      <button class="adm-modal__close" onclick="closeModal('modal-edit-product')">×</button>
    </div>
    <form method="POST" action="{{ route('admin:changeProduct') }}" class="adm-form" id="form-edit-product">
      @csrf
      <input type="hidden" name="id" id="edit-product-id">
      <input type="hidden" name="field" value="">
      <div class="adm-form__row adm-form__row--2">
        <div class="adm-field">
          <label>Название</label>
          <input type="text" name="name" id="edit-product-name" required maxlength="120">
        </div>
        <div class="adm-field">
          <label>Тип</label>
          <select name="type_id" id="edit-product-type" required>
            @foreach($types as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="adm-form__row adm-form__row--2">
        <div class="adm-field">
          <label>Цена (₽)</label>
          <input type="number" name="cost" id="edit-product-cost" required min="0">
        </div>
        <div class="adm-field">
          <label>Время (минут)</label>
          <input type="number" name="time" id="edit-product-time" required min="1">
        </div>
      </div>
      <div class="adm-field">
        <label>Краткое описание</label>
        <input type="text" name="description_title" id="edit-product-desc-title" required maxlength="200">
      </div>
      <div class="adm-field">
        <label>Полное описание </label>
        <textarea name="description" id="product-description" required placeholder="#title hello world #endtitle"></textarea>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end">
        <button type="button" class="btn-adm btn-adm--ghost" onclick="closeModal('modal-edit-product')">Отмена</button>
        <button type="submit" class="btn-adm btn-adm--primary">Сохранить</button>
      </div>
    </form>
  </div>
</div>

@endsection
@section('scripts')
<script>
function openEditProduct(id, name, descTitle, cost, time, typeId, desc) {
  document.getElementById('edit-product-id').value = id;
  document.getElementById('edit-product-name').value = name;
  document.getElementById('edit-product-desc-title').value = descTitle;
  document.getElementById('edit-product-cost').value = cost;
  document.getElementById('edit-product-time').value = time;
  document.getElementById('edit-product-type').value = typeId;
  document.getElementById('product-description').value = desc;
  openModal('modal-edit-product');
}
</script>
@endsection
