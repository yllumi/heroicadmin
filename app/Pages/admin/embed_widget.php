<div class="card" 
    id="embed_widget" 
    x-data="$heroic({
        getUrl: `/admin/embedWidget/${$router.params.slug}`
    })">

    <div class="card-body">
        <h1 x-text="data.widget_title"></h1>

        <p>Author: <?= $author ?></p>
        <p>Slug: <span x-text="data.slug"></span></p>
    </div>

</div>