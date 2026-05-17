@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Pesanan Masuk
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola pesanan customer
        </p>

    </div>

</div>

<div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-3">
        <input id="order-search" type="search" placeholder="Cari customer, meja, atau ID" class="input input-bordered rounded-full w-64" />
        <select id="order-filter" class="select select-bordered rounded-full">
            <option value="all">Semua</option>
            <option value="open">Terbuka (belum selesai)</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>
    <div class="text-sm text-gray-500">Total pesanan: <span class="font-semibold text-gray-700">{{ $orders->count() }}</span></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($orders as $order)

    @php
        $statusColor = match($order->status) {
            'MEMESAN' => 'bg-orange-100 text-orange-700',
            'DIPROSES' => 'bg-blue-100 text-blue-800',
            'SIAP' => 'bg-green-100 text-green-800',
            'SELESAI' => 'bg-gray-200 text-gray-700',
            default => 'bg-gray-100 text-gray-800'
        };
    @endphp

    <div class="order-card bg-white border rounded-2xl shadow-sm p-4 flex flex-col justify-between" data-status="{{ strtolower($order->status) }}" data-customer="{{ strtolower($order->customer_name) }}" data-table="{{ strtolower($order->table_number) }}" data-id="{{ $order->id }}">

        <div class="flex items-start justify-between gap-3">
            <div>
                <div class="text-sm text-gray-500">Order</div>
                <div class="text-lg font-bold text-gray-800">#{{ $order->id }}</div>
                <div class="text-sm text-gray-500">{{ $order->created_at->format('d M H:i') }}</div>
            </div>

            <div class="text-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $statusColor }}">
                    <span class="text-xs font-semibold">{{ $order->status }}</span>
                </div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-2 text-sm text-gray-600">
            <div>
                <div class="text-xs text-gray-400">Customer</div>
                <div class="font-medium text-gray-800">{{ $order->customer_name }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400">Meja</div>
                <div class="font-medium text-gray-800">{{ $order->table_number }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400">Total</div>
                <div class="font-semibold text-orange-500">Rp {{ number_format($order->total) }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-400">Items (Batch Terbaru)</div>
                <div class="font-medium text-gray-800">
                    {{ $order->items->count() }} item
                    @php
                        $maxBatch = $order->items->max('batch') ?? 1;
                    @endphp
                    <span class="ml-1 px-2 py-0.5 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                        #{{ $maxBatch }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-end gap-2">
            <a
                href="/admin/orders/{{ $order->id }}"
                class="inline-flex items-center justify-center h-10 px-5 bg-white hover:bg-gray-100 text-gray-700 text-sm font-semibold rounded-2xl shadow-sm border border-gray-200 transition-all duration-150">
                Lihat
            </a>
           <button
            class="h-10 px-5 bg-orange-500 hover:bg-orange-600 active:scale-95 text-white text-sm font-semibold rounded-2xl shadow-sm transition-all duration-150 border-0"
            onclick="openPaymentModal(
                {{ $order->id }},
                {{ $order->total }}
            )">
            Cetak
            </button>
            {{-- @if($order->status !== 'SELESAI')
                <form action="/admin/orders/{{ $order->id }}/status" method="post" onsubmit="return confirm('Tandai sebagai SELESAI?')">
                    @csrf
                    <input type="hidden" name="status" value="SELESAI">
                    <button type="submit" class="btn btn-sm bg-green-500 text-white">Selesai</button>
                </form>
            @endif --}}
        </div>

    </div>

    @endforeach

</div>

<script>
    function applyFilter() {
        const q = document.getElementById('order-search').value.trim().toLowerCase();
        const f = document.getElementById('order-filter').value;
        document.querySelectorAll('.order-card').forEach(card => {
            const status = card.dataset.status || '';
            const customer = card.dataset.customer || '';
            const table = card.dataset.table || '';
            const id = card.dataset.id || '';
            const matchesFilter = (f === 'all') || (f === 'open' && status !== 'selesai') || (f === 'selesai' && status === 'selesai');
            const matchesQuery = !q || customer.includes(q) || table.includes(q) || id.includes(q);
            card.style.display = (matchesFilter && matchesQuery) ? '' : 'none';
        });
    }
    document.getElementById('order-search').addEventListener('input', applyFilter);
    document.getElementById('order-filter').addEventListener('change', applyFilter);


        function openPaymentModal(id, total)
        {
            document.getElementById('order_id').value = id;

            document.getElementById('total').value =
                'Rp ' + total.toLocaleString();

            document.getElementById('paid').value = '';

            document.getElementById('change').value = '';

            document.getElementById('printForm').action =
                '/admin/orders/' + id + '/print';

            document.getElementById('paymentModal').showModal();

            window.currentTotal = total;
}

        function calculateChange()
        {
            let paid =
                parseInt(document.getElementById('paid').value) || 0;

            let total = window.currentTotal;

            let change = paid - total;

            document.getElementById('change').value =
                'Rp ' + change.toLocaleString();

            document.getElementById('paid_input').value = paid;
        }

        function closePaymentModal()
        {
            document
                .getElementById('paymentModal')
                .close();
        }


</script>

@endsection

<dialog id="paymentModal" class="modal">

    <div class="modal-box rounded-3xl">

        <h3 class="font-bold text-lg mb-4">
            Pembayaran
        </h3>

        <input type="hidden" id="order_id">

        <div class="mb-3">
            <label class="text-sm">Total</label>

            <input
                type="text"
                id="total"
                class="input input-bordered w-full"
                readonly>
        </div>

        <div class="mb-3">
            <label class="text-sm">Uang Bayar</label>

            <input
                type="number"
                id="paid"
                class="input input-bordered w-full"
                oninput="calculateChange()">
        </div>

        <div class="mb-4">
            <label class="text-sm">Kembalian</label>

            <input
                type="text"
                id="change"
                class="input input-bordered w-full"
                readonly>
        </div>

        <div class="flex justify-end gap-2">

            <button
                type="button"
                onclick="closePaymentModal()"
                class="inline-flex items-center justify-center h-10 px-5 bg-white hover:bg-gray-100 text-gray-700 text-sm font-semibold rounded-2xl shadow-sm border border-gray-200 transition-all duration-150">
                Tutup
            </button>

            <form id="printForm" method="GET" target="_blank">

            <input
                type="hidden"
                name="paid"
                id="paid_input">

            <button
                type="submit"
                class="h-11 px-6 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-2xl shadow-sm transition-all duration-200">
                Cetak
            </button>

            </form>

        </div>

    </div>

</dialog>