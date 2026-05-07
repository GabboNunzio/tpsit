<?php
// ============================================================
//  config.php  —  Configurazione connessione MySQL
//  Modifica host, user, password se necessario
// ============================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // utente MySQL di XAMPP
define('DB_PASS', '');           // password MySQL (vuota di default su XAMPP)
define('DB_NAME', 'poeti_italiani');
define('DB_CHARSET', 'utf8mb4');

// Upload immagini
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['error' => 'Connessione al database fallita: ' . $e->getMessage()]));
        }
    }
    return $pdo;
}
