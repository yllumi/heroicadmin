<div id="feeds_add"
    x-data="$heroic.page({ 
        title: 'Add New Feed',
        postUrl: '/feeds/add/insert',
        clearCachePath: '/feeds/data',
        postRedirect: '/feeds',
     })">

    <div class="appHeader bg-brand">
        <div class="left"></div>
        <div class="pageTitle text-white">
            Add New Feed
        </div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="card">
            <div class="card-body">

                    <div class="form-group">
                        <label for="title">Nama</label>
                        <input type="text" class="form-control" name="nama" x-model="model.nama">
                    </div>
                    <div class="form-group">
                        <label for="title">NIM</label>
                        <input type="text" class="form-control" name="nim" x-model="model.nim">
                    </div>
                    <hr>
                    <button @click="submitData()" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>

</div>