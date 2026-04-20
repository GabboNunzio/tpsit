<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Correnti a confronto — Database Poeti Italiani</title>
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

nav{background:var(--ink);display:flex;align-items:center;justify-content:center;gap:2rem;padding:.7rem 2rem;position:sticky;top:0;z-index:500}
nav a{color:var(--parchment);font-family:'EB Garamond',serif;font-size:1rem;text-decoration:none;letter-spacing:.06em;opacity:.7;transition:opacity .2s;display:flex;align-items:center;gap:.4rem}
nav a:hover{opacity:1}
nav a.active{opacity:1;color:var(--gold-light);border-bottom:2px solid var(--gold-light);padding-bottom:2px}

header{background:var(--ink);padding:2.2rem 2rem 1.8rem;text-align:center;position:relative;overflow:hidden}
header::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(-45deg,transparent,transparent 10px,rgba(255,255,255,.015) 10px,rgba(255,255,255,.015) 20px)}
.h-ornament{color:var(--gold);font-size:.95rem;letter-spacing:.4em;text-transform:uppercase;font-style:italic;opacity:.8;margin-bottom:.35rem}
header h1{font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4.5vw,3rem);font-weight:900;color:var(--parchment);line-height:1.1;text-shadow:0 2px 12px rgba(0,0,0,.4)}
header h1 em{color:var(--gold-light);font-style:italic}
.h-rule{width:100px;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);margin:.8rem auto 0}

.wrap{max-width:1100px;margin:0 auto;padding:2rem 1.5rem}

/* INTRO */
.intro-box{background:#fff;border-left:4px solid var(--gold);border-radius:0 var(--radius) var(--radius) 0;
  padding:1rem 1.4rem;margin-bottom:1.8rem;box-shadow:0 2px 10px var(--shadow)}
