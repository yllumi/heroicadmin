<div id="aktivasi" x-data="aktivasi()">

    <div class="bg-image" style="background-image: url('<?= $themeURL ?>assets/img/bg-green-min.jpg'); background-repeat: no-repeat; background-size: cover; width: 100%; background-position: center; background-color: #add7cb; height: 100%; position: fixed;"></div>

    <div class="appHeader">
        <div class="left">
            <a href="javascript:void()" onclick="history.back()" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Aktivasi</div>
        <div class="right">
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="shadow pb-2" style="padding-top: 60px">

        <div class="container">
            <div class="login-form">
                <div class="section mt-3">
                    <p class="my-3 text-white">Untuk memulai registrasi silakan masukkan token registrasi dan NPA Anda. Token registrasi dapat Anda minta ke Pimpinan Cabang Anda.</p>
                </div>

                <div class="form-group boxed animated">
                    <div class="input-wrapper">
                        <label class="text-white form-label" for="token">Kode Token</label>
                        <input type="text" x-model="data.token" id="token" class="form-control" value="" placeholder="Kode Token Registrasi" required="" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group boxed animated">
                    <div class="input-wrapper">
                        <label class="text-white form-label" for="username">NPA</label>
                        <input type="text" x-model="data.npa" id="username" class="form-control" value="" placeholder="Nomor Pokok Anggota" required="" autocomplete="off">
                    </div>
                </div>
                <!-- <div class="form-group boxed mt-1">
                    <div class="input-wrapper">
                        <div class="g-recaptcha d-flex justify-content-center" data-sitekey="6LdRI6IpAAAAAD4V9Nm2u9SB7ml_OV4ceZB12EOB" data-action="LOGIN"></div>
                    </div>
                </div> -->
                <div class="mt-3">
                    <button 
                        type="button" 
                        id="btnSubmit" 
                        class="btn btn-primary btn-lg btn-block"
                        @click="checkActivationToken" 
                        :disabled="data.token.trim() == '' || data.npa.trim() == '' ? true : false">
                        <span id="submitSpinner" class="d-none spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        <span 
                            id="submitText" 
                            class="text-uppercase">
                            Lanjutkan Aktivasi
                        </span>
                    </button>
                </div>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

</div>