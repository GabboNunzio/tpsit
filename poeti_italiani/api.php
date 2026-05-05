<?php
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'poeti')           { actionPoeti(); }
elseif ($action === 'poeta')       { actionPoeta(); }
elseif ($action === 'correnti')    { actionCorrenti(); }
elseif ($action === 'opposizioni') { actionOpposizioni(); }
elseif ($action === 'upload')      { actionUpload(); }
else { jsonError('Azione non valida', 400); }

function actionPoeti() {
    $db  = getDB();
    $q   = '%' . trim(isset($_GET['q']) ? $_GET['q'] : '') . '%';
    $cid = isset($_GET['corrente_id']) ? trim($_GET['corrente_id']) : '';

    $sql = "SELECT p.id, p.nome, p.nascita, p.morte, p.is_movimento,
                   p.caratteristiche, p.immagine_path,
                   c.nome AS corrente,
                   COUNT(o.id) AS n_opere
            FROM poeti p
            LEFT JOIN correnti c ON c.id = p.corrente_id
            LEFT JOIN opere o ON o.poeta_id = p.id
            WHERE (p.nome LIKE :q1
               OR  p.caratteristiche LIKE :q2
               OR  c.nome LIKE :q3
               OR  p.bio LIKE :q4)";

    $params = array(':q1' => $q, ':q2' => $q, ':q3' => $q, ':q4' => $q);

    if ($cid !== '' && $cid !== '0') {
        $sql .= " AND p.corrente_id = :cid";
        $params[':cid'] = (int)$cid;
    }

    $sql .= " GROUP BY p.id ORDER BY (p.nascita IS NULL), p.nascita, p.nome";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as &$r) {
        $r['is_movimento'] = (bool)$r['is_movimento'];
        $r['n_opere']      = (int)$r['n_opere'];
        // solo il nome file, non il path completo
        $r['immagine_path'] = $r['immagine_path'] ? $r['immagine_path'] : null;
    }

    echo json_encode(array('data' => $rows), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function actionPoeta() {
    $id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
    if ($id <= 0) { jsonError('ID non valido', 400); return; }

    $db   = getDB();
    $stmt = $db->prepare("SELECT p.*, c.nome AS corrente, c.periodo
                          FROM poeti p
                          LEFT JOIN correnti c ON c.id = p.corrente_id
                          WHERE p.id = :id");
    $stmt->execute(array(':id' => $id));
    $poeta = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$poeta) { jsonError('Poeta non trovato', 404); return; }
    $poeta['is_movimento'] = (bool)$poeta['is_movimento'];

    $stmt2 = $db->prepare("SELECT titolo, anno FROM opere WHERE poeta_id = :id ORDER BY anno, titolo");
    $stmt2->execute(array(':id' => $id));
    $poeta['opere'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(array('data' => $poeta), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function actionCorrenti() {
    $db   = getDB();
    $rows = $db->query("SELECT id, nome, periodo FROM correnti ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(array('data' => $rows), JSON_UNESCAPED_UNICODE);
}

function actionOpposizioni() {
    $db   = getDB();
    $rows = $db->query("SELECT * FROM opposizioni ORDER BY ordine")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(array('data' => $rows), JSON_UNESCAPED_UNICODE);
}

function actionUpload() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { jsonError('Metodo non consentito', 405); return; }
    $id = (int)(isset($_GET['id']) ? $_GET['id'] : 0);
    if ($id <= 0) { jsonError('ID mancante', 400); return; }
    if (!isset($_FILES['immagine'])) { jsonError('File mancante', 400); return; }

    $file = $_FILES['immagine'];
    if ($file['error'] !== UPLOAD_ERR_OK) { jsonError('Errore upload: codice ' . $file['error'], 400); return; }
    if ($file['size'] > MAX_FILE_SIZE)    { jsonError('File troppo grande (max 5 MB)', 400); return; }

    $allowedTypes = array('image/jpeg','image/png','image/webp','image/gif');
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, $allowedTypes)) { jsonError('Tipo file non supportato: ' . $mime, 400); return; }

    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = 'poeta_' . $id . '_' . time() . '.' . $ext;
    $destPath = UPLOAD_DIR . $filename;

    if (!is_dir(UPLOAD_DIR)) { mkdir(UPLOAD_DIR, 0755, true); }
    if (!move_uploaded_file($file['tmp_name'], $destPath)) { jsonError('Salvataggio fallito', 500); return; }

    $db  = getDB();
    $old = $db->prepare("SELECT immagine_path FROM poeti WHERE id = :id");
    $old->execute(array(':id' => $id));
    $row = $old->fetch(PDO::FETCH_ASSOC);
    if ($row && $row['immagine_path'] && file_exists(UPLOAD_DIR . $row['immagine_path'])) {
        unlink(UPLOAD_DIR . $row['immagine_path']);
    }

    $upd = $db->prepare("UPDATE poeti SET immagine_path = :path WHERE id = :id");
    $upd->execute(array(':path' => $filename, ':id' => $id));

    echo json_encode(array('success' => true, 'path' => UPLOAD_URL . $filename), JSON_UNESCAPED_UNICODE);
}

function jsonError($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(array('error' => $msg));
    exit;
}
