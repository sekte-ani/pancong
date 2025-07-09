<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk #{{ $order->id_pesanan }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Courier New', monospace; 
            font-size: 12px;
            line-height: 1.4;
            width: 58mm;
            margin: 0 auto;
        }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 8px; }
        .logo { font-size: 16px; font-weight: bold; margin-bottom: 3px; }
        .address { font-size: 10px; }
        .order-info { margin-bottom: 8px; font-size: 11px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 2px; }
        .items { border-bottom: 1px dashed #000; padding-bottom: 8px; margin-bottom: 8px; }
        .item { margin-bottom: 5px; font-size: 11px; }
        .item-name { font-weight: bold; }
        .item-line { display: flex; justify-content: space-between; }
        .addon { font-size: 10px; margin-left: 10px; color: #666; }
        .total { font-weight: bold; font-size: 12px; }
        .footer { text-align: center; font-size: 10px; margin-top: 8px; border-top: 1px dashed #000; padding-top: 8px; }
        .status { 
            display: inline-block; 
            padding: 2px 6px; 
            font-size: 9px; 
            font-weight: bold;
            border-radius: 3px;
        }
        .status-paid { background: #28a745; color: white; }
        .status-pending { background: #ffc107; color: #000; }
        .status-process { background: #007bff; color: white; }
        .status-ready { background: #17a2b8; color: white; }
        .status-done { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">PANCONG LUMER</div>
        <div class="address">
            Jl. Pancong No. 123<br>
            Depok, Jawa Barat<br>
            Telp: (021) 1234-5678
        </div>
    </div>

    <div class="order-info">
        <div class="row">
            <span>No. Pesanan:</span>
            <span><strong>#{{ $order->id_pesanan }}</strong></span>
        </div>
        <div class="row">
            <span>Tanggal:</span>
            <span>{{ $order->waktu_pesanan->format('d/m/Y') }}, {{ $order->created_at->format('H:i') }}</span>
        </div>
        <div class="row">
            <span>Pelanggan:</span>
            <span>{{ $order->user->nama }}</span>
        </div>
        @if($order->no_meja)
        <div class="row">
            <span>No. Meja:</span>
            <span>{{ $order->no_meja }}</span>
        </div>
        @endif
        <div class="row">
            <span>Status:</span>
            <span class="status status-{{ strtolower($order->status) }}">
                {{ strtoupper($order->status) }}
            </span>
        </div>
    </div>

    <div class="items">
        {{-- Regular Menu Items --}}
        @foreach($order->orderItems as $item)
        <div class="item">
            <div class="item-name">{{ $item->menu->nama_item }}</div>
            <div class="item-line">
                <span>{{ $item->qty }}x @ Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                <span>Rp {{ number_format($item->total, 0, ',', '.') }}</span>
            </div>
        </div>
        @endforeach

        {{-- Custom Menu Items --}}
        @foreach($order->customOrderItems as $item)
        <div class="item">
            <div class="item-name">{{ $item->baseMenu->nama_item }} (Custom)</div>
            <div class="item-line">
                <span>{{ $item->qty }}x @ Rp {{ number_format($item->total_price / $item->qty, 0, ',', '.') }}</span>
                <span>Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
            </div>
            @if($item->selected_addons)
                @foreach($item->selected_addons as $addon)
                <div class="addon">
                    + {{ $addon['nama_addon'] }}
                    @if($addon['qty'] > 1) ({{ $addon['qty'] }}x) @endif
                </div>
                @endforeach
            @endif
        </div>
        @endforeach
    </div>

    <div class="total">
        <div class="row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="row">
            <span>Tax (0%):</span>
            <span>Rp 0</span>
        </div>
        <div class="row total">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($order->catatan)
    <div style="margin: 8px 0; font-size: 10px;">
        <strong>Catatan:</strong> {{ $order->catatan }}
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Follow IG: @pancong_lumer</p>
        <p>Jam Operasional: 08:00 - 22:00</p>
        <p style="margin-top: 5px;">
            Dicetak: {{ now()->format('d/m/Y H:i:s') }}
        </p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>