.intro-box p{font-size:1rem;line-height:1.65;color:#4a3c28}

/* TOOLBAR */
.toolbar{display:flex;align-items:center;gap:.9rem;margin-bottom:1.6rem;flex-wrap:wrap}
.toolbar-lbl{font-family:'Playfair Display',serif;font-size:.76rem;letter-spacing:.15em;text-transform:uppercase;color:var(--gold);white-space:nowrap}
.filter-inp{flex:1;min-width:180px;padding:.6rem 1rem;border:2px solid var(--parchment-dark);
  border-radius:var(--radius);font-family:'EB Garamond',serif;font-size:1rem;color:var(--ink);
  background:var(--cream);outline:none;transition:border-color .2s}
.filter-inp:focus{border-color:var(--gold)}
.filter-inp::placeholder{color:#b8a880}
.res-lbl{font-style:italic;font-size:.88rem;color:#aaa;white-space:nowrap}

/* VIEW TOGGLE */
.view-toggle{display:flex;border:2px solid var(--parchment-dark);border-radius:var(--radius);overflow:hidden;flex-shrink:0}
.vtab{padding:.45rem 1rem;font-family:'EB Garamond',serif;font-size:.9rem;cursor:pointer;
  background:transparent;border:none;color:#999;transition:all .2s;display:flex;align-items:center;gap:.35rem}
.vtab.active{background:var(--ink);color:var(--gold-light)}

/* ── TABELLA MIGLIORATA ── */
.table-wrap{overflow-x:auto;border-radius:var(--radius);box-shadow:0 4px 20px var(--shadow)}
.opp-table{width:100%;border-collapse:collapse;font-size:.95rem;background:#fff;min-width:640px}

/* intestazione */
.opp-table thead tr{background:var(--ink)}
.opp-table thead th{padding:.9rem 1.1rem;font-family:'Playfair Display',serif;font-size:.76rem;
  letter-spacing:.1em;text-transform:uppercase;font-weight:400;color:var(--parchment);border:none;text-align:left}
.opp-table thead th.col-ca{color:#e8a0a0;text-align:center}
.opp-table thead th.col-vs{text-align:center;width:50px}
.opp-table thead th.col-cb{color:var(--gold-light);text-align:center}

/* righe */
.opp-table tbody tr{border-bottom:1px solid var(--parchment-dark);transition:background .15s}
.opp-table tbody tr:last-child{border-bottom:none}
.opp-table tbody tr:nth-child(even){background:#fdfaf5}
.opp-table tbody tr:hover{background:#f5ede0}

/* celle */
.opp-table td{padding:.85rem 1.1rem;vertical-align:middle;line-height:1.55;font-size:.93rem;color:#3a2e1a}
.opp-table td.col-num{text-align:center;color:#ccc;font-size:.8rem;font-weight:700;width:40px;padding:.85rem .5rem}
.opp-table td.col-ca{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--rust);text-align:center;white-space:nowrap}
.opp-table td.col-vs{text-align:center;width:50px;padding:.85rem .3rem}
.opp-table td.col-cb{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--gold);text-align:center;white-space:nowrap}

/* badge VS */
.vs-badge{display:inline-flex;align-items:center;justify-content:center;
  width:30px;height:30px;border-radius:50%;background:var(--ink);
  color:var(--parchment-dark);font-size:.62rem;font-weight:900;letter-spacing:.05em}

/* pill corrente nella tabella */
.pill{display:inline-block;padding:3px 10px;border-radius:20px;font-size:.82rem;
  font-family:'EB Garamond',serif;font-style:normal;white-space:nowrap}
.pill-a{background:#f9ebe8;border:1px solid #e8c0b8;color:var(--rust)}
.pill-b{background:#fdf5e0;border:1px solid #e8d090;color:#7a6008}

/* ── CARDS ── */
#cards-view{display:none}
.opp-cards{display:grid;grid-template-columns:1fr;gap:1.1rem}
.opp-card{background:#fff;border:1px solid var(--parchment-dark);border-radius:var(--radius);
  overflow:hidden;box-shadow:0 2px 10px var(--shadow);display:grid;grid-template-columns:1fr 44px 1fr}
.opp-side{padding:1.1rem 1.3rem}
.opp-side-lbl{font-size:.65rem;letter-spacing:.14em;text-transform:uppercase;margin-bottom:.25rem;font-family:'Playfair Display',serif}
.opp-side.a .opp-side-lbl{color:var(--rust)}
.opp-side.b .opp-side-lbl{color:var(--gold)}
.opp-corrente{font-family:'Playfair Display',serif;font-size:1.15rem;font-weight:700;margin-bottom:.35rem}
.opp-side.a .opp-corrente{color:var(--rust)}
.opp-side.b .opp-corrente{color:var(--gold)}
.opp-car{font-size:.9rem;line-height:1.6;color:#4a3c28}
.opp-vs-col{display:flex;align-items:center;justify-content:center;background:var(--ink)}
.opp-vs-col span{color:var(--parchment-dark);font-size:.68rem;font-weight:900;letter-spacing:.08em;writing-mode:vertical-rl}

.empty-msg{text-align:center;padding:3rem;color:#c0b090;font-style:italic;font-size:1.05rem}

footer{text-align:center;padding:2rem;font-size:.8rem;color:#c0b090;font-style:italic;border-top:1px solid var(--parchment-dark);margin-top:3rem}
footer a{color:var(--gold);text-decoration:none}
footer a:hover{text-decoration:underline}
</style>
</head>
<body>

<nav>
  <a href="index.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
    Poeti
  </a>
  <a href="opposizioni.php" class="active">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
    Correnti a confronto
  </a>
</nav>

<header>
  <div class="h-ornament">Opposizione Tematica</div>
  <h1>Correnti <em>a confronto</em></h1>
  <div class="h-rule"></div>
</header>

<div class="wrap">

  <div class="intro-box">
    <p>Le coppie sono costruite in base a <strong>opposizione tematica, stilistica o storica</strong> — non cronologica. Ogni coppia confronta due correnti per contrasto di poetica, visione del mondo o stile.</p>
  </div>

  <div class="toolbar">
    <span class="toolbar-lbl">Filtra</span>
    <input type="text" class="filter-inp" id="filter-q" placeholder="Es. Romanticismo, amore, natura...">
    <span class="res-lbl" id="filter-count"></span>
    <div class="view-toggle">
      <button class="vtab active" id="vtab-table" onclick="setView('table')">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
        Tabella
      </button>
      <button class="vtab" id="vtab-cards" onclick="setView('cards')">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Card
      </button>
    </div>
  </div>

  <!-- TABELLA -->
  <div id="table-view">
    <div class="table-wrap">
      <table class="opp-table">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Caratteristiche A</th>
            <th class="col-ca">Corrente A</th>
            <th class="col-vs">vs</th>
            <th class="col-cb">Corrente B</th>
            <th>Caratteristiche B</th>
          </tr>
        </thead>
        <tbody id="opp-tbody"></tbody>
      </table>
    </div>
  </div>

  <!-- CARDS -->
  <div id="cards-view">
    <div class="opp-cards" id="opp-cards"></div>
  </div>

</div>

<footer>
  Letteratura italiana &mdash; dal XIII al XX secolo &nbsp;|&nbsp;
  <a href="index.php">&larr; Torna ai Poeti</a>
</footer>

<script>
var allOpp  = [];
var viewMode = 'table';
var debT    = null;

window.onload = function() {
  loadOpposizioni();
  document.getElementById('filter-q').addEventListener('input', function(){
    clearTimeout(debT); debT = setTimeout(renderAll, 200);
  });
};

function apiFetch(params, cb) {
  var url='api.php?', parts=[];
  for(var k in params) parts.push(encodeURIComponent(k)+'='+encodeURIComponent(params[k]));
  url+=parts.join('&');
  var xhr=new XMLHttpRequest();
  xhr.open('GET',url,true);
  xhr.onreadystatechange=function(){
    if(xhr.readyState===4){
      try{ cb(null,JSON.parse(xhr.responseText).data); }
      catch(e){ cb('Errore'); }
    }
  };
  xhr.send();
}

function loadOpposizioni() {
  apiFetch({action:'opposizioni'}, function(err,data){
    if(err||!data) return;
    allOpp = data;
    renderAll();
  });
}

function filtered() {
  var q = document.getElementById('filter-q').value.trim().toLowerCase();
  if(!q) return allOpp;
  return allOpp.filter(function(o){
    return (o.corrente_a||'').toLowerCase().indexOf(q)>=0
        || (o.corrente_b||'').toLowerCase().indexOf(q)>=0
        || (o.caratteristiche_a||'').toLowerCase().indexOf(q)>=0
        || (o.caratteristiche_b||'').toLowerCase().indexOf(q)>=0;
  });
}

function renderAll() {
  var rows = filtered();
  document.getElementById('filter-count').textContent = rows.length+' / '+allOpp.length+' coppie';
  if(viewMode==='table') renderTable(rows);
  else renderCards(rows);
}

function renderTable(rows) {
  var tbody = document.getElementById('opp-tbody');
  if(!rows.length){
    tbody.innerHTML='<tr><td colspan="6" class="empty-msg">Nessuna coppia trovata.</td></tr>';
    return;
  }
  tbody.innerHTML = rows.map(function(o,i){
    return '<tr>'
      +'<td class="col-num">'+(o.ordine||i+1)+'</td>'
      +'<td>'+escH(o.caratteristiche_a)+'</td>'
      +'<td class="col-ca"><span class="pill pill-a">'+escH(o.corrente_a)+'</span></td>'
      +'<td class="col-vs"><span class="vs-badge">VS</span></td>'
      +'<td class="col-cb"><span class="pill pill-b">'+escH(o.corrente_b)+'</span></td>'
      +'<td>'+escH(o.caratteristiche_b)+'</td>'
      +'</tr>';
  }).join('');
}

function renderCards(rows) {
  var container = document.getElementById('opp-cards');
  if(!rows.length){
    container.innerHTML='<div class="empty-msg">Nessuna coppia trovata.</div>';
    return;
  }
  container.innerHTML = rows.map(function(o){
    return '<div class="opp-card">'
      +'<div class="opp-side a">'
        +'<div class="opp-side-lbl">Corrente A</div>'
        +'<div class="opp-corrente">'+escH(o.corrente_a)+'</div>'
        +'<div class="opp-car">'+escH(o.caratteristiche_a)+'</div>'
      +'</div>'
      +'<div class="opp-vs-col"><span>VS</span></div>'
      +'<div class="opp-side b">'
        +'<div class="opp-side-lbl">Corrente B</div>'
        +'<div class="opp-corrente">'+escH(o.corrente_b)+'</div>'
        +'<div class="opp-car">'+escH(o.caratteristiche_b)+'</div>'
      +'</div>'
      +'</div>';
  }).join('');
}

function setView(v) {
  viewMode = v;
  document.getElementById('vtab-table').classList.toggle('active', v==='table');
  document.getElementById('vtab-cards').classList.toggle('active', v==='cards');
  document.getElementById('table-view').style.display = v==='table' ? '' : 'none';
  document.getElementById('cards-view').style.display = v==='cards' ? '' : 'none';
  renderAll();
}

function escH(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
</script>
</body>
</html>
