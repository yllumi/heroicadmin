document.addEventListener('alpine:init', () => {

    NProgress.configure({ showSpinner: false });

    Alpine.data("router", () => ({
        async init(){
            Alpine.store('core').sessionToken = localStorage.getItem('heroic_token')
            await Alpine.store('core').getSiteSettings()
        },

        // Check login session, dipanggil oleh x-handler template yang meemerlukan session
        isLoggedIn(context){
            if(localStorage.getItem('intro') != 1) return context.redirect('/intro')
            if(Alpine.store('core').sessionToken == null) return context.redirect('/masuk')
        },

        notfound(context) {
            document.querySelector('#app').innerHTML = `<h1>Not Found</h1>`
        },
    }))

    // Setup Pinecone Router
    window.PineconeRouter.settings.basePath = '/';
    window.PineconeRouter.settings.includeQuery = false;
    
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
    Alpine.store('core', {
        currentPage: 'home',
        pageLoaded: false,
        showBottomMenu: true,
        sessionToken: null,
        settings: {},
        user: {},
        async getSiteSettings() {
            if(Object.keys(Alpine.store('core').settings).length < 1){
                try{
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