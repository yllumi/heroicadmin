<div id="feeds" 
     x-data="$heroic.pageData({ 
        title: 'Feeds',
        url:'/feeds/supply',
        perpage: 10,
     })">

    <div class="appHeader bg-brand">
        <div class="left"></div>
        <div class="pageTitle text-white" x-text="$router.params.slug">
            Feeds
        </div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="container mt-2">
            <h2><?= $name ?></h2>
            <h2><?= $slug ?></h2>
        </div>
    </div>

</div>