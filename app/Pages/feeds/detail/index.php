<div id="feeds_detail" 
    x-data="$heroic.page({
        getUrl:'/feeds/detail/init/' + $router.params.id,
    })">

    <div class="appHeader bg-brand">
        <div class="left"></div>
        <div class="pageTitle text-white">
            Feed Detail
        </div>
        <div class="right"></div>
    </div>

    <div id="appCapsule" class="px-3 mt-2">
        <div x-show="ui.loading">Loading</div>

        <div x-show="!ui.loading">
            <h2 x-text="data?.post?.title"></h2>
            <div class="mb-2">
                <img :src="data?.post?.medias[0]?.url" alt="cover" class="w-100">
            </div>
            <div x-html="data?.post?.content"></div>
        </div>
    </div>
</div>