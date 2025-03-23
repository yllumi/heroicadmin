<div id="coba_lagi" 
    x-data="coba_lagi()">

    <div class="appHeader bg-brand">
        <div class="left"></div>
        <div class="pageTitle text-white" x-text="data.page_title"></div>
        <div class="right"></div>
    </div>

    <div id="appCapsule">

        <div class="text-center py-3">
            <h1>Welcome <span x-text="data.name"></span>!</h1>
        </div>

    </div>
</div>

<script>
    Alpine.data('coba_lagi', () => {
        // Instantiate $heroic object
        let base = $heroic({
            title: `<?= $page_title ?>`,
            getUrl: `/coba/lagi/data`,
        });

        return {
            // Inherit $heroic object
            ...base,

            // TODO: Place your own properties here
            
            init() {
                // Running $heroic init()
                base.init.call(this);

                // TODO: Place your init code here

            }
        }
    })
</script>