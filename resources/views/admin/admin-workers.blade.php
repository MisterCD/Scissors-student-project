@extends('layouts.layout-admin')
@section('page-title', 'Мастера')

@section('content')
<div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start">

  <div class="adm-card">
    <div class="adm-card__head">
      <span class="adm-card__title">Мастера ({{ count($workers) }})</span>
    </div>
    <table class="adm-table">
      <thead>
        <tr><th>Фото</th><th>Имя / Email</th><th>Специализация</th><th>Описание</th><th>Действия</th></tr>
      </thead>
      <tbody>
        @forelse($workers as $w)
        <tr>
          <td>
            @if($w->avatar)
              <img class="adm-avatar" src="{{ Str::startsWith($w->avatar,'http') ? $w->avatar : asset('storage/'.$w->avatar) }}" alt="">
            @else
              <div class="adm-avatar" style="display:flex;align-items:center;justify-content:center;background:var(--gold-pale)">💈</div>
            @endif
          </td>
          <td>
            <strong>{{ $w->username }}</strong>
            <div style="font-size:0.8rem;color:var(--text-muted)">{{ $w->email }}</div>
          </td>
          <td><span class="badge-adm badge-adm--master">{{ $w->specilization }}</span></td>
          <td style="max-width:180px;font-size:0.83rem;color:var(--text-muted)">{{ Str::limit($w->description_title, 70) }}</td>
          <td>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
              <button class="btn-adm btn-adm--ghost btn-adm--sm" onclick="openEditWorker({{ $w->id }}, '{{ addslashes($w->specilization) }}', '{{ addslashes($w->description_title) }}')">✏️ Изм.</button>
              <form method="POST" action="{{ route('admin:deleteWorker') }}" onsubmit="return confirm('Удалить мастера {{ $w->username }}?')">
                @csrf
                <input type="hidden" name="id" value="{{ $w->id }}">
                <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="adm-empty"><div class="adm-empty__icon">💈</div><div class="adm-empty__text">Мастера не добавлены</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="display:flex;flex-direction:column;gap:16px">
    
    <div class="adm-card">
      <div class="adm-card__head"><span class="adm-card__title">Добавить мастера</span></div>
      <div class="adm-card__body">
        <form method="POST" action="{{ route('admin:createWorker') }}" class="adm-form">
          @csrf
          <div class="adm-field">
            <label>Пользователь (с ролью Мастер)</label>
            <select name="user_id" required>
              <option value="">— Выберите пользователя —</option>
              @foreach($masterUsers as $u)
                <option value="{{ $u->id }}">{{ $u->username }} ({{ $u->email }})</option>
              @endforeach
            </select>
          </div>
          <div class="adm-field">
            <label>Специализация</label>
            <input type="text" name="specilization" required maxlength="100" placeholder="Стрижки, укладки">
          </div>
          <div class="adm-field">
            <label>Краткое описание</label>
            <input type="text" name="description_title" required maxlength="200" placeholder="Опытный стилист с 5 лет практики">
          </div>
          <button type="submit" class="btn-adm btn-adm--gold">+ Добавить мастера</button>
        </form>
      </div>
    </div>

    
    <div class="adm-card" id="edit-worker-card" style="display:none">
      <div class="adm-card__head">
        <span class="adm-card__title">Редактировать мастера</span>
        <button class="btn-adm btn-adm--ghost btn-adm--sm" onclick="document.getElementById('edit-worker-card').style.display='none'">×</button>
      </div>
      <div class="adm-card__body">
        <form method="POST" action="{{ route('admin:changeWorker') }}" class="adm-form">
          @csrf
          <input type="hidden" name="id" id="edit-worker-id">
          <div class="adm-field">
            <label>Специализация</label>
            <input type="text" name="specilization" id="edit-worker-spec" required maxlength="100">
          </div>
          <div class="adm-field">
            <label>Краткое описание</label>
            <input type="text" name="description_title" id="edit-worker-desc" required maxlength="200">
          </div>
          <button type="submit" class="btn-adm btn-adm--primary">Сохранить</button>
        </form>
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card__body" style="font-size:0.83rem;color:var(--text-muted);line-height:1.6">
        <strong>💡 Как добавить мастера:</strong><br>
        1. Зайдите в раздел «Пользователи»<br>
        2. Смените роль нужного пользователя на «Мастер»<br>
        3. Вернитесь сюда и выберите его в списке
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openEditWorker(id, spec, desc) {
  document.getElementById('edit-worker-id').value = id;
  document.getElementById('edit-worker-spec').value = spec;
  document.getElementById('edit-worker-desc').value = desc;
  document.getElementById('edit-worker-card').style.display = '';
}
</script>
@endsection
