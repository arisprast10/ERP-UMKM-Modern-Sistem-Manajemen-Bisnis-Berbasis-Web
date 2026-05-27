@extends('layouts.app')
@section('title', 'Point of Sale')
@section('content')
<div x-data="posSystem()" x-init="init()" class="h-full flex flex-col md:flex-row gap-4 -m-2">
    <!-- Left Panel: Products -->
    <div class="w-full md:w-7/12 bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex flex-col h-[85vh]">
        <div class="mb-4">
            <input type="text" x-model="searchQuery" @input.debounce.300ms="searchProducts()" @keydown.enter.prevent="searchProducts(true)" placeholder="Cari barcode / nama produk (bisa scan barcode di sini)..." class="w-full text-lg p-3 border-2 border-indigo-200 rounded-lg focus:border-indigo-500 focus:ring-0" autofocus>
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                <template x-for="product in products" :key="product.id">
                    <div @click="addToCart(product)" class="border rounded-lg p-3 cursor-pointer hover:border-indigo-500 hover:shadow-md transition-all bg-white relative overflow-hidden group">
                        <div class="h-24 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                            <template x-if="product.image">
                                <img :src="'/storage/' + product.image" class="object-cover w-full h-full">
                            </template>
                            <template x-if="!product.image">
                                <span class="text-gray-400">No Image</span>
                            </template>
                        </div>
                        <h4 class="font-medium text-gray-800 text-sm truncate" x-text="product.name"></h4>
                        <p class="text-indigo-600 font-bold mt-1" x-text="formatMoney(product.sell_price)"></p>
                        <p class="text-xs text-gray-500 mt-1">Stok: <span x-text="product.stock" :class="product.stock < 5 ? 'text-red-500 font-bold' : ''"></span></p>
                    </div>
                </template>
                <div x-show="products.length === 0" class="col-span-full py-10 text-center text-gray-500">
                    Tidak ada produk ditemukan.
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Cart -->
    <div class="w-full md:w-5/12 bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-[85vh]">
        <div class="p-3 bg-indigo-600 text-white rounded-t-lg">
            <h3 class="text-xl font-bold">Keranjang</h3>
        </div>
        
        <div class="flex-1 overflow-y-auto p-2">
            <template x-if="cart.length === 0">
                <div class="text-center py-10 text-gray-500">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Keranjang Kosong
                </div>
            </template>
            
            <ul class="divide-y divide-gray-100">
                <template x-for="(item, index) in cart" :key="item.id">
                    <li class="py-3 flex justify-between">
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-800" x-text="item.name"></h5>
                            <div class="flex items-center mt-2 space-x-2">
                                <button @click="updateQty(index, -1)" class="w-6 h-6 rounded bg-gray-200 text-gray-700 flex items-center justify-center hover:bg-gray-300">-</button>
                                <span class="text-sm font-medium w-6 text-center" x-text="item.qty"></span>
                                <button @click="updateQty(index, 1)" class="w-6 h-6 rounded bg-indigo-100 text-indigo-700 flex items-center justify-center hover:bg-indigo-200">+</button>
                                <span class="text-xs text-gray-500 ml-2" x-text="formatMoney(item.price)"></span>
                            </div>
                        </div>
                        <div class="text-right flex flex-col justify-between">
                            <span class="font-bold text-gray-800" x-text="formatMoney(item.price * item.qty)"></span>
                            <button @click="removeFromCart(index)" class="text-xs text-red-500 hover:text-red-700 mt-2">Hapus</button>
                        </div>
                    </li>
                </template>
            </ul>
        </div>

        <div class="p-4 border-t bg-gray-50 rounded-b-lg">
            <form action="{{ route('pos.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="items" :value="JSON.stringify(cart)">
                
                <div class="flex justify-between mb-2 text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span class="font-medium" x-text="formatMoney(subtotal)"></span>
                </div>
                
                <div class="flex justify-between items-center mb-3 text-sm text-gray-600">
                    <span>Diskon (Rp)</span>
                    <input type="text" name="discount" class="money-input w-24 border rounded p-1 text-right text-sm" @input="discount = parseInt($event.target.value.replace(/[^0-9]/g, '')) || 0">
                </div>
                
                <div class="flex justify-between mb-4 border-t pt-2">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-indigo-600" x-text="formatMoney(total)"></span>
                </div>

                <div class="space-y-3 mb-4">
                    <select name="customer_id" class="w-full border rounded-md p-2 text-sm">
                        <option value="">-- Pelanggan Umum --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex space-x-2">
                        <select name="payment_method" class="w-1/2 border rounded-md p-2 text-sm">
                            <option value="cash">Tunai (Cash)</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                        <input type="text" name="paid_amount" class="money-input w-1/2 border rounded-md p-2 text-sm" placeholder="Jml Bayar" @input="paidAmount = parseInt($event.target.value.replace(/[^0-9]/g, '')) || 0">
                    </div>
                    
                    <div class="flex justify-between items-center text-sm" x-show="paidAmount > 0">
                        <span class="text-gray-600">Kembalian:</span>
                        <span class="font-bold" :class="paidAmount < total ? 'text-red-500' : 'text-green-600'" x-text="formatMoney(paidAmount - total)"></span>
                    </div>
                </div>

                <button type="button" @click="submitCheckout()" :disabled="cart.length === 0 || paidAmount < total" 
                    class="w-full py-3 bg-indigo-600 text-white rounded-lg font-bold text-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    BAYAR SEKARANG
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function posSystem() {
    return {
        products: @json($products),
        allProducts: @json($products),
        cart: [],
        searchQuery: '',
        discount: 0,
        paidAmount: 0,
        
        init() {
            // initial load
        },
        
        searchProducts(fromEnter = false) {
            if (this.searchQuery.trim() === '') {
                this.products = this.allProducts;
                return;
            }
            
            let q = this.searchQuery.toLowerCase().trim();
            this.products = this.allProducts.filter(p => 
                p.name.toLowerCase().includes(q) || p.barcode.toLowerCase().includes(q)
            );

            // Auto add to cart if barcode exact match
            let exactMatch = this.allProducts.find(p => p.barcode.toLowerCase() === q);
            if (exactMatch && (this.searchQuery.length >= 4 || fromEnter)) {
                this.addToCart(exactMatch);
                this.searchQuery = '';
                this.products = this.allProducts;
            }
        },
        
        addToCart(product) {
            let itemIndex = this.cart.findIndex(item => item.id === product.id);
            if (itemIndex > -1) {
                if (this.cart[itemIndex].qty < product.stock) {
                    this.cart[itemIndex].qty++;
                } else {
                    alert('Stok tidak mencukupi!');
                }
            } else {
                this.cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.sell_price,
                    qty: 1,
                    max_qty: product.stock
                });
            }
        },
        
        removeFromCart(index) {
            this.cart.splice(index, 1);
        },
        
        updateQty(index, change) {
            let newQty = this.cart[index].qty + change;
            if (newQty > 0 && newQty <= this.cart[index].max_qty) {
                this.cart[index].qty = newQty;
            } else if (newQty > this.cart[index].max_qty) {
                alert('Stok tidak mencukupi!');
            }
        },
        
        get subtotal() {
            return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
        },
        
        get total() {
            return Math.max(0, this.subtotal - this.discount);
        },
        
        formatMoney(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
        },

        submitCheckout() {
            if (this.paidAmount < this.total) {
                alert('Uang pembayaran kurang!');
                return;
            }
            
            // Hapus format titik sebelum disubmit (karena .submit() manual tidak men-trigger event 'submit' global)
            let form = document.getElementById('checkout-form');
            form.querySelectorAll('.money-input').forEach(input => {
                input.value = input.value.replace(/\./g, '');
            });
            
            form.submit();
        }
    }
}
</script>
@endsection