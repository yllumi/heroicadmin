import axios from 'axios';
import Toastify from 'toastify-js';

(function(global) {
    global.$heroic = global.$heroic || {};
    global.$heroicHelper = global.$heroicHelper || {};

    /************************************************************************** 
     * Deklarasi variable
    **************************************************************************/
    let cached = {};

    /************************************************************************** 
     * Page Data
     * Fungsi untuk transaksi data dasar yang dibutuhkan oleh halaman 
     * tanpa harus menulis kode yang sama berulang-ulang
     **************************************************************************/
    global.$heroic = function({
        getUrl = null, 
        title = null,
        perpage = 5,
        postUrl = null,
        postRedirect = null,
        clearCachePath = null
        } = {}) {

        return {
            // Configuration properties
            config: {
                title,
                getUrl,
                perpage,
                postUrl,
                postRedirect,
                clearCachePath
            },

            // UI properties
            ui: {
                loading: false,
                submitting: false,
                empty: false,
                nextPage: null,
                loadMore: false,
                error: false,
                errorMessage: '',
            },

            // Raw data properties
            data: {},

            // PaginatedData data properties
            paginatedData: [],

            // Model properties
            model: {},

            // Model error messages
            modelMessage: {},

            // Function to initialize the page
            init() {
                // Set the page title
                this._setTitle();

                // Initialize page data if requested
                if(this.config.getUrl) {
                    // Use cached data if exists
                    if(cached[this.config.getUrl]) {
                        // Process for list-type data
                        if(cached[this.config.getUrl]?.paginatedData) {
                            cached[this.config.getUrl].paginatedData.forEach(item => {
                                this.paginatedData.push(item)
                            })
                            this.ui.nextPage = cached[this.config.getUrl].nextPage
                            this.ui.loadMore = cached[this.config.getUrl].loadMore
                        } 
                        // Process for row-type data
                        else {
                            this.data = cached[this.config.getUrl].data
                        }
                    } else {
                        this._fetchPageData();
                    }
                }

                window.scrollTo(0,0)
            },

            _fetchPageData() {
                this.ui.loading = true;
                $heroicHelper.fetch(this.config.getUrl)
                .then(response => {
                    if(response.response_code == 200) {
                        // Check if response data is a paginatedData
                        if(response?.paginatedData) {
                            this.ui.nextPage = 2
                            this.ui.loadMore = true
                            response.paginatedData.forEach(item => {
                                this.paginatedData.push(item)
                            })
                            // Save response data to cache
                            let cached = {paginatedData: this.paginatedData, nextPage: this.ui.nextPage, loadMore: this.ui.loadMore}
                            cached[this.config.getUrl] = cached;
                        } else {
                            this.data = response.data;
                            let cached = {data: this.data}
                            cached[this.config.getUrl] = cached;
                        }

                    } else {
                        this.ui.error = true;
                        this.ui.errorMessage = response.message;
                    }
                })
                .catch(error => {
                    this.ui.error = true;
                    console.error('Error fetching page data:', error);
                })
                .finally(() => {
                    this.ui.loading = false;
                });
            },

            loadMore() {
                this._fetchPaginatedData(this.ui.nextPage)
            },

            _fetchPaginatedData(page) {
                this.ui.loading = true;
                $heroicHelper.fetch(this.config.getUrl + `?page=` + page)
                .then(response => {
                    if(response.response_code == 200) {
                        // Check if response data is a paginatedData
                        if(response.paginatedData.length > 0) {
                            this.ui.nextPage += 1;
                            response.paginatedData.forEach(item => {
                                this.paginatedData.push(item)
                            })
                        } else {
                            this.ui.empty = true;
                            this.ui.nextPage = null;
                            this.ui.loadMore = false;
                        }
                        // Save response data to cache
                        let cached = {paginatedData: this.paginatedData, nextPage: this.ui.nextPage, loadMore: this.ui.loadMore}
                        cached[this.config.getUrl] = cached;
                    } else {
                        this.ui.error = true;
                        this.ui.errorMessage = response.message;
                    }
                })
                .catch(error => {
                    this.ui.error = true;
                    console.error('Error fetching page data:', error);
                })
                .finally(() => {
                    this.ui.loading = false;
                });
            },

            _setTitle() {
                if(this.config.title){
                    document.title = this.config.title;
                }
            },

            async submitData(params = {}) {
                if(params?.confirm) {
                    const confirmedBoolean = await Prompts.confirm(params.confirm);
                    if (!confirmedBoolean) return;
                }

                this.ui.submitting = true
                this.modelMessage = {}
                $heroicHelper.post(this.config.postUrl, this.model)
                .then(data => {
                    if(data.response_code == 200) {
                        if(this.config.postRedirect) {
                            delete cached[this.config.clearCachePath]
                            window.PineconeRouter.context.redirect(this.config.postRedirect)
                        } else {
                            this.model = {}
                            $heroic.helper.toastr('Data saved', 'success', 'bottom');
                        }
                    } else {
                        this.modelMessage = data.model_messages
                    }
                })
            
            }
        }
    }

    /************************************************************************** 
     * Fetch Ajax Data
     **************************************************************************/
    global.$heroicHelper.fetch = function(page, headers = {}){ 
        // Memastikan base_url diakhiri dengan '/'
        if (!base_url.endsWith('/')) {
            base_url += '/';
        }
    
        // Menggabungkan base_url dan page
        let fullUrl = base_url + page;
    
        // Menentukan separator berdasarkan ada atau tidaknya '?'
        let separator = fullUrl.includes('?') ? '&' : '?';
    
        return axios
            .get(fullUrl, headers)
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.log(error);
            });
    }

    /************************************************************************** 
     * Post Ajax Data
     **************************************************************************/
    global.$heroicHelper.post = function(url, data = {}, headers = {}) {
        // Membuat objek FormData
        const formData = new FormData();
    
        // Menambahkan data yang dipassing dari parameter ke FormData
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const value = data[key];
    
                if (Array.isArray(value)) {
                    // Jika nilai adalah array, tambahkan setiap elemen
                    value.forEach(item => formData.append(`${key}[]`, item));
                } else if (value instanceof File || value instanceof Blob) {
                    // Jika nilai adalah File atau Blob, tambahkan langsung
                    formData.append(key, value);
                } else if (typeof value === 'object' && value !== null) {
                    // Jika nilai adalah objek, Anda mungkin perlu serialisasi ke JSON
                    formData.append(key, JSON.stringify(value));
                } else {
                    // Nilai primitif (string, number, boolean)
                    formData.append(key, value);
                }
            }
        }
    
        return axios
            .post(url, formData, {
                headers: {
                    Authorization: `Bearer ` + localStorage.getItem('heroic_token')
                }
            })
            .then(response => {
                return response.data;
            })
            .catch(error => {
                console.error(error);
                // Tangani kesalahan sesuai kebutuhan
            });
    }

    /************************************************************************** 
     * Helper Functions
     **************************************************************************/

    // COOKIE SETTER GETTER
    global.$heroicHelper.setCookie = function(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    global.$heroicHelper.getCookie = function(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    global.$heroicHelper.nl2br = function(str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    global.$heroicHelper.formatDate = function(dateString) {
        if(dateString && dateString != '0000-00-00'){
            const date = new Date(dateString);
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return new Intl.DateTimeFormat('id-ID', options).format(date);
        }
        return '';
    }

    global.$heroicHelper.toastr = function(message, type = 'success', position = 'top'){
        Toastify({
            text: message,
            close: true,
            duration: 5000,
            className: type,
            gravity: position,
            offset: {y:40},
        }).showToast();
    }

    global.$heroicHelper.currency = function(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

})(window);

window.axios = axios;