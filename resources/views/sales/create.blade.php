@extends('layouts.app')

@section('title', 'Transaksi Penjualan Baru')
@section('page-title', 'Kasir Penjualan (Stock-Out)')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('sales.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center space-x-1">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Riwayat Penjualan</span>
        </a>
    </div>

    <form action="{{ route('sales.store') }}" method="POST" id="salesForm" class="space-y-6">
        @csrf

        <!-- Header Information -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
            <h4 class="font-bold text-slate-800 text-base flex items-center space-x-2">
                <i class="fa-solid fa-cash-register text-emerald-600"></i>
                <span>Informasi Transaksi Kasir</span>
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="sold_at" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Waktu Transaksi Penjualan <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" id="sold_at" name="sold_at" value="{{ old('sold_at', now()->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none text-sm">
                </div>

                <div>
                    <label for="notes" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Catatan / Nama Pelanggan (Opsional)</label>
                    <input type="text" id="notes" name="notes" value="{{ old('notes') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none text-sm"
                           placeholder="Contoh: Pembeli Walk-in / Customer Umum">
                </div>
            </div>
        </div>

        <!-- Detail Items Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h4 class="font-bold text-slate-800 text-base">Item Penjualan Produk</h4>
                    <p class="text-xs text-slate-500">Pilih produk dan tentukan kuantitas yang terjual.</p>
                </div>
                <button type="button" onclick="addItemRow()" class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-semibold transition border border-emerald-200">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Baris Produk</span>
                </button>
            </div>

            <div class="overflow-x-auto p-4">
                <table class="w-full text-left text-sm" id="itemsTable">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold" style="width: 45%;">Pilih Produk (Stok Tersedia)</th>
                            <th class="px-4 py-3 font-semibold text-right" style="width: 20%;">Harga Satuan</th>
                            <th class="px-4 py-3 font-semibold text-center" style="width: 15%;">Jumlah (Qty)</th>
                            <th class="px-4 py-3 font-semibold text-right" style="width: 20%;">Subtotal</th>
                            <th class="px-2 py-3 text-center" style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsContainer" class="divide-y divide-slate-100">
                        <!-- Initial Row -->
                        <tr class="item-row hover:bg-slate-50/50 transition">
                            <td class="p-3">
                                <select name="items[0][product_id]" required onchange="onProductChange(this)"
                                        class="product-select w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <option value="" data-price="0" data-stock="0">-- Pilih Produk --</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}" data-price="{{ $prod->selling_price }}" data-stock="{{ $prod->stock }}">
                                            {{ $prod->sku }} - {{ $prod->name }} [Stok: {{ $prod->stock }}]
                                        </option>
                                    @endforeach
                                </select>
                                <span class="stock-warning text-[11px] text-amber-600 font-medium block mt-1 hidden"></span>
                            </td>
                            <td class="p-3 text-right font-mono text-sm text-slate-700 price-display">
                                Rp 0
                            </td>
                            <td class="p-3 text-center">
                                <input type="number" min="1" name="items[0][quantity]" value="1" required oninput="calculateRow(this)"
                                       class="qty-input w-24 text-center px-2 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
                            </td>
                            <td class="p-3 text-right font-mono font-bold text-slate-900 row-subtotal">
                                Rp 0
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" onclick="removeItemRow(this)" class="text-slate-400 hover:text-rose-600 p-1 rounded-lg">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Grand Total Preview -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <span class="text-xs text-slate-500">
                    <i class="fa-solid fa-lock text-emerald-500 mr-1"></i>
                    Harga dan total dihitung otomatis oleh server dari database & mencegah overselling.
                </span>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-600">Total Pembayaran:</span>
                    <span id="grandTotalText" class="text-2xl font-bold font-mono text-emerald-600">Rp 0</span>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('sales.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-lg shadow-emerald-600/30 transition flex items-center space-x-2">
                <i class="fa-solid fa-check"></i>
                <span>Proses Transaksi Penjualan</span>
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
    let rowIndex = 1;
    const productsOptions = `
        <option value="" data-price="0" data-stock="0">-- Pilih Produk --</option>
        @foreach($products as $prod)
            <option value="{{ $prod->id }}" data-price="{{ $prod->selling_price }}" data-stock="{{ $prod->stock }}">
                {{ $prod->sku }} - {{ $prod->name }} [Stok: {{ $prod->stock }}]
            </option>
        @endforeach
    `;

    function addItemRow() {
        const container = document.getElementById('itemsContainer');
        const tr = document.createElement('tr');
        tr.className = 'item-row hover:bg-slate-50/50 transition';
        tr.innerHTML = `
            <td class="p-3">
                <select name="items[${rowIndex}][product_id]" required onchange="onProductChange(this)"
                        class="product-select w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none">
                    ${productsOptions}
                </select>
                <span class="stock-warning text-[11px] text-amber-600 font-medium block mt-1 hidden"></span>
            </td>
            <td class="p-3 text-right font-mono text-sm text-slate-700 price-display">
                Rp 0
            </td>
            <td class="p-3 text-center">
                <input type="number" min="1" name="items[${rowIndex}][quantity]" value="1" required oninput="calculateRow(this)"
                       class="qty-input w-24 text-center px-2 py-2 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
            </td>
            <td class="p-3 text-right font-mono font-bold text-slate-900 row-subtotal">
                Rp 0
            </td>
            <td class="p-3 text-center">
                <button type="button" onclick="removeItemRow(this)" class="text-slate-400 hover:text-rose-600 p-1 rounded-lg">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </td>
        `;
        container.appendChild(tr);
        rowIndex++;
        calculateGrandTotal();
    }

    function removeItemRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length <= 1) {
            alert('Minimal harus ada 1 produk dalam transaksi.');
            return;
        }
        btn.closest('tr').remove();
        calculateGrandTotal();
    }

    function onProductChange(select) {
        const row = select.closest('tr');
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

        const qtyInput = row.querySelector('.qty-input');
        qtyInput.max = stock;

        row.querySelector('.price-display').innerText = 'Rp ' + price.toLocaleString('id-ID');
        row.setAttribute('data-price', price);
        row.setAttribute('data-stock', stock);

        calculateRow(qtyInput);
    }

    function calculateRow(element) {
        const row = element.closest('tr');
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const price = parseFloat(row.getAttribute('data-price')) || 0;
        const stock = parseInt(row.getAttribute('data-stock')) || 0;
        const warning = row.querySelector('.stock-warning');

        if (stock > 0 && qty > stock) {
            warning.innerText = `Peringatan: Kuantitas (${qty}) melebihi stok yang tersedia (${stock})!`;
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }

        const subtotal = qty * price;
        row.querySelector('.row-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input')?.value) || 0;
            const price = parseFloat(row.getAttribute('data-price')) || 0;
            total += (qty * price);
        });
        document.getElementById('grandTotalText').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endpush
@endsection
