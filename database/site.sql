-- Veritabanı oluşturma
CREATE DATABASE IF NOT EXISTS tohum_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tohum_website;

-- Admin kullanıcıları tablosu
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    status ENUM('active', 'inactive') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sayfa içerikleri tablosu
CREATE TABLE contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT,
    excerpt TEXT,
    image VARCHAR(255),
    page_type ENUM('home', 'about', 'product', 'blog', 'custom') DEFAULT 'custom',
    status ENUM('published', 'draft', 'inactive') DEFAULT 'published',
    meta_title VARCHAR(255),
    meta_description TEXT,
    sort_order INT DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_page_type (page_type),
    INDEX idx_status (status),
    INDEX idx_slug (slug)
);

-- İletişim mesajları tablosu
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Site ayarları tablosu
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT,
    setting_type ENUM('text', 'textarea', 'image', 'json', 'boolean') DEFAULT 'text',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key)
);

-- Ürünler tablosu (eğer e-ticaret özelliği varsa)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description LONGTEXT,
    short_description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255),
    gallery JSON,
    specifications JSON,
    category VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    featured BOOLEAN DEFAULT FALSE,
    stock_quantity INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_slug (slug)
);

-- Varsayılan admin kullanıcısı ekleme
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Varsayılan site ayarları
INSERT INTO settings (setting_key, setting_value, setting_type, description) VALUES
('site_title', 'Tohum Web Sitesi', 'text', 'Site başlığı'),
('site_description', 'Kaliteli Tohum, Verimli Hasat', 'textarea', 'Site açıklaması'),
('site_keywords', 'tohum, tarım, hasat', 'text', 'Site anahtar kelimeleri'),
('contact_email', 'info@example.com', 'text', 'İletişim email adresi'),
('contact_phone', '+90 266 XXX XX XX', 'text', 'İletişim telefonu'),
('contact_address', 'Bandırma, Balıkesir', 'textarea', 'İletişim adresi'),
('social_facebook', '#', 'text', 'Facebook linki'),
('social_twitter', '#', 'text', 'Twitter linki'),
('social_instagram', '#', 'text', 'Instagram linki'),
('social_youtube', '#', 'text', 'YouTube linki'),
('logo', 'logo.png', 'image', 'Site logosu'),
('favicon', 'favicon.ico', 'image', 'Site favicon'),
('analytics_code', '', 'textarea', 'Google Analytics kodu'),
('maintenance_mode', 'false', 'boolean', 'Bakım modu');

-- Örnek içerik verileri
INSERT INTO contents (title, slug, content, page_type, meta_title, meta_description) VALUES
('Ana Sayfa', 'ana-sayfa', 'Kaliteli Tohum, Verimli Hasat - Ana sayfa içeriği', 'home', 'Ana Sayfa - Tohum Web Sitesi', 'Kaliteli tohum çeşitleri ve tarım ürünleri'),
('Hakkımızda', 'hakkimizda', 'Şirket hakkında detaylı bilgi', 'about', 'Hakkımızda - Tohum Web Sitesi', 'Şirketimiz hakkında detaylı bilgi'),
('İletişim', 'iletisim', 'İletişim bilgileri ve harita', 'custom', 'İletişim - Tohum Web Sitesi', 'Bizimle iletişime geçin'); 