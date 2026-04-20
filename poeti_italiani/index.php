<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Database Poeti Italiani</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#1a1208; --parchment:#f5efe3; --parchment-dark:#e0d3bb;
  --gold:#b8860b; --gold-light:#d4a843; --rust:#8b3a2a;
  --cream:#fdf8f0; --shadow:rgba(26,18,8,0.13); --radius:4px;
}
*{margin:0;padding:0;box-sizing:border-box}
body{background:var(--cream);color:var(--ink);font-family:'EB Garamond',serif;min-height:100vh;
  background-image:radial-gradient(ellipse at 15% 10%,rgba(184,134,11,.07) 0%,transparent 50%),
                   radial-gradient(ellipse at 85% 90%,rgba(139,58,42,.05) 0%,transparent 50%)}

/* NAV */
nav{background:var(--ink);display:flex;align-items:center;justify-content:center;gap:2rem;padding:.7rem 2rem;position:sticky;top:0;z-index:500}
nav a{color:var(--parchment);font-family:'EB Garamond',serif;font-size:1rem;text-decoration:none;letter-spacing:.06em;opacity:.7;transition:opacity .2s;display:flex;align-items:center;gap:.4rem}
nav a:hover{opacity:1}
nav a.active{opacity:1;color:var(--gold-light);border-bottom:2px solid var(--gold-light);padding-bottom:2px}

/* HEADER */
header{background:var(--ink);padding:2.2rem 2rem 1.8rem;text-align:center;position:relative;overflow:hidden}
header::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(-45deg,transparent,transparent 10px,rgba(255,255,255,.015) 10px,rgba(255,255,255,.015) 20px)}
.h-ornament{color:var(--gold);font-size:.95rem;letter-spacing:.4em;text-transform:uppercase;font-style:italic;opacity:.8;margin-bottom:.35rem}
header h1{font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4.5vw,3.2rem);font-weight:900;color:var(--parchment);line-height:1.1;text-shadow:0 2px 12px rgba(0,0,0,.4)}
header h1 em{color:var(--gold-light);font-style:italic}
.h-rule{width:100px;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);margin:.8rem auto 0}

.wrap{max-width:1020px;margin:0 auto;padding:2rem 1.5rem}

/* SEARCH BOX */
.search-box{background:#fff;border:1px solid var(--parchment-dark);border-radius:var(--radius);
  padding:1.5rem 1.8rem;margin-bottom:1.8rem;box-shadow:0 4px 20px var(--shadow)}
.search-lbl{font-family:'Playfair Display',serif;font-size:.78rem;letter-spacing:.18em;
  text-transform:uppercase;color:var(--gold);display:block;margin-bottom:.7rem}
.search-row{display:flex;gap:.7rem;align-items:center}
.inp-wrap{position:relative;flex:1}
.inp-wrap svg{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--gold);pointer-events:none}
.search-input{width:100%;padding:.75rem 1rem .75rem 2.7rem;border:2px solid var(--parchment-dark);
  border-radius:var(--radius);font-family:'EB Garamond',serif;font-size:1.1rem;color:var(--ink);
  background:var(--cream);transition:border-color .2s;outline:none}
