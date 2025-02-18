// Page component
window.register_confirm = function(){
    return {
        title: "Konfirmasi Registrasi",
        data: {
            id: '',
            token: '',
            otp: '',
        },
        confirming: false,
        resending: false,
        error: '',
        remainingTime: 30, // Set durasi awal (60 detik)
        interval: null, // Untuk menyimpan ID interval

        get formattedTime() {
            const minutes = Math.floor(this.remainingTime / 60);
            const seconds = this.remainingTime % 60;
            return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        },

        startCountdown() {
            this.interval = setInterval(() => {
                if (this.remainingTime > 0) {
                    this.remainingTime -= 1;
                } else {
                    clearInterval(this.interval); // Hentikan countdown
                }
            }, 1000);
        },
        
        init(){
            document.title = this.title
            Alpine.store('masagi').currentPage = 'register_confirm'
            
            this.data.logo = Alpine.store('masagi').settings.auth_logo

            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            if (!token) {
                window.PineconeRouter.context.redirect('/aktivasi')
            }

            // Get user data based on token
            fetchPageData('/aktivasi/register/confirm/supply/' + token)
            .then(response => {
                if(response.found == 0){
                    // Redirect to home if token not found
                    window.PineconeRouter.context.redirect('/aktivasi')
                }

                this.data.id = response.id
                this.data.token = response.token
            })

            this.startCountdown();
        },

        confirm(){
            this.confirming = true

            // Gain javascript form validation
            if(this.data.otp == ''){
                this.error = 'Kode Registrasi tidak boleh kosong.'
                return;
            }

            // Check register_confirm using axios post
            const formData = new FormData();
            formData.append('id', this.data.id ?? '');
            formData.append('token', this.data.token ?? '');
            formData.append('otp', this.data.otp ?? '');
            axios.post('/aktivasi/register/confirm', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Pesantrenku-ID': Alpine.store('masagi').pesantrenID
                }
            }).then(response => {
                if(response.data.success == 1){
                    localStorage.setItem('heroic_token', response.data.jwt)
                    setTimeout(() => {
                        Alpine.store('masagi').sessionToken = localStorage.getItem('heroic_token')
                        window.location.replace('/')
                    })
                } else {
                    this.error = response.data.message
                }
            })
        },
    
        resendOTP() {
            this.resending = true

            // Check resend_otp using axios post
            const formData = new FormData();
            formData.append('id', this.data.id ?? '');
            formData.append('token', this.data.token ?? '');
            axios.post('/aktivasi/register/confirm/resend', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then(response => {
                if(response.data.success == 1){
                    let token = response.data.token
                    window.location.replace('/aktivasi/register/confirm/?token=' + token)
                } else {
                    this.error = response.data.message
                    this.resending = false
                }
            })
        }
    }
}