<div class="page-heading" 
    x-data="$heroic({
        title: `Dashboard`,
        getUrl: `/admin/data`
    })">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 x-text="data.page_title"></h3>
                <p class="text-subtitle text-muted" x-text="data.page_subtitle"></p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <template x-for="(blink,blabel) in data.breadcrumbs">
                            <li class="breadcrumb-item active"><a :href="blink" x-text="blabel"></a></li>
                        </template>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Table</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h1 x-text="data.welcome_message"></h1>
            </div>
        </div>
        
        <!-- Inline Widget -->
        <div class="card" id="inline_widget" x-data="$heroic({
            getUrl: `/admin/inlineWidget`
        })">
            <div class="card-body">
                <h1 x-text="data.widget_title"></h1>
            </div>
        </div>

        <!-- Embed Widget -->
        <?= $this->include('admin/embed_widget') ?>

    </section>

</div>