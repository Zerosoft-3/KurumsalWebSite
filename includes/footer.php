<footer id="footer" class="footer position-relative dark-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 col-sm-12 footer-about mb-4">
                <a href="./" class="d-flex align-items-center">
                    <span class="sitename">Iqbolshoh</span>
                </a>
                <div class="footer-contact pt-3">
                    <p><strong>Konum:</strong> <?php echo  $contact_boxData[0]['value']; ?></p>
                    <p class="mt-3"><strong>Telefon:</strong> <span onclick="window.location.href='tel:<?php echo trim($contact_boxData[2]['value']); ?>'"><?php echo $contact_boxData[1]['value']; ?></span></p>
                    <p><strong>E-posta:</strong> <span onclick="window.location.href='mailto:<?php echo $contact_boxData[2]['value']; ?>'"><?php echo  $contact_boxData[2]['value']; ?></span></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 footer-links mb-4">
                <h4>Faydalı Bağlantılar</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="./">Ana Sayfa</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="pages/hakkimizda.php">Hakkımızda</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="pages/urunler.php">Ürünler</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="pages/hizmetler.php">Hizmetler</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="pages/iletisim.php">İletişim</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 footer-follow mb-4">
                <h4>Bizi Takip Edin</h4>
                <p>En yeni ürünler ve tekliflerden haberdar olmak için bizi takip edin! Sosyal medyada bizi takip edin!</p>
                <div class="social-links d-flex">
                    <a href="https://twitter.com/<?php echo  $contactData[0]['twitter']; ?>" target="_blank"><i class="bi bi-twitter"></i></a>
                    <a href="https://facebook.com/<?php echo  $contactData[0]['facebook']; ?>" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com/<?php echo  $contactData[0]['instagram']; ?>" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://linkedin.com/in/<?php echo  $contactData[0]['linkedin']; ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Telif Hakkı</span> <strong class="px-1 sitename"> <a href="https://iqbolshoh.uz/"> Iqbolshoh.uz</a></strong> <span>Tüm hakları saklıdır</span></p>
    </div>

    <style>
        footer .sitename {
            color: var(--accent-color);
        }

        .footer-contact p span:hover {
            color: var(--accent-color);
        }
    </style>

</footer>