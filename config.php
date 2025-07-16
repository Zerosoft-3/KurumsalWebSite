<?php
/**
 * Ana Konfigürasyon Dosyası
 * Site genelinde kullanılacak ayarlar
 */

// Hata raporlama (development için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session başlatma
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Timezone ayarı
date_default_timezone_set('Europe/Istanbul');

// Site temel ayarları
define('SITE_URL', 'http://localhost/tohum-website');
define('SITE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', SITE_PATH . '/assets/images/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/images/uploads/');

// Veritabanı bağlantısı
require_once 'database.php';
require_once 'constants.php';

// Yardımcı fonksiyonlar
require_once '../includes/functions.php';

// Site ayarlarını veritabanından çekme
function getSiteSettings() {
    global $database;
    $settings = [];
    
    $results = $database->fetchAll("SELECT setting_key, setting_value FROM settings");
    
    if ($results) {
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    
    return $settings;
}

// Global site ayarları
$site_settings = getSiteSettings();

// PHP ayarları
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_execution_time', 300);

// Güvenlik ayarları
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // HTTPS için 1 yapın

// CSRF token oluşturma
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// CSRF token doğrulama
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// XSS koruması
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// URL temizleme (slug oluşturma)
function createSlug($text) {
    $turkish = ['ç', 'ğ', 'ı', 'ö', 'ş', 'ü', 'Ç', 'Ğ', 'I', 'İ', 'Ö', 'Ş', 'Ü'];
    $english = ['c', 'g', 'i', 'o', 's', 'u', 'c', 'g', 'i', 'i', 'o', 's', 'u'];
    
    $text = str_replace($turkish, $english, $text);
    $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
    $text = preg_replace('/\s+/', '-', $text);
    $text = strtolower(trim($text, '-'));
    
    return $text;
}

// Sayfa başlığı oluşturma
function getPageTitle($page_title = '') {
    global $site_settings;
    $site_title = $site_settings['site_title'] ?? 'Tohum Web Sitesi';
    
    if ($page_title) {
        return $page_title . ' - ' . $site_title;
    }
    
    return $site_title;
}

// Meta description oluşturma
function getMetaDescription($description = '') {
    global $site_settings;
    return $description ?: ($site_settings['site_description'] ?? 'Kaliteli Tohum, Verimli Hasat');
}

// Resim yükleme fonksiyonu
function uploadImage($file, $folder = 'general') {
    $upload_dir = UPLOAD_PATH . $folder . '/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Geçersiz dosya formatı'];
    }
    
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'Dosya boyutu çok büyük'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return [
            'success' => true,
            'filename' => $filename,
            'filepath' => $folder . '/' . $filename,
            'url' => UPLOAD_URL . $folder . '/' . $filename
        ];
    }
    
    return ['success' => false, 'message' => 'Dosya yüklenemedi'];
}

// Maintenance mode kontrolü
function checkMaintenanceMode() {
    global $site_settings;
    
    if (isset($site_settings['maintenance_mode']) && $site_settings['maintenance_mode'] === 'true') {
        // Admin kullanıcıları için maintenance mode'u atla
        if (!isset($_SESSION['admin_id'])) {
            include '../maintenance.php';
            exit;
        }
    }
}

// Maintenance mode kontrolü
checkMaintenanceMode();
?> 