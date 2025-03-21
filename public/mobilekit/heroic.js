import Toastify from 'toastify-js';
import axios from 'axios';
window.axios = axios;

(function(global) {
    global.$heroic = global.$heroic || {};
    global.$heroicHelper = global.$heroicHelper || {};

    /************************************************************************** 
     * Deklarasi variable
    **************************************************************************/
    global.$heroicHelper.cached = {};

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

                if(this.config.clearCachePath) {
                    delete $heroicHelper.cached[this.config.clearCachePath]
                }

                // Initialize page data if requested
                if(this.config.getUrl) {
                    // Use $heroicHelper.cached data if exists
                    if($heroicHelper.cached[this.config.getUrl]) {
                        // Process for list-type data
                        if($heroicHelper.cached[this.config.getUrl]?.paginatedData) {
                            $heroicHelper.cached[this.config.getUrl].paginatedData.forEach(item => {
                                this.paginatedData.push(item)
                            })
                            this.ui.nextPage = $heroicHelper.cached[this.config.getUrl].nextPage
                            this.ui.loadMore = $heroicHelper.cached[this.config.getUrl].loadMore
                        } 
                        // Process for row-type data
                        else {
                            this.data = $heroicHelper.cached[this.config.getUrl].data
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
                            $heroicHelper.cached[this.config.getUrl] = cached;
                        } else {
                            this.data = response.data;
                            let cached = {data: this.data}
                            $heroicHelper.cached[this.config.getUrl] = cached;
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
                        $heroicHelper.cached[this.config.getUrl] = cached;
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
                            delete $heroicHelper.cached[this.config.clearCachePath]
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

/** 
 * Alpine Debugger
 **/ 
if (document.body.classList.contains('env-development')) {

document.addEventListener('alpine:init', () => {

    function syntaxHighlight(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, null, 2);
        }
        json = json
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(?:\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            let cls = 'number';
            if (/^"/.test(match)) {
                cls = /:$/.test(match) ? 'key' : 'string';
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return `<span style="color: ${getColor(cls)}">${match}</span>`;
        });
    }
    
    function getColor(cls) {
        switch (cls) {
            case 'key': return '#2ca94b';
            case 'string': return '#032f62';
            case 'number': return '#005cc5';
            case 'boolean': return '#e36209';
            case 'null': return '#6a737d';
            default: return '#000';
        }
    }  

    Alpine.directive('debug', (el) => {
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        wrapper.style.marginTop = '10px';

        const elId = el.id ? `#${el.id}` : `${el.tagName.toLowerCase()}[x-data]`;
        const accordionItem = document.createElement('div');
        accordionItem.style.marginBottom = '5px';

        const toggleBtn = document.createElement('button');
        toggleBtn.innerHTML = `Alpine.data Debug 🐞<br><code style="color:#81d9ff">${elId}</code>`;
        toggleBtn.style = `
            background: #333; color: white; font-size: 13px; padding: 5px 10px; border: none;
            border-radius: 4px; cursor: pointer; width: 100%; text-align: left; line-height: 14px;
        `;

        const panel = document.createElement('div');
        panel.style = `
            display: none; border: 1px solid #ccc; border-radius: 4px; padding: 10px;
            background: #f9f9f9; font-size: 16px; line-height: 18px; white-space: pre; overflow: auto; max-height: 400px;
            font-family: monospace;
        `;

        let interval = null;

        toggleBtn.addEventListener('click', () => {
            const isOpen = panel.style.display === 'block';
            const allPanels = document.querySelectorAll('.debug-panel');
            allPanels.forEach(p => p.style.display = 'none'); // Close all other panels
            if (isOpen) {
                panel.style.display = 'none';
                clearInterval(interval);
            } else {
                panel.style.display = 'block';
                updatePanel();
                interval = setInterval(updatePanel, 1000);
            }
        });      

        function updatePanel() {
            try {
                const data = Alpine.$data(el);
                panel.innerHTML = `<pre style="margin: 0; font-family: monospace;">${syntaxHighlight(data)}</pre>`;
            } catch (e) {
                panel.textContent = 'Error loading data.';
            }
        }

        accordionItem.appendChild(toggleBtn);
        accordionItem.appendChild(panel);

        // Append to a container for accordion behavior
        const accordionContainer = document.getElementById('alpine-debugger-accordion');
        if (accordionContainer) {
            accordionContainer.appendChild(accordionItem);
        } else {
            // Create the accordion container if it doesn't exist
            const newAccordionContainer = document.createElement('div');
            newAccordionContainer.id = 'alpine-debugger-accordion';
            newAccordionContainer.style.position = 'fixed';
            newAccordionContainer.style.bottom = '10px';
            newAccordionContainer.style.right = '10px';
            newAccordionContainer.style.zIndex = '100000';
            newAccordionContainer.style.maxHeight = '100vh';
            newAccordionContainer.style.overflowY = 'auto';
            document.body.appendChild(newAccordionContainer);
            newAccordionContainer.appendChild(accordionItem);
        }
    });

    // Simpan nama store secara manual atau via registerStore
    const storeNames = window.__ALPINE_STORE_NAMES_DEBUG__ || [];
    if (storeNames.length === 0) return;

    // 🔘 Tombol toggle di luar container
    const toggleBtn = document.createElement('button');
    toggleBtn.innerText = '🐞 Store Debugger';
    toggleBtn.style = `
        position: fixed;
        bottom: 10px;
        left: 10px;
        background: #333;
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        z-index: 100001;
    `;
    document.body.appendChild(toggleBtn);

    // 📦 Kontainer debugger
    const container = document.createElement('div');
    container.style.position = 'fixed';
    container.style.bottom = '50px';
    container.style.left = '10px';
    container.style.zIndex = '100000';
    container.style.maxHeight = '90vh';
    container.style.overflowY = 'auto';
    container.style.padding = '10px';
    container.style.background = '#fff';
    container.style.border = '1px solid #ccc';
    container.style.borderRadius = '6px';
    container.style.fontSize = '13px';
    container.style.fontFamily = 'monospace';
    container.style.maxWidth = '350px';
    container.style.display = 'none';

    const title = document.createElement('div');
    title.textContent = '🐞 Alpine.store()';
    title.style.fontWeight = 'bold';
    title.style.marginBottom = '8px';
    container.appendChild(title);

    storeNames.forEach(name => {
        const toggle = document.createElement('button');
        toggle.innerText = `$store.${name}`;
        toggle.style = `
            display: block;
            background: #333;
            color: white;
            font-size: 13px;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 4px;
            text-align: left;
            width: 100%;
        `;

        const panel = document.createElement('div');
        panel.style = `
            display: none;
            background: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 10px;
            max-height: 400px;
            overflow: auto;
            font-size: 16px;
        `;

        toggle.addEventListener('click', () => {
            const isOpen = panel.style.display === 'block';
            panel.style.display = isOpen ? 'none' : 'block';
            if (!isOpen) {
                const data = Alpine.store(name);
                panel.innerHTML = `<pre style="margin: 0;">${syntaxHighlight(data)}</pre>`;
            }
        });

        container.appendChild(toggle);
        container.appendChild(panel);
    });

    document.body.appendChild(container);

    toggleBtn.addEventListener('click', () => {
        const isVisible = container.style.display === 'block';
        container.style.display = isVisible ? 'none' : 'block';
    });
});
}