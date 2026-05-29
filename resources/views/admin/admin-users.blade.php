@extends('layouts.layout-admin')
@section('page-title', 'Пользователи')

@section('content')
<div class="adm-card">
  <div class="adm-card__head" style="flex-wrap:wrap;gap:12px">
    <span class="adm-card__title">Пользователи ({{ count($users) }})</span>
    <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
      
      <div class="adm-filters">
        @foreach(['all'=>'Все','user'=>'Клиенты','master'=>'Мастера','admin'=>'Администраторы'] as $key=>$label)
          <a href="{{ route('admin:admin', ['type'=>'users','filter'=>$key,'search'=>$search]) }}"
             class="adm-filter-btn {{ $filter===$key ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
      </div>
      
      <form method="GET" action="{{ route("admin:admin") }}" class="adm-search">
        <input type="hidden" name="type" value="users">
        <input type="hidden" name="filter" value="{{ $filter }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Поиск по имени/email">
        <button type="submit">🔍</button>
      </form>
    </div>
  </div>
  <div style="overflow-x:auto">
  <table class="adm-table">
    <thead>
      <tr><th>ID</th><th>Аватар</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Действия</th></tr>
    </thead>
    <tbody>
      @forelse($users as $u)
      <tr>
        <td>{{ $u->id }}</td>
        <td>
          @if($u->avatar)
            <img class="adm-avatar" src="{{ Str::startsWith($u->avatar,'http') ? $u->avatar : asset('storage/'.$u->avatar) }}" alt="">
          @else
            <div class="adm-avatar" style="display:flex;align-items:center;justify-content:center;font-size:1.1rem;background:var(--gold-pale)">👤</div>
          @endif
        </td>
        <td><strong>{{ $u->username }}</strong></td>
        <td style="color:var(--text-muted);font-size:0.85rem">{{ $u->email }}</td>
        <td style="color:var(--text-muted);font-size:0.85rem">{{ $u->tel ?? '—' }}</td>
        <td>
          @if($u->status_id === 2)
            <span class="badge-adm badge-adm--admin">Админ</span>
          @elseif($u->status_id === 1)
            <span class="badge-adm badge-adm--master">Мастер</span>
          @else
            <span class="badge-adm badge-adm--user">Клиент</span>
          @endif
        </td>
        <td>
          <div style="display:flex;gap:6px;flex-wrap:wrap">
            <button class="btn-adm btn-adm--ghost btn-adm--sm" onclick="openRoleModal({{ $u->id }}, '{{ addslashes($u->username) }}', {{ $u->status_id }})">🔑 Роль</button>
            @if(session('user_id') != $u->id)
            <form method="POST" action="{{ route('admin:deleteUser') }}" onsubmit="return confirm('Удалить пользователя «{{ $u->username }}»? Все его данные будут удалены.')">
              @csrf
              <input type="hidden" name="id" value="{{ $u->id }}">
              <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑</button>
            </form>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="7"><div class="adm-empty"><div class="adm-empty__icon">👤</div><div class="adm-empty__text">Пользователи не найдены</div></div></td></tr>
      @endforelse
    </tbody>
  </table>
  </div>
</div>


<div class="adm-modal-overlay" id="modal-role">
  <div class="adm-modal">
    <div class="adm-modal__head">
      <span class="adm-modal__title">Изменить роль: <span id="role-username"></span></span>
      <button class="adm-modal__close" onclick="closeModal('modal-role')">×</button>
    </div>
    <form method="POST" action="{{ route('admin:changeUserRole') }}" class="adm-form">
      @csrf
      <input type="hidden" name="id" id="role-user-id">
      <div class="adm-field">
        <label>Новая роль</label>
        <select name="role" id="role-select" required>
          <option value="user">Клиент</option>
          <option value="master">Мастер</option>
          <option value="admin">Администратор</option>
        </select>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end">
        <button type="button" class="btn-adm btn-adm--ghost" onclick="closeModal('modal-role')">Отмена</button>
        <button type="submit" class="btn-adm btn-adm--primary">Сохранить</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openRoleModal(id, name, statusId) {
  document.getElementById('role-user-id').value = id;
  document.getElementById('role-username').textContent = name;
  const roles = ['user','master','admin'];
  document.getElementById('role-select').value = roles[statusId] || 'user';
  openModal('modal-role');
}
</script>
@endsection
