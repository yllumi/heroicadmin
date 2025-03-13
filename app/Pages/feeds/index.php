<div id="feeds"
    x-data="$heroic.pageData({ 
        title: 'Feeds',
        url:'/feeds/supply',
        perpage: 10,
     })">

    <div class="appHeader bg-brand">
        <div class="left"></div>
        <div class="pageTitle text-white">
            Feeds
        </div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div id="appData">
            <ul class="listview image-listview media">

                <template x-for="item in paginatedData">
                    <li>
                        <div class="item">
                            <div class="imageWrapper">
                                <img :src="item.medias[0].url" alt="image" class="imaged w64">
                            </div>
                            <div class="in">
                                <div>
                                    <span x-text="item.title"></span>
                                    <div class="text-muted" x-text="$heroic.helper.formatDate(item.created_at)"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </template>

            </ul>

            <template x-if="ui.loadMore">
                <button class="btn btn-outline-secondary" @click="loadMore()">Load More</button>
            </template>
        </div>
    </div>

</div>