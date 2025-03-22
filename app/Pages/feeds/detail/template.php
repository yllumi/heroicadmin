<div :id="`feed_detail_` + $router.params.id" 
    x-data="feed_detail($router.params.id)" 
    x-effect="loadDetail($router.params.id)"
    x-debug>

    <div class="appHeader bg-brand">
        <div class="left">
            <a href="/feeds"><i class="bi bi-chevron-left text-white"></i></a>
        </div>
        <div class="pageTitle text-white">
            Feed Detail
        </div>
        <div class="right"></div>
    </div>

    <div id="appCapsule" class="px-3 mt-2">

        <div id="mahasiswa">
            <div x-show="ui.loading">Loading</div>
            
            <div x-show="!ui.loading">
                <h2 x-text="data?.mahasiswa?.nama"></h2>
                <div x-html="data?.mahasiswa?.nim"></div>
            </div>
            
            <button class="btn btn-outline-danger btn-sm mt-2" @click="submitData({confirm: `Yakin akan menghapus data?`})">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </div>
        
        <ul class="listview link-listview mt-3">
            
            <template x-for="item in data.list">
                <li>
                    <a class="item" :href="`/feeds/detail/` + item.id">
                        <span x-text="item.nama"></span>
                        <span class="text-muted" x-text="item.nim"></span>
                    </a>
                </li>
            </template>
            
        </ul>
    </div>
</div>

<script>
    Alpine.data('feed_detail', (id) => ({
        ui: {
            loading: false
        },
        data: {},
        init(){
            this.loadDetail()
        },
        loadDetail(id){
            if(!id) return 
            this.ui.loading = true
            axios.get(`/feeds/detail/data/` + id)
            .then(response => {
                this.data = response.data.data
                this.ui.loading = false
                NProgress.done()
            })
        }
    }))
</script>