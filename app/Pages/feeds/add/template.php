<div id="feeds_add"
    x-data="$heroic({ 
        title: 'Add New Feed',
        postUrl: '/feeds/add/insert',
        clearCachePath: '/feeds/data',
        postRedirect: '/feeds',
     })">

    <div class="appHeader bg-brand">
        <div class="left">
            <a href="/feeds"><i class="bi bi-chevron-left text-white"></i></a>
        </div>
        <div class="pageTitle text-white">
            Add New Feed
        </div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="card">
            <div class="card-body">

                    <div class="mb-2">
                        <label for="title">Nama</label>
                        <input type="text" class="form-control" name="nama" x-model="model.nama">
                        <small class="text-danger" x-show="modelMessage?.nama" x-text="modelMessage?.nama" x-transition></small>
                    </div>
                    <div class="mb-2">
                        <label for="title">NIM</label>
                        <input type="text" class="form-control" name="nim" x-model="model.nim">
                        <small class="text-danger" x-show="modelMessage?.nim" x-text="modelMessage?.nim" x-transition></small>
                    </div>
                    <hr>
                    <button @click="submitData()" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>

</div>