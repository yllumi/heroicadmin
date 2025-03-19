<div id="feeds"
    x-data="$heroic({ 
        title: 'Feeds',
        getUrl: '/feeds/data',
        perpage: 10,
    })">

    <div class="appHeader bg-brand">
        <div class="left"></div>
        <div class="pageTitle text-white">
            Feeds
        </div>
        <div class="right">
            <a href="/feeds/add"><i class="bi bi-plus-circle text-white"></i></a>
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div id="appData">
            <ul class="listview link-listview">

                <template x-for="item in paginatedData">
                    <li>
                        <a class="item" :href="`/feeds/detail/` + item.id">
                            <span x-text="item.nama"></span>
                            <span class="text-muted" x-text="item.nim"></span>
                        </a>
                    </li>
                </template>

            </ul>

            <template x-if="ui.loadMore">
                <div class="text-center mt-2">
                    <button class="btn btn-outline-secondary" @click="loadMore()">Load More</button>
                </div>
            </template>
        </div>
    </div>
</div>
