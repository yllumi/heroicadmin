<!doctype html>
<html lang="en">
<head>
    <title><?= $page_title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#05b2c5">
    <meta name="description" content="Tarbiyya adalah aplikasi managemen informasi pesantren dan menjadi kanal informasi bagi wali santri.">
    <meta name="keywords" content="tarbiyya, aplikasi pesantren, aplikasi wali santri, aplikasi pesantren persis, persatuan islam" />
    <link rel="icon" type="image/png" sizes="72x72" href="<?= $themeURL ?>assets/img/icon/logo-<?= $_SERVER['SITENAME'] ?? 'tarbiyya' ?>/72x72.png">
    <link rel="apple-touch-icon" sizes="192x192" href="<?= $themeURL ?>assets/img/icon/logo-<?= $_SERVER['SITENAME'] ?? 'tarbiyya' ?>/192x192.png">
    <link rel="manifest" href="/<?= ($_SERVER['SITENAME'] ?? null) ? $_SERVER['SITENAME'] : 'tarbiyya' ?>_manifest.json">
    <script>let base_url = `<?= site_url() ?>`;</script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="<?= asset_url('mobilekit/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('mobilekit/assets/css/custom.css') ?>">
</head>

<body>
    <!-- Content Section -->
    <?= $this->renderSection('content') ?>
    
    <!-- Script Packages -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/build/vanilla-calendar.min.js" defer></script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/prompts-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="<?= asset_url('mobilekit/assets/js/base.js') ?>"></script>

    <?php if (ENVIRONMENT === 'development'): ?>
    <script src="<?= asset_url('mobilekit/assets/js/helpers.bundle.js') ?>"></script>
    <script src="<?= asset_url('mobilekit/assets/js/pagescript.js') ?>" defer></script>
    <?php else: ?>
    <script src="<?= asset_url('mobilekit/assets/js/helpers.bundle.min.js') ?>"></script>
    <script src="<?= asset_url('mobilekit/assets/js/pagescript.min.js') ?>" defer></script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/pinecone-router@5.x.x/dist/router.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

	<script>
        Fancybox.bind('[data-fancybox="gallery"]', {});   
		// Check that service workers are supported
		if ('serviceWorker' in navigator) {
			// Use the window load event to keep the page load performant
			window.addEventListener('load', () => {
				navigator.serviceWorker.register(`/sw_masagi.js`);
                window.console.log('Service-worker registered');
			});
		} else {
			window.console.debug('Service-worker not supported');
		}
	</script>
</body>
</html>
