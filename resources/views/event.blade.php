@extends("layouts/layout")
@section("content")
<style>

/* ══════════════════════════════════════════════
   NEWS ARTICLE PAGE — pure CSS, zero JS
══════════════════════════════════════════════ */

/* ── ARTICLE HERO ────────────────────────────── */
.art-hero {
  background: var(--charcoal);
  position: relative;
  overflow: hidden;
  padding: 72px 0 0;
}
.art-hero::before {
  content: '';
  position: absolute;
  width: 560px; height: 560px;
  border-radius: 50%;
  border: 72px solid rgba(201,168,76,.05);
  top: -160px; right: -130px;
  pointer-events: none;
}
.art-hero::after {
  content: '';
  position: absolute;
  width: 300px; height: 300px;
  border-radius: 50%;
  border: 44px solid rgba(201,168,76,.04);
  bottom: 60px; left: -80px;
  pointer-events: none;
}
.art-hero__inner {
  position: relative; z-index: 1;
  padding-bottom: 0;
  max-width: 820px;
}

/* Meta top row */
.art-meta-top {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}
.art-tag {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 4px 13px;
  border-radius: 20px;
  font-size: .68rem; font-weight: 700;
  letter-spacing: .12em; text-transform: uppercase;
}
.art-tag--promo { background: var(--gold); color: var(--white); }
.art-tag--news  { background: rgba(255,255,255,.1); color: rgba(255,255,255,.7); }
.art-tag--event { background: rgba(74,124,89,.3); color: #a8d5b5; }

.art-date {
  font-size: .78rem;
  color: rgba(255,255,255,.38);
}
.art-reading-time {
  font-size: .78rem;
  color: rgba(255,255,255,.38);
  display: flex; align-items: center; gap: 4px;
}

/* Title */
.art-hero__title {
  font-family: var(--font-display);
  font-size: clamp(2rem, 4.5vw, 3.2rem);
  font-weight: 900;
  color: var(--white);
  line-height: 1.12;
  margin-bottom: 18px;
}
.art-hero__title em { font-style: italic; color: var(--gold-light); }

.art-hero__lead {
  font-size: 1.05rem;
  color: rgba(255,255,255,.6);
  line-height: 1.72;
  max-width: 640px;
  margin-bottom: 28px;
}

/* Author row */
.art-author-row {
  display: flex;
  align-items: center;
  gap: 14px;
  padding-bottom: 32px;
}
.art-author-av {
  width: 44px; height: 44px;
  border-radius: 50%;
  background: linear-gradient(135deg,#4a2d3d,#6b4a5a);
  color: var(--white);
  font-family: var(--font-display);
  font-size: .85rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  border: 2px solid rgba(201,168,76,.4);
}
.art-author-name {
  font-weight: 600; font-size: .9rem;
  color: var(--white); display: block;
}
.art-author-role { font-size: .74rem; color: rgba(255,255,255,.38); }

/* Cover image strip */
.art-cover {
  width: 100%;
  height: 420px;
  background: linear-gradient(145deg,#3a2d50 0%,#1a1030 50%,#2a1d3d 100%);
  display: flex; align-items: center; justify-content: center;
  font-size: 9rem;
  opacity: .35;
  margin-top: 0;
  position: relative;
  overflow: hidden;
}
.art-cover::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, transparent 60%, var(--cream-light) 100%);
}

/* ── PAGE LAYOUT ─────────────────────────────── */
.art-layout {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 48px;
  align-items: start;
}
.art-sidebar {
  position: sticky;
  top: 84px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* ── ARTICLE BODY ────────────────────────────── */
.art-body { font-size: .96rem; color: var(--text-muted); line-height: 1.85; }
.art-body h2 {
  font-family: var(--font-display);
  font-size: 1.5rem; font-weight: 800;
  color: var(--charcoal);
  margin: 36px 0 14px;
  line-height: 1.2;
}
.art-body h3 {
  font-family: var(--font-display);
  font-size: 1.15rem; font-weight: 700;
  color: var(--charcoal);
  margin: 28px 0 10px;
}
.art-body p { margin-bottom: 16px; }
.art-body strong { color: var(--charcoal); }
.art-body em { font-style: italic; color: var(--charcoal); }
.art-body a { color: var(--gold); text-decoration: underline; text-underline-offset: 3px; }

/* Highlight / promo box */
.art-promo-box {
  background: var(--gold-pale);
  border: 2px solid var(--gold);
  border-radius: var(--radius-lg);
  padding: 24px 28px;
  margin: 28px 0;
  position: relative;
  overflow: hidden;
}
.art-promo-box::before {
  content: '20%';
  position: absolute;
  right: 16px; top: 50%;
  transform: translateY(-50%);
  font-family: var(--font-display);
  font-size: 5rem; font-weight: 900;
  color: rgba(201,168,76,.14);
  line-height: 1;
  pointer-events: none;
  user-select: none;
}
.art-promo-box__tag {
  font-size: .68rem; font-weight: 700;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 6px;
  display: block;
}
.art-promo-box__title {
  font-family: var(--font-display);
  font-size: 1.3rem; font-weight: 800;
  color: var(--charcoal);
  margin-bottom: 8px;
}
.art-promo-box__text {
  font-size: .88rem;
  color: var(--text-muted);
  line-height: 1.65;
  margin-bottom: 0;
}

/* Quote / blockquote */
.art-quote {
  border-left: 4px solid var(--gold);
  background: var(--cream);
  border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
  padding: 20px 24px;
  margin: 24px 0;
}
.art-quote p {
  font-family: var(--font-display);
  font-style: italic;
  font-size: 1.05rem;
  color: var(--charcoal);
  margin-bottom: 8px;
  line-height: 1.6;
}
.art-quote cite {
  font-size: .78rem;
  color: var(--text-muted);
  font-style: normal;
}

/* Services checklist in article */
.art-checklist {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin: 20px 0;
  list-style: none;
}
.art-checklist li {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-size: .9rem;
  color: var(--text-muted);
  line-height: 1.6;
}
.art-checklist li::before {
  content: '✓';
  width: 22px; height: 22px;
  border-radius: 50%;
  background: var(--gold);
  color: var(--white);
  font-size: .7rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  margin-top: 1px;
}

/* Price grid inside article */
.art-price-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 12px;
  margin: 24px 0;
}
.art-price-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 16px 18px;
  transition: all var(--transition);
}
.art-price-card:hover { border-color: var(--gold); transform: translateY(-2px); }
.art-price-card__name {
  font-weight: 600; font-size: .86rem;
  color: var(--charcoal); margin-bottom: 4px;
}
.art-price-card__old {
  font-size: .78rem;
  color: var(--text-muted);
  text-decoration: line-through;
  margin-bottom: 2px;
}
.art-price-card__new {
  font-family: var(--font-display);
  font-size: 1.3rem; font-weight: 800;
  color: var(--gold);
}
.art-price-card__discount {
  display: inline-block;
  background: var(--gold);
  color: var(--white);
  font-size: .65rem; font-weight: 700;
  letter-spacing: .06em;
  padding: 2px 7px; border-radius: 10px;
  margin-left: 6px;
  vertical-align: middle;
}

