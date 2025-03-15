<div id="feeds_detail" 
    x-data="$heroic.pageData({
        title: 'Feed Detail',
        url:'/feeds/detail/init/' + $router.params.id,
    })">

    <h1>Welcome to feeds/detail <span x-text="data.id"></span></h1>
</div>