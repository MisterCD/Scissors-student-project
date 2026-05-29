@extends('layouts.layout-admin')
@section('page-title', 'Новости')

@section('content')
<div style="display:grid;grid-template-columns:1fr 400px;gap:24px;align-items:start">

  
  <div class="adm-card">
    <div class="adm-card__head">
      <span class="adm-card__title">Новости ({{ count($news) }})</span>
    </div>
    <table class="adm-table">
      <thead>
        <tr><th>Обложка</th><th>Заголовок</th><th>Тип</th><th>Дата</th><th>Действия</th></tr>
      </thead>
      <tbody>
        @forelse($news as $n)
        <tr>
          <td>
            @if($n->title_image_path)
              <img class="adm-img-thumb" src="{{ Str::startsWith($n->title_image_path,'http') ? $n->title_image_path : asset('storage/'.$n->title_image_path) }}" alt="">
            @else
              <div class="adm-img-thumb" style="display:flex;align-items:center;justify-content:center;background:var(--gold-pale);font-size:1.2rem">📰</div>
            @endif
          </td>
          <td>
            <strong style="font-size:0.9rem">{{ $n->name }}</strong>
            <div style="font-size:0.78rem;color:var(--text-muted);margin-top:2px">{{ Str::limit($n->description_title, 60) }}</div>
          </td>
          <td><span class="badge-adm badge-adm--master">{{ $n->type_name }}</span></td>
          <td style="font-size:0.82rem;color:var(--text-muted);white-space:nowrap">{{ \Carbon\Carbon::parse($n->date)->format('d.m.Y') }}</td>
          <td>
            <form method="POST" action="{{ route('admin:deleteNews') }}" onsubmit="return confirm('Удалить новость «{{ $n->name }}»?')">
              @csrf
              <input type="hidden" name="id" value="{{ $n->id }}">
              <button type="submit" class="btn-adm btn-adm--danger btn-adm--sm">🗑 Удалить</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="adm-empty"><div class="adm-empty__icon">📰</div><div class="adm-empty__text">Новостей нет</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  
  <div class="adm-card">
    <div class="adm-card__head"><span class="adm-card__title">Добавить новость</span></div>
    <div class="adm-card__body">
      <form method="POST" action="{{ route('admin:createNews') }}" enctype="multipart/form-data" class="adm-form">
        @csrf
        <div class="adm-field">
          <label>Заголовок</label>
          <input type="text" name="name" required maxlength="200" placeholder="Новая акция этой весной">
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
        <div class="adm-field">
          <label>Краткое описание</label>
          <input type="text" name="description_title" required maxlength="200" placeholder="Скидки на все виды стрижек">
        </div>
        <div class="adm-field">
          <label>Полный текст</label>
          <textarea name="description" required style="min-height:120px" placeholder="Текст новости..."></textarea>
        </div>
        <div class="adm-field">
          <label>Изображение-обложка (необязательно)</label>
          <input type="file" name="title_image" accept="image/*" style="background:var(--cream-light);padding:8px;border:1.5px solid var(--border);border-radius:var(--radius)">
        </div>
        <button type="submit" class="btn-adm btn-adm--gold">+ Создать новость</button>
      </form>
    </div>
  </div>

</div>
@endsection