/* Divider */
.art-divider {
  height: 1px;
  background: var(--border);
  margin: 36px 0;
}

/* Conditions list */
.art-conditions {
  background: var(--cream);
  border-radius: var(--radius-lg);
  padding: 20px 24px;
  margin: 24px 0;
}
.art-conditions__title {
  font-weight: 600; font-size: .88rem;
  color: var(--charcoal); margin-bottom: 12px;
  display: flex; align-items: center; gap: 8px;
}
.art-conditions ul {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 7px;
}
.art-conditions ul li {
  font-size: .83rem;
  color: var(--text-muted);
  display: flex; gap: 8px;
  line-height: 1.55;
}
.art-conditions ul li::before {
  content: '›';
  color: var(--gold);
  font-weight: 700;
  flex-shrink: 0;
}

/* Gallery in article */
.art-gallery {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin: 24px 0;
}
.art-gal-item {
  border-radius: var(--radius-lg);
  overflow: hidden;
  aspect-ratio: 1;
  position: relative;
  cursor: pointer;
}
.art-gal-item:first-child { grid-column: span 2; aspect-ratio: 2/1; }
.art-gal-inner {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-size: 2.5rem; opacity: .18; color: var(--white);
  transition: transform .32s ease;
}
.art-gal-item:hover .art-gal-inner { transform: scale(1.06); }
.art-gal-item--a { background: linear-gradient(140deg,#3a2d50,#1a1030); }
.art-gal-item--b { background: linear-gradient(140deg,#4a2d3d,#2a1520); }
.art-gal-item--c { background: linear-gradient(140deg,#2d3a50,#111e30); }
.art-gal-item--d { background: linear-gradient(140deg,#3a3528,#201e14); }

/* Share buttons */
.art-share {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 20px 0;
  border-top: 1px solid var(--border);
  border-bottom: 1px solid var(--border);
  margin: 36px 0;
  flex-wrap: wrap;
}
.art-share__label {
  font-size: .8rem; font-weight: 600;
  color: var(--text-muted);
  letter-spacing: .06em;
  text-transform: uppercase;
  margin-right: 4px;
}
.art-share__btn {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 8px 16px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius);
  font-size: .8rem; font-weight: 500;
  color: var(--charcoal);
  background: var(--white);
  cursor: pointer;
  transition: all var(--transition);
  text-decoration: none;
}
.art-share__btn:hover {
  border-color: var(--charcoal);
  background: var(--charcoal);
  color: var(--white);
}

/* Tags at bottom */
.art-tags-row {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 8px;
}
.art-tag-link {
  padding: 5px 13px;
  background: var(--cream);
  border: 1.5px solid var(--border);
  border-radius: 20px;
  font-size: .78rem; font-weight: 500;
  color: var(--charcoal);
  transition: all var(--transition);
}
.art-tag-link:hover {
  border-color: var(--gold);
  background: var(--gold-pale);
  color: var(--charcoal);
}

/* ── AUTHOR CARD ─────────────────────────────── */
.author-card {
  background: var(--cream);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 24px;
  display: flex;
  gap: 18px;
  align-items: flex-start;
  margin-bottom: 48px;
}
.author-card__av {
  width: 64px; height: 64px;
  border-radius: 50%;
  background: linear-gradient(135deg,#4a2d3d,#6b4a5a);
  color: var(--white);
  font-family: var(--font-display);
  font-size: 1.2rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.author-card__name {
  font-family: var(--font-display);
  font-size: 1rem; font-weight: 700;
  color: var(--charcoal); margin-bottom: 2px;
}
.author-card__role { font-size: .78rem; color: var(--gold); margin-bottom: 8px; }
.author-card__bio { font-size: .84rem; color: var(--text-muted); line-height: 1.65; }
.author-card__link {
  display: inline-block; margin-top: 10px;
  font-size: .78rem; color: var(--gold);
  font-weight: 500;
  padding: 5px 14px;
  border: 1.5px solid var(--gold);
  border-radius: 20px;
  transition: all var(--transition);
}
.author-card__link:hover { background: var(--gold); color: var(--white); }

/* ── RELATED ARTICLES ────────────────────────── */
.related-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 20px;
}
.rel-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  transition: all var(--transition);
}
.rel-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.rel-card__img {
  height: 140px;
  display: flex; align-items: center; justify-content: center;
  font-size: 3rem; opacity: .3; color: var(--white);
}
.rel-card__img--a { background: linear-gradient(135deg,#2d4a3d,#1a3025); }
.rel-card__img--b { background: linear-gradient(135deg,#3a2d50,#1a1030); }
.rel-card__img--c { background: linear-gradient(135deg,#4a3d2d,#2a2015); }
.rel-card__body { padding: 16px 18px; }
.rel-card__tag {
  font-size: .66rem; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: var(--gold); margin-bottom: 6px;
}
.rel-card__title {
  font-family: var(--font-display);
  font-size: .95rem; font-weight: 700;
  color: var(--charcoal); line-height: 1.35;
  margin-bottom: 8px;
}
.rel-card__date { font-size: .74rem; color: var(--text-muted); }

/* ── SIDEBAR CARDS ───────────────────────────── */
.sb-promo-card {
  background: var(--charcoal);
  border-radius: var(--radius-lg);
  padding: 24px;
  color: var(--white);
  text-align: center;
}
.sb-promo-card__discount {
  font-family: var(--font-display);
  font-size: 4rem; font-weight: 900;
  color: var(--gold-light);
  line-height: 1;
  margin-bottom: 4px;
}
.sb-promo-card__title {
  font-family: var(--font-display);
  font-size: 1rem; font-weight: 700;
  color: var(--white); margin-bottom: 8px;
}
.sb-promo-card__text {
  font-size: .82rem; color: rgba(255,255,255,.5);
  line-height: 1.6; margin-bottom: 16px;
}
.sb-promo-card__deadline {
  font-size: .75rem;
  color: var(--gold-light);
  margin-bottom: 14px;
  display: flex; align-items: center; justify-content: center; gap: 5px;
}

.sb-info-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 20px;
}
.sb-info-card__title {
  font-family: var(--font-display);
  font-size: .93rem; font-weight: 700;
  color: var(--charcoal); margin-bottom: 14px;
}
.sb-info-row {
  display: flex; gap: 10px;
  font-size: .82rem; color: var(--text-muted);
  margin-bottom: 9px; align-items: flex-start;
}
.sb-info-row:last-child { margin-bottom: 0; }

/* Table of contents (CSS only) */
.toc {
  background: var(--cream);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 18px 20px;
}
.toc__title {
  font-size: .7rem; font-weight: 700;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--text-muted); margin-bottom: 12px;
}
.toc__list {
  list-style: none;
  display: flex; flex-direction: column; gap: 2px;
}
.toc__item a {
  display: flex; align-items: baseline; gap: 8px;
  font-size: .82rem; color: var(--text-muted);
  padding: 5px 6px;
  border-radius: var(--radius);
  transition: all var(--transition);
  text-decoration: none;
}
.toc__item a:hover {
  background: var(--white);
  color: var(--gold);
}
.toc__item a::before {
  content: attr(data-num);
  font-size: .68rem;
  color: var(--gold);
  font-weight: 700;
  flex-shrink: 0;
}

/* Countdown timer (CSS only — visual) */
.countdown {
  background: linear-gradient(135deg,#1a1a1a,#2d2d2d);
  border-radius: var(--radius-lg);
  padding: 20px;
  text-align: center;
}
.countdown__label {
  font-size: .68rem; font-weight: 600;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--gold); margin-bottom: 12px;
}
.countdown__units {
  display: flex; justify-content: center; gap: 8px;
}
.countdown__unit {
  display: flex; flex-direction: column; align-items: center;
  gap: 4px;
}
.countdown__num {
  width: 44px; height: 44px;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-display);
  font-size: 1.2rem; font-weight: 800;
  color: var(--white);
}
.countdown__key {
  font-size: .62rem; color: rgba(255,255,255,.35);
  letter-spacing: .04em;
}
.countdown__sep {
  font-size: 1.2rem; color: rgba(255,255,255,.3);
  padding-top: 8px;
}

/* ── RESPONSIVE ──────────────────────────────── */
@media(max-width:900px){
  .art-layout { grid-template-columns: 1fr; }
  .art-sidebar { position: static; }
}
@media(max-width:600px){
  .art-cover { height: 240px; }
  .art-gallery { grid-template-columns: 1fr 1fr; }
  .art-gal-item:first-child { grid-column: span 2; aspect-ratio: 2/1; }
  .art-price-grid { grid-template-columns: 1fr 1fr; }
  .related-grid { grid-template-columns: 1fr; }
  .art-hero__title { font-size: 2rem; }
}
</style>
<!-- BREADCRUMB -->
<div class="breadcrumb">
  <div class="container breadcrumb__inner">
    <a href="{{ route("main") }}">Главная</a><span class="breadcrumb__sep">›</span>
    <a href="{{ route("main") }}#news">Новости</a><span class="breadcrumb__sep">›</span>
    <span>Весенняя скидка 20% на окрашивание</span>
  </div>
</div>

<!-- HERO -->
<section class="art-hero">
  <div class="container art-hero__inner">
    <h1 class="art-hero__title">
      
    </h1>
    <p class="art-hero__lead">
      
    </p>
  </div>
</section>

<!-- COVER IMAGE -->
<div class="art-cover">🎨</div>

<!-- MAIN CONTENT -->
<section class="section" style="background:var(--cream);padding-top:48px;">
  <div class="container art-layout">

    <!-- ══════ ARTICLE BODY ══════ -->
    <article>

      <div class="art-body">

        <!-- PROMO BOX -->
        <div class="art-promo-box">
          <span class="art-promo-box__tag">🎁 Специальное предложение</span>
          <div class="art-promo-box__title">Скидка 20% на всё окрашивание</div>
          <p class="art-promo-box__text">
            Акция действует с <strong>1 по 31 мая 2026</strong> года. Распространяется на все виды окрашивания: балаяж, омбре, мелирование, однотонное окрашивание, тонирование. Запись онлайн — дополнительная скидка 15% уже включена.
          </p>
        </div>

        <h2 id="about">О чём эта акция?</h2>
        <p>
          Каждую весну мы запускаем специальное предложение для наших клиентов — потому что весна это время перемен и новых образов. В этом году мы решили сделать скидку ещё больше: <strong>20% на все виды окрашивания</strong> в течение всего мая.
        </p>
        <p>
          Неважно, давно ли вы хотели попробовать балаяж или пришло время обновить уже привычный цвет — май идеальный момент. Тем более что наши колористы <a href="master.html">Мария Соколова</a> и <a href="master.html">Анна Николаева</a> освободили дополнительные слоты специально под период акции.
        </p>

        <!-- QUOTE -->
        <div class="art-quote">
          <p>"Весна — это лучшее время для перемен. Новый оттенок волос способен изменить настроение, добавить уверенности и по-новому раскрыть образ. Я всегда говорю клиенткам: не бойтесь экспериментировать."</p>
          <cite>— Мария Соколова, старший колорист Scissors</cite>
        </div>

        <h2 id="services">Какие услуги входят в акцию?</h2>
        <p>Скидка 20% распространяется на следующие услуги:</p>

        <ul class="art-checklist">
          <li>Балаяж и омбре — ручная техника плавного перехода цвета (любая длина волос)</li>
          <li>Однотонное окрашивание — более 200 оттенков, покраска по всей длине</li>
          <li>Мелирование — классическое, современное, тонирование прядей</li>
          <li>Тонирование — нейтрализация желтизны, корректировка оттенка</li>
          <li>Осветление — полное или частичное, подготовка к окрашиванию</li>
          <li>Комплексы — окрашивание + стрижка + укладка со скидкой на всё</li>
        </ul>



        <h2 id="gallery">Примеры работ в этот сезон</h2>
        <p>
          Вот несколько работ, которые наши мастера выполнили уже в мае — это как раз то, что сейчас на пике популярности:
        </p>

        <div class="art-gallery">
          <div class="art-gal-item art-gal-item--a"><div class="art-gal-inner">🎨</div></div>
          <div class="art-gal-item art-gal-item--b"><div class="art-gal-inner">✨</div></div>
          <div class="art-gal-item art-gal-item--c"><div class="art-gal-inner">💫</div></div>
          <div class="art-gal-item art-gal-item--d"><div class="art-gal-inner">🌅</div></div>
        </div>
        <p style="font-size:.8rem;color:var(--text-muted);text-align:center;margin-top:8px;">
          Больше работ — в нашей <a href="gallery.html">галерее</a>
        </p>

        <h2 id="conditions">Условия акции</h2>

        <div class="art-conditions">
          <div class="art-conditions__title">📋 Важные условия</div>
          <ul>
            <li>Акция действует с 1 по 31 мая 2026 года включительно</li>
            <li>Скидка предоставляется при записи через сайт или по телефону с упоминанием акции</li>
            <li>Акция не суммируется с другими персональными скидками и промокодами</li>
            <li>Распространяется на первый и повторные визиты</li>
            <li>Предварительная запись обязательна — вход в порядке живой очереди не учитывается</li>
            <li>Все материалы и расходники включены в стоимость</li>
            <li>Организация оставляет за собой право скорректировать цену после личной консультации с мастером</li>
          </ul>
        </div>

        <h2 id="howto">Как воспользоваться?</h2>
        <p>
          Всё просто — три шага:
        </p>
        <ul class="art-checklist">
          <li>Перейдите на <a href="booking.html">страницу онлайн-записи</a> или позвоните нам по номеру <a href="tel:+79001234567">+7 (900) 123-45-67</a></li>
          <li>Выберите услугу из категории «Окрашивание», мастера и удобное время</li>
          <li>При записи по телефону — скажите «Весенняя акция», при записи онлайн — скидка применится автоматически</li>
        </ul>

        <p>
          После записи вам придёт подтверждение на email. За 2 часа до визита — SMS-напоминание. Если вдруг понадобится перенести — это можно сделать в <a href="cabinet.html">личном кабинете</a> или по телефону не позднее чем за 2 часа до приёма.
        </p>

        <div class="art-divider"></div>

      </div><!-- /art-body -->

      <div class="art-divider"></div>

      <!-- RELATED ARTICLES -->
      
    </article>

  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container cta-section__inner">
    <div class="cta-section__text">
      <h2 class="cta-section__title">Успейте до конца мая!</h2>
      <p class="cta-section__sub">Скидка 20% на всё окрашивание — акция заканчивается 31 мая</p>
    </div>
    <div class="cta-section__actions">
      <a href="booking.html" class="btn btn--white">Записаться онлайн</a>
      <a href="tel:+79001234567" class="btn btn--outline-white">📞 Позвонить</a>
    </div>
  </div>
</section>
@endsection
