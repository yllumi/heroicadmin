<div id="feeds_detail" 
    x-data="$heroic({
        getUrl:'/feeds/detail/data/' + $router.params.id,
        postUrl: '/feeds/detail/delete/' + $router.params.id,
        clearCachePath: '/feeds/data',
        postRedirect: '/feeds',
    })">

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
                    <a native x-target="mahasiswa" class="item" :href="`/feeds/detail/` + item.id">
                        <span x-text="item.nama"></span>
                        <span class="text-muted" x-text="item.nim"></span>
                    </a>
                </li>
            </template>
            
        </ul>
    </div>
</div>