<?php
/**
 * Sabit Değerler
 * Sitede kullanılacak sabit değerler
 */

// Site bilgileri
define('SITE_NAME', 'Tohum Web Sitesi');
define('SITE_VERSION', '1.0.0');
define('SITE_AUTHOR', 'Your Name');

// Dosya yolu sabitleri
define('ASSETS_PATH', '/assets/');
define('CSS_PATH', ASSETS_PATH . 'css/');
define('JS_PATH', ASSETS_PATH . 'js/');
define('IMG_PATH', ASSETS_PATH . 'images/');

// Sayfa ayarları
define('POSTS_PER_PAGE', 10);
define('EXCERPT_LENGTH', 150);

// Dosya yükleme ayarları
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);

// Email ayarları
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
define('FROM_EMAIL', 'info@example.com');
define('FROM_NAME', 'Tohum Web Sitesi');

// Sosyal medya bağlantıları
define('FACEBOOK_URL', 'https://facebook.com/');
define('TWITTER_URL', 'https://twitter.com/');
define('INSTAGRAM_URL', 'https://instagram.com/');
define('YOUTUBE_URL', 'https://youtube.com/');
define('LINKEDIN_URL', 'https://linkedin.com/');

// API anahtarları
define('GOOGLE_MAPS_API_KEY', 'your-google-maps-api-key');
define('GOOGLE_ANALYTICS_ID', 'your-ga-tracking-id');
define('GOOGLE_RECAPTCHA_SITE_KEY', 'your-recaptcha-site-key');
define('GOOGLE_RECAPTCHA_SECRET_KEY', 'your-recaptcha-secret-key');

// Dil ayarları
define('DEFAULT_LANGUAGE', 'tr');
define('AVAILABLE_LANGUAGES', ['tr', 'en']);

// Önbellek ayarları
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 3600); // 1 saat

// Hata mesajları
define('ERROR_DATABASE', 'Veritabanı hatası oluştu');
define('ERROR_UPLOAD', 'Dosya yükleme hatası');
define('ERROR_PERMISSION', 'Yetkiniz bulunmamaktadır');
define('ERROR_VALIDATION', 'Form doğrulama hatası');
define('ERROR_NOT_FOUND', 'Sayfa bulunamadı');

// Başarı mesajları
define('SUCCESS_SAVE', 'Kayıt başarıyla tamamlandı');
define('SUCCESS_UPDATE', 'Güncelleme başarıyla tamamlandı');
define('SUCCESS_DELETE', 'Silme işlemi başarıyla tamamlandı');
define('SUCCESS_UPLOAD', 'Dosya başarıyla yüklendi');
define('SUCCESS_SEND', 'Mesaj başarıyla gönderildi');

// Tarih formatları
define('DATE_FORMAT', 'd.m.Y');
define('DATETIME_FORMAT', 'd.m.Y H:i');
define('TIME_FORMAT', 'H:i');

// Pagination ayarları
define('PAGINATION_RANGE', 5);

// SEO ayarları
define('META_TITLE_MAX_LENGTH', 60);
define('META_DESCRIPTION_MAX_LENGTH', 160);
define('DEFAULT_META_KEYWORDS', 'tohum, tarım, hasat, kalite');

// Güvenlik ayarları
define('SESSION_TIMEOUT', 1800); // 30 dakika
define('LOGIN_ATTEMPT_LIMIT', 5);
define('PASSWORD_MIN_LENGTH', 8);

// Resim boyutları
define('IMAGE_SIZES', [
    'thumbnail' => [150, 150],
    'small' => [300, 300],
    'medium' => [600, 400],
    'large' => [1200, 800]
]);

// Menü konumları
define('MENU_LOCATIONS', [
    'header' => 'Üst Menü',
    'footer' => 'Alt Menü',
    'sidebar' => 'Yan Menü'
]);

// İçerik durumları
define('CONTENT_STATUS', [
    'published' => 'Yayınlandı',
    'draft' => 'Taslak',
    'inactive' => 'Pasif'
]);

// Kullanıcı rolleri
define('USER_ROLES', [
    'admin' => 'Yönetici',
    'editor' => 'Editör'
]);

// Mesaj durumları
define('MESSAGE_STATUS', [
    'new' => 'Yeni',
    'read' => 'Okundu',
    'replied' => 'Yanıtlandı',
    'archived' => 'Arşivlendi'
]);

// Log seviyeleri
define('LOG_LEVELS', [
    'ERROR' => 1,
    'WARNING' => 2,
    'INFO' => 3,
    'DEBUG' => 4
]);

// Cookie ayarları
define('COOKIE_LIFETIME', 86400 * 30); // 30 gün
define('COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIE_SECURE', false); // HTTPS için true yapın
define('COOKIE_HTTPONLY', true);
?> 