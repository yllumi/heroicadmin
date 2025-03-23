<?= $this->extend('template/mobile') ?>

<!-- START Content Section -->
<?php $this->section('content') ?>

<!-- Alpinejs Routers -->
<div id="app" x-data="router()"></div>

<?= $this->include('router') ?>

<?php $this->endSection() ?>
<!-- END Content Section -->

<!----------------------------------------------------->

<!-- START Script Section -->
<?php $this->section('script') ?>

<script>
    // Init Fancybox
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

    document.addEventListener('alpine:init', () => {

        Alpine.data("router", () => ({
           
        }))

        // Setup Pinecone Router
        window.PineconeRouter.settings.basePath = '/';
        window.PineconeRouter.settings.includeQuery = false;

        // Init NProgress
        NProgress.configure({ showSpinner: false });
        document.addEventListener('pinecone-start', () => {
            NProgress.start();
            Alpine.store('core').pageLoaded = false
        });
        document.addEventListener('pinecone-end', () => {
            NProgress.done();
            Alpine.store('core').pageLoaded = true;
        });
        document.addEventListener('fetch-error', (err) => console.error(err));

        // Global store
        window.__ALPINE_STORE_NAMES_DEBUG__ = ['core'];
        
        Alpine.store('core', {
            currentPage: 'home',
            pageLoaded: false,
            showBottomMenu: true,
            sessionToken: null,
            settings: {},
            user: {},
            async getSiteSettings() {
                if (Object.keys(Alpine.store('core').settings).length < 1) {
                    try {
                        await axios.get('/_components/common/settings', {
                                headers: {
                                    'Authorization': `Bearer ` + localStorage.getItem('heroic_token'),
                                }
                            })
                            .then(response => {
                                Alpine.store('core').settings = response.data.settings
                                Alpine.store('core').user = response.data.user
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    } catch (error) {
                        // Tangani error jika terjadi masalah pada saat fetching data
                        console.error('Error fetching site settings:', error);
                    }
                }
            }
        })

    })
</script>

<?php $this->endSection() ?>
<!-- END Script Section -->