.search-input:focus{border-color:var(--gold)}
.search-input::placeholder{color:#c0aa80}
.btn-reset{padding:.75rem 1.2rem;background:transparent;border:2px solid var(--parchment-dark);
  border-radius:var(--radius);font-family:'EB Garamond',serif;font-size:.95rem;color:#999;
  cursor:pointer;transition:all .2s;white-space:nowrap;flex-shrink:0}
.btn-reset:hover{border-color:var(--rust);color:var(--rust)}
.res-count{margin-top:.6rem;font-style:italic;font-size:.88rem;color:#aaa}

/* CORRENTE HEADER */
#corrente-view{display:none;margin-bottom:1.4rem}
.corrente-header{background:var(--ink);border-radius:var(--radius);padding:1.2rem 1.6rem;margin-bottom:.9rem}
.corrente-header h2{font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--parchment);font-weight:700}
.corrente-header .periodo{font-size:.88rem;color:var(--gold-light);font-style:italic;margin-top:.2rem}
.corrente-desc{font-size:.95rem;line-height:1.65;color:#4a3c28;background:#fff;
  border:1px solid var(--parchment-dark);border-radius:var(--radius);padding:.9rem 1.2rem}

/* GRID */
#grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(278px,1fr));gap:1.3rem;margin-bottom:2rem}
.card{background:#fff;border:1px solid var(--parchment-dark);border-radius:var(--radius);
  overflow:hidden;box-shadow:0 2px 10px var(--shadow);cursor:pointer;
  transition:transform .2s,box-shadow .2s;display:flex;flex-direction:column}
.card:hover{transform:translateY(-3px);box-shadow:0 8px 26px rgba(26,18,8,.17)}
.card-img{height:150px;background:var(--parchment);display:flex;align-items:center;
  justify-content:center;overflow:hidden;position:relative;border-bottom:1px solid var(--parchment-dark)}
.card-img img{width:100%;height:100%;object-fit:cover}
.card-img-ph{display:flex;flex-direction:column;align-items:center;gap:.35rem;color:var(--gold);opacity:.4}
.card-img-ph svg{width:42px;height:42px}
.card-img-ph span{font-size:.7rem;letter-spacing:.05em}
.badge{position:absolute;top:7px;right:7px;background:var(--ink);color:var(--gold-light);
  font-size:.62rem;letter-spacing:.06em;text-transform:uppercase;padding:3px 8px;border-radius:2px;
  font-family:'Playfair Display',serif;max-width:145px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.card-body{padding:.85rem 1rem 1rem;flex:1}
.card-name{font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;color:var(--ink);margin-bottom:.1rem}
.card-dates{font-size:.83rem;color:var(--gold);font-style:italic;margin-bottom:.45rem}
.card-desc{font-size:.88rem;line-height:1.5;color:#4a3c28;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.card-foot{padding:.5rem 1rem;border-top:1px solid var(--parchment-dark);background:var(--cream);font-size:.78rem;color:#aaa;font-style:italic}
.empty{text-align:center;padding:3rem;color:#c0b090;grid-column:1/-1}
.empty p{font-style:italic;font-size:1.05rem;margin-top:.8rem}

/* MODAL */
.overlay{display:none;position:fixed;inset:0;background:rgba(10,7,3,.72);z-index:1000;padding:1.5rem;overflow-y:auto;backdrop-filter:blur(2px)}
.overlay.open{display:flex;align-items:flex-start;justify-content:center}
.modal{background:#fff;border-radius:6px;max-width:730px;width:100%;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.4);margin:auto;animation:mIn .22s ease}
@keyframes mIn{from{opacity:0;transform:translateY(18px) scale(.97)}to{opacity:1;transform:none}}
.modal-hd{background:var(--ink);padding:1.3rem 1.7rem;display:flex;align-items:flex-start;gap:1.2rem}
.portrait{width:92px;height:112px;background:var(--parchment);border:2px solid var(--gold);flex-shrink:0;overflow:hidden;display:flex;align-items:center;justify-content:center}
.portrait img{width:100%;height:100%;object-fit:cover}
.portrait-ph{color:var(--gold);opacity:.4;text-align:center;font-size:.6rem;padding:.4rem;letter-spacing:.04em;line-height:1.6}
.modal-titles{flex:1;min-width:0}
.m-corrente{font-size:.7rem;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);margin-bottom:.2rem}
.m-name{font-family:'Playfair Display',serif;font-size:clamp(1.3rem,3vw,1.85rem);font-weight:900;color:var(--parchment);line-height:1.1;margin-bottom:.3rem}
.m-dates{color:var(--gold-light);font-style:italic;font-size:.95rem;margin-bottom:.35rem}
.m-count{display:inline-flex;align-items:center;gap:.3rem;background:rgba(184,134,11,.15);border:1px solid rgba(184,134,11,.3);padding:3px 9px;border-radius:2px;font-size:.78rem;color:var(--gold-light)}
.btn-close{background:transparent;border:none;color:var(--parchment);cursor:pointer;opacity:.55;font-size:1.5rem;line-height:1;padding:4px;transition:opacity .2s;margin-left:auto;flex-shrink:0;align-self:flex-start}
.btn-close:hover{opacity:1}
.modal-body{padding:1.5rem 1.7rem}
.det-section{margin-bottom:1.3rem}
.det-lbl{font-family:'Playfair Display',serif;font-size:.74rem;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);margin-bottom:.3rem;display:flex;align-items:center;gap:.5rem}
.det-lbl::after{content:'';flex:1;height:1px;background:var(--parchment-dark)}
.det-txt{font-size:.97rem;line-height:1.65;color:#3a2e1a}
.chips{display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.2rem}
.chip{background:var(--parchment);border:1px solid var(--parchment-dark);padding:4px 11px;border-radius:2px;font-size:.86rem;font-style:italic;color:var(--ink)}
.chip-year{font-size:.73rem;color:#999;font-style:normal;margin-left:4px}
.upload-zone{border:2px dashed var(--parchment-dark);border-radius:var(--radius);padding:.85rem;text-align:center;background:var(--cream);transition:border-color .2s}
.upload-zone:hover{border-color:var(--gold)}
.upload-zone label{cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:.35rem;color:#aaa}
.upload-zone label svg{color:var(--gold);opacity:.6}
.upload-zone input{display:none}
.upload-hint{font-size:.75rem}
.upload-preview{width:100%;max-height:170px;object-fit:contain;margin-top:.5rem;border-radius:2px}
.bio-row{display:flex;gap:.65rem;align-items:center;flex-wrap:wrap}
.bio-inp{flex:1;min-width:180px;padding:.5rem .75rem;border:1px solid var(--parchment-dark);border-radius:var(--radius);font-family:'EB Garamond',serif;font-size:.93rem;background:var(--cream);color:var(--ink);outline:none;transition:border-color .2s}
.bio-inp:focus{border-color:var(--gold)}
.btn-go{padding:.5rem 1rem;background:var(--ink);color:var(--gold-light);border:none;border-radius:var(--radius);font-family:'EB Garamond',serif;font-size:.9rem;cursor:pointer;display:inline-flex;align-items:center;gap:.3rem;transition:background .2s}
.btn-go:hover{background:#2e2010}

footer{text-align:center;padding:2rem;font-size:.8rem;color:#c0b090;font-style:italic;border-top:1px solid var(--parchment-dark);margin-top:3rem}
footer a{color:var(--gold);text-decoration:none}
footer a:hover{text-decoration:underline}
</style>
</head>
<body>

<nav>
  <a href="index.php" class="active">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
    Poeti
  </a>
  <a href="opposizioni.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
    Correnti a confronto
  </a>
</nav>

<header>
  <div class="h-ornament">Letteratura Italiana</div>
  <h1>Database dei <em>Poeti</em> Italiani</h1>
  <div class="h-rule"></div>
</header>

<div class="wrap">

  <section class="search-box">
    <span class="search-lbl">Cerca per nome, anno o corrente letteraria</span>
    <div class="search-row">
      <div class="inp-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" class="search-input" id="q" placeholder="Es. Leopardi, 1798, Ermetismo, Verismo...">
      </div>
      <button class="btn-reset" onclick="resetSearch()">&#x2715; Azzera</button>
    </div>
    <div class="res-count" id="res-count"></div>
  </section>

  <div id="corrente-view">
    <div class="corrente-header">
      <h2 id="cv-nome"></h2>
      <div class="periodo" id="cv-periodo"></div>
    </div>
    <div class="corrente-desc" id="cv-desc"></div>
  </div>

  <div id="grid"></div>

</div>

<!-- MODAL -->
<div class="overlay" id="overlay">
  <div class="modal">
    <div class="modal-hd">
      <div class="portrait" id="m-portrait"><div class="portrait-ph">&#128247;<br>Nessuna<br>immagine</div></div>
      <div class="modal-titles">
        <div class="m-corrente" id="m-corrente"></div>
        <div class="m-name" id="m-name"></div>
        <div class="m-dates" id="m-dates"></div>
        <div class="m-count" id="m-count"></div>
      </div>
      <button class="btn-close" id="btn-close">&#x2715;</button>
    </div>
    <div class="modal-body">
      <div class="det-section">
        <div class="det-lbl">Caratteristiche della corrente</div>
        <div class="det-txt" id="m-caratteristiche"></div>
      </div>
      <div class="det-section">
        <div class="det-lbl">Opere principali</div>
        <div class="chips" id="m-opere"></div>
      </div>
      <div class="det-section">
        <div class="det-lbl">Biografia sintetica</div>
        <div class="det-txt" id="m-bio"></div>
      </div>
      <div class="det-section">
        <div class="det-lbl">Immagine del poeta</div>
        <div class="upload-zone">
          <label>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
            <span style="font-family:'Playfair Display',serif;font-size:.86rem">Clicca per caricare un'immagine</span>
            <span class="upload-hint">JPG &middot; PNG &middot; WEBP (max 5 MB)</span>
            <input type="file" id="img-input" accept="image/*">
          </label>
          <img id="upload-preview" class="upload-preview" alt="" style="display:none">
        </div>
        <div id="upload-msg" style="font-size:.8rem;margin-top:.4rem;font-style:italic;color:#999"></div>
      </div>
      <div class="det-section">
        <div class="det-lbl">Link alla biografia</div>
        <div class="bio-row">
          <input type="text" class="bio-inp" id="bio-link-inp" placeholder="Incolla qui l'URL della biografia...">
          <button class="btn-go" id="btn-bio">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Apri
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  Letteratura italiana &mdash; dal XIII al XX secolo &nbsp;|&nbsp;
  <a href="opposizioni.php">Correnti a confronto &rarr;</a>
</footer>

<script>
var currentId   = null;
var allPoeti    = [];
var allCorrenti = [];
var debT        = null;

window.onload = function() {
  loadAllData();
  document.getElementById('q').addEventListener('input', function(){
    clearTimeout(debT); debT = setTimeout(doSearch, 250);
  });
  document.getElementById('btn-close').addEventListener('click', closeModal);
  document.getElementById('overlay').addEventListener('click', function(e){
    if(e.target === document.getElementById('overlay')) closeModal();
  });
  document.getElementById('img-input').addEventListener('change', uploadImage);
  document.getElementById('btn-bio').addEventListener('click', function(){
    var url = document.getElementById('bio-link-inp').value.trim();
    if(url) window.open(url.indexOf('http')===0 ? url : 'https://'+url, '_blank');
  });
  document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeModal(); });
};

function apiFetch(params, cb) {
  var url='api.php?', parts=[];
  for(var k in params) parts.push(encodeURIComponent(k)+'='+encodeURIComponent(params[k]));
  url+=parts.join('&');
  var xhr=new XMLHttpRequest();
  xhr.open('GET',url,true);
  xhr.onreadystatechange=function(){
    if(xhr.readyState===4){
      try{ cb(null, JSON.parse(xhr.responseText).data); }
      catch(e){ cb('Errore'); }
    }
  };
  xhr.send();
}

function loadAllData() {
  apiFetch({action:'poeti', q:'', corrente_id:''}, function(err, data){
    if(err) return;
    allPoeti = data;
    renderGrid(allPoeti);
    document.getElementById('res-count').textContent = allPoeti.length + ' autori nel database';
  });
  apiFetch({action:'correnti'}, function(err, data){
    if(err) return;
    allCorrenti = data;
  });
}

// ── RICERCA UNIFICATA ─────────────────────────────────────────────────────
// Cerca per: nome completo, anno nascita, anno morte, nome corrente
function doSearch() {
  var q = document.getElementById('q').value.trim().toLowerCase();
  document.getElementById('corrente-view').style.display = 'none';

  if(!q) {
    renderGrid(allPoeti);
    document.getElementById('res-count').textContent = allPoeti.length + ' autori nel database';
    return;
  }

  // controlla se la query corrisponde esattamente a una corrente
  var matchedCorrente = null;
  for(var i=0; i<allCorrenti.length; i++) {
    if(allCorrenti[i].nome.toLowerCase() === q) {
      matchedCorrente = allCorrenti[i]; break;
    }
  }
  // oppure corrente parziale (solo se non ci sono match autori)
  var partialCorrente = null;
  for(var i=0; i<allCorrenti.length; i++) {
    if(allCorrenti[i].nome.toLowerCase().indexOf(q) >= 0) {
      partialCorrente = allCorrenti[i]; break;
    }
  }

  // filtra autori per: nome, anno nascita, anno morte, nome corrente
  var filtered = allPoeti.filter(function(p){
    var nome     = (p.nome||'').toLowerCase();
    var corrente = (p.corrente||'').toLowerCase();
    var nascita  = String(p.nascita||'');
    var morte    = String(p.morte||'');
    return nome.indexOf(q) >= 0
        || corrente.indexOf(q) >= 0
        || nascita.indexOf(q) >= 0
        || morte.indexOf(q) >= 0;
  });

  // se la query matcha una corrente E non ci sono autori col quel nome
  // mostra il banner della corrente
  var autoriConNomeUguale = allPoeti.filter(function(p){ return (p.nome||'').toLowerCase().indexOf(q)>=0; });
  if(partialCorrente && autoriConNomeUguale.length === 0) {
    showCorrenteHeader(partialCorrente);
  }

  renderGrid(filtered);
  var tot = filtered.length;
  document.getElementById('res-count').textContent = tot === allPoeti.length
    ? tot + ' autori nel database'
    : tot + ' risultat' + (tot===1?'o':'i') + ' trovati';
}

function showCorrenteHeader(c) {
  document.getElementById('cv-nome').textContent    = c.nome;
  document.getElementById('cv-periodo').textContent = c.periodo || '';
  document.getElementById('cv-desc').textContent    = c.descrizione || '';
  document.getElementById('corrente-view').style.display = 'block';
}

function resetSearch() {
  document.getElementById('q').value = '';
  document.getElementById('corrente-view').style.display = 'none';
  renderGrid(allPoeti);
  document.getElementById('res-count').textContent = allPoeti.length + ' autori nel database';
}

// ── GRID ──────────────────────────────────────────────────────────────────
function renderGrid(rows) {
  var grid = document.getElementById('grid');
  if(!rows || !rows.length) {
    grid.innerHTML = '<div class="empty"><svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg><p>Nessun autore trovato.</p></div>';
    return;
  }
  var html = '';
  for(var i=0; i<rows.length; i++){
    var p = rows[i];
    var img = p.immagine_path
      ? '<img src="uploads/'+escH(p.immagine_path)+'" alt="'+escH(p.nome)+'">'
      : '<div class="card-img-ph"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg><span>Aggiungi foto</span></div>';
    var dates = p.nascita ? p.nascita+' \u2013 '+(p.morte||'?') : 'Movimento / corrente';
    html += '<div class="card" onclick="openPoet('+p.id+')">'
      +'<div class="card-img">'+img+'<span class="badge">'+escH(p.corrente||'')+'</span></div>'
      +'<div class="card-body"><div class="card-name">'+escH(p.nome)+'</div>'
      +'<div class="card-dates">'+dates+'</div>'
      +'<div class="card-desc">'+escH(p.caratteristiche||'')+'</div></div>'
      +'<div class="card-foot">'+(p.n_opere>0 ? p.n_opere+' opere principali' : 'Movimento collettivo')+'</div>'
      +'</div>';
  }
  grid.innerHTML = html;
}

// ── MODAL ─────────────────────────────────────────────────────────────────
function openPoet(id) {
  currentId = id;
  apiFetch({action:'poeta', id:id}, function(err, p){
    if(err){ alert('Errore: '+err); return; }
    var portrait = document.getElementById('m-portrait');
    if(p.immagine_path){
      portrait.innerHTML = '<img src="uploads/'+escH(p.immagine_path)+'" alt="">';
      var prev = document.getElementById('upload-preview');
      prev.src = 'uploads/'+p.immagine_path; prev.style.display = 'block';
    } else {
      portrait.innerHTML = '<div class="portrait-ph">&#128247;<br>Nessuna<br>immagine</div>';
      document.getElementById('upload-preview').style.display = 'none';
    }
    document.getElementById('m-corrente').textContent        = p.corrente||'';
    document.getElementById('m-name').textContent            = p.nome;
    document.getElementById('m-dates').textContent           = p.nascita ? p.nascita+' \u2013 '+(p.morte||'in vita') : 'Movimento / Corrente letteraria';
    document.getElementById('m-count').textContent           = p.opere.length>0 ? p.opere.length+' opere principali' : 'Movimento collettivo';
    document.getElementById('m-caratteristiche').textContent = p.caratteristiche||'';
    document.getElementById('m-bio').textContent             = p.bio||'';
    var opDiv = document.getElementById('m-opere');
    if(p.opere.length){
      var c='';
      for(var i=0;i<p.opere.length;i++)
        c+='<span class="chip">'+escH(p.opere[i].titolo)+'<span class="chip-year">'+(p.opere[i].anno||'')+'</span></span>';
      opDiv.innerHTML = c;
    } else opDiv.innerHTML = '<span style="font-style:italic;color:#bbb">Nessuna opera individuale</span>';
    document.getElementById('bio-link-inp').value     = p.bio_link||'';
    document.getElementById('upload-msg').textContent = '';
    document.getElementById('overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
  });
}

function closeModal(){
  document.getElementById('overlay').classList.remove('open');
  document.body.style.overflow = ''; currentId = null;
}

// ── UPLOAD ────────────────────────────────────────────────────────────────
function uploadImage(e){
  var file=e.target.files[0]; if(!file||!currentId) return;
  var msg=document.getElementById('upload-msg');
  msg.style.color='#999'; msg.textContent='Caricamento in corso...';
  var fd=new FormData(); fd.append('immagine',file);
  var xhr=new XMLHttpRequest();
  xhr.open('POST','api.php?action=upload&id='+currentId,true);
  xhr.onreadystatechange=function(){
    if(xhr.readyState===4){
      try{
        var j=JSON.parse(xhr.responseText);
        if(j.error){msg.style.color='red';msg.textContent='\u2717 '+j.error;return;}
        var t=Date.now();
        document.getElementById('m-portrait').innerHTML='<img src="'+j.path+'?t='+t+'" alt="">';
        var prev=document.getElementById('upload-preview');
        prev.src=j.path+'?t='+t; prev.style.display='block';
        msg.style.color='green'; msg.textContent='\u2713 Immagine salvata';
        loadAllData();
      } catch(err){msg.style.color='red';msg.textContent='\u2717 Errore server';}
    }
  };
  xhr.send(fd); e.target.value='';
}

function escH(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
</script>
</body>
</html>
