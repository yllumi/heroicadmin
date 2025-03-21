<div class="page-heading" 
    id="users"
    x-data="$heroic({
        title: `Users`,
        getUrl: `/admin/user/data/${$router.params.page || 1}`,
        perpage: 2,
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
                
                <template x-for="user in paginatedData">
                    <div>
                        <a :href="`/admin/user/detail/` + user?.id">
                            <h1 x-text="user?.nama"></h1>
                        </a>
                    </div>
                </template>

                <div class="pagination">
                    <a href="/admin/user/1">1</a>
                    <a href="/admin/user/2">2</a>
                </div>
            </div>
        </div>
        
    </section>

</div>