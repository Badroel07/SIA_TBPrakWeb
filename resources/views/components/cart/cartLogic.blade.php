{{-- ========================================================================= --}}
{{-- ALPINE.JS DATA BLOCK UTAMA (Keranjang + Notifikasi) --}}
{{-- ========================================================================= --}}
<div x-data="{ 
    // State Keranjang
    cart: [],
    serverCart: [], // Cart data dari server untuk user yang login
    showCart: false,
    showConfirmClear: false,
    isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
    isCustomer: {{ Auth::check() && Auth::user()->isCustomer() ? 'true' : 'false' }},
    loadingCart: false,
    
    // State Toast Notification
    toasts: [],
    toastId: 0,

    // Fungsi Keranjang
    get cartTotal() {
        if (this.isCustomer) {
            return this.serverCart.reduce((total, item) => total + (item.medicine.price * item.quantity), 0);
        }
        return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
    },
    
    get cartTotalQty() {
        if (this.isCustomer) {
            return this.serverCart.reduce((total, item) => total + item.quantity, 0);
        }
        return this.cart.reduce((total, item) => total + item.qty, 0);
    },

    get displayCart() {
        if (this.isCustomer) {
            return this.serverCart.map(item => ({
                id: item.medicine_id,
                name: item.medicine.name,
                price: item.medicine.price,
                image: item.medicine.image,
                qty: item.quantity,
                cartItemId: item.id
            }));
        }
        return this.cart;
    },
    
    init() {
        if (this.cart.length === 0) this.cart = [];
        if (this.isCustomer) this.fetchServerCart();
    },

    fetchServerCart() {
        this.loadingCart = true;
        fetch('{{ route('customer.cart.index') }}', {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.cartItems) {
                this.serverCart = data.cartItems;
            }
            this.loadingCart = false;
        })
        .catch(err => {
            console.error('Failed to fetch cart:', err);
            this.loadingCart = false;
        });
    },
    
    saveCart() {
        sessionStorage.setItem('simCart', JSON.stringify(this.cart));
    },

    addToCart(item, qty = 1) {
        if (!this.isLoggedIn) {
            window.location.href = '{{ route('login') }}';
            return;
        }

        if (this.isCustomer) {
            fetch('{{ route('customer.cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    medicine_id: item.id,
                    quantity: qty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.fetchServerCart();
                    this.showToast(data.message, 'success');
                } else {
                    this.showToast(data.message, 'error');
                }
            })
            .catch(err => {
                this.showToast('Gagal menambahkan ke keranjang', 'error');
            });
            return;
        }
        
        // Logic for non-customer logged in users (e.g. admin) or fallback
        this.showToast('Hanya customer yang dapat berbelanja.', 'info');
    },
    
    updateQty(id, change) {
        if (this.isCustomer) {
            const item = this.displayCart.find(i => i.id === id);
            if (!item) return;
            
            const newQty = item.qty + change;
            if (newQty <= 0) {
                this.removeItem(id);
                return;
            }
            
            fetch('{{ route('customer.cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    medicine_id: id,
                    quantity: newQty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.fetchServerCart();
                }
            });
            return;
        }

        // Logic for non-customer logged in users (e.g. admin) or fallback
        // No client-side cart manipulation for non-customers.
    },
    
    removeItem(id) {
        if (this.isCustomer) {
            fetch('{{ route('customer.cart.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ medicine_id: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.fetchServerCart();
                    this.showToast('Item dihapus dari keranjang.', 'info');
                }
            });
            return;
        }
        // Logic for non-customer logged in users (e.g. admin) or fallback
        // No client-side cart manipulation for non-customers.
    },

    showToast(message, type) {
        const id = this.toastId++;
        this.toasts.push({ id, message, type, show: false });
        setTimeout(() => {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.show = true;
        }, 10);
        setTimeout(() => this.removeToast(id), 3000);
    },

    removeToast(id) {
        const index = this.toasts.findIndex(t => t.id === id);
        if (index > -1) {
            this.toasts[index].show = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        }
    },

    confirmClear() {
        this.showCart = false;
        this.showConfirmClear = true;
    },

    clearCartConfirmed() {
        if (this.isCustomer) {
            fetch('{{ route('customer.cart.clear') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.serverCart = [];
                    this.showConfirmClear = false;
                    this.showToast('Keranjang berhasil dikosongkan.', 'warning');
                }
            });
            return;
        }
        this.cart = [];
        this.saveCart();
        this.showConfirmClear = false;
        this.showToast('Keranjang berhasil dikosongkan.', 'warning');
    }
}" x-init="init()" x-cloak>