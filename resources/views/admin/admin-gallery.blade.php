@extends('layouts.layout-admin')
@section('page-title', 'Галерея')

@section('content')
<div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start">

  
  <div class="adm-card">
    <div class="adm-card__head" style="flex-wrap:wrap;gap:12px">
      <span class="adm-card__title">Изображения ({{ count($images) }})</span>
      <div class="adm-filters">
        <a href="{{ route("admin:admin", ['type'=>'gallery','filter'=>'all']) }}"
           class="adm-filter-btn {{ $filter==='all' ? 'active' : '' }}">Все</a>
        @foreach($types as $t)
          <a href="{{ route("admin:admin", ['type'=>'gallery','filter'=>$t->id]) }}"
             class="adm-filter-btn {{ $filter==$t->id ? 'active' : '' }}">{{ $t->name }}</a>
        @endforeach
      </div>
    </div>
    <div style="padding:16px;display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:12px">
      @forelse($images as $img)
      <div style="position:relative;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;background:var(--cream)">
        <img src="{{ Str::startsWith($img->path,'http') ? $img->path : asset('storage/'.$img->path) }}"
             alt="" style="width:100%;height:110px;object-fit:cover;display:block">
        <div style="padding:6px 8px;background:var(--white)">
          <span style="font-size:0.72rem;color:var(--text-muted)">{{ $img->type_name }}</span>
        </div>
        <form method="POST" action="{{ route('admin:deleteImage') }}" onsubmit="return confirm('Удалить фото?')"
              style="position:absolute;top:4px;right:4px">
          @csrf
          <input type="hidden" name="id" value="{{ $img->id }}">
          <button type="submit" style="background:rgba(0,0,0,0.6);color:white;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:0.8rem;line-height:1;display:flex;align-items:center;justify-content:center">×</button>
        </form>
      </div>
      @empty
      <div class="adm-empty" style="grid-column:1/-1">
        <div class="adm-empty__icon">🖼</div>
        <div class="adm-empty__text">Изображений нет</div>
      </div>
      @endforelse
    </div>
  </div>

  <div style="display:flex;flex-direction:column;gap:16px">
    
    <div class="adm-card">
      <div class="adm-card__head"><span class="adm-card__title">Загрузить файл</span></div>
      <div class="adm-card__body">
        <form method="POST" action="{{ route('admin:uploadImage') }}" enctype="multipart/form-data" class="adm-form">
          @csrf
          <div class="adm-field">
            <label>Тип изображения</label>
            <select name="type_id" required>
              <option value="">— Выберите тип —</option>
              @foreach($types as $t)
                <option value="{{ $t->id }}">{{ $t->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="adm-field">
            <label>Файл (JPG, PNG, WebP до 10 МБ)</label>
            <input type="file" name="image" accept="image/*" required style="background:var(--cream-light);padding:8px;border:1.5px solid var(--border);border-radius:var(--radius)">
          </div>
          <button type="submit" class="btn-adm btn-adm--gold">⬆ Загрузить</button>
        </form>
      </div>
    </div>

    
    <div class="adm-card">
      <div class="adm-card__head"><span class="adm-card__title">Добавить по ссылке</span></div>
      <div class="adm-card__body">
        <form method="POST" action="{{ route('admin:addImageUrl') }}" class="adm-form">
          @csrf
          <div class="adm-field">
            <label>Тип изображения</label>
            <select name="type_id" required>
              <option value="">— Выберите тип —</option>
              @foreach($types as $t)
                <option value="{{ $t->id }}">{{ $t->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="adm-field">
            <label>URL изображения</label>
            <input type="url" name="path" required placeholder="https://example.com/photo.jpg">
          </div>
          <button type="submit" class="btn-adm btn-adm--primary">+ Добавить ссылку</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
