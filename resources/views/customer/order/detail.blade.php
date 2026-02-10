@extends('customer.layouts.main')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <style>
        .detail-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: none;
            overflow: hidden;
        }
        
        .status-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 30px 0;
        }
        
        .status-timeline::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: #eee;
            z-index: 0;
        }
        
        .timeline-item {
            position: relative;
            z-index: 1;
            text-align: center;
            background: white;
            padding: 0 10px;
        }
        
        .timeline-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #eee;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 14px;
            transition: 0.3s;
        }
        
        .timeline-item.active .timeline-dot {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 5px rgba(111, 78, 55, 0.2);
        }
        
        .timeline-item.active p {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .order-summary-table td {
            padding: 15px 0;
            border-bottom: 1px dashed #eee;
        }
        .order-summary-table tr:last-child td {
            border-bottom: none;
        }
        
        .item-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background: #f8f9fa;
        }
    </style>

    <div class="container py-4">
        <div class="mb-4">
            <a href="{{ route('customer.history') }}" class="text-decoration-none text-muted small">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="detail-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                            <p class="text-muted small mb-0">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @php
                            $badgeClass = match($order->status) {
                                'pending' => 'bg-warning text-dark',
                                'completed' => 'bg-success text-white',
                                'cancelled' => 'bg-danger text-white',
                                default => 'bg-secondary text-white'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">{{ ucfirst($order->status) }}</span>
                    </div>
                    
                    <div class="status-timeline px-3">
                        <div class="timeline-item active">
                            <div class="timeline-dot"><i class="fas fa-clipboard-check"></i></div>
                            <p class="small mb-0">Pesanan Dibuat</p>
                        </div>
                        <div class="timeline-item {{ $order->status != 'pending' ? 'active' : '' }}">
                            <div class="timeline-dot"><i class="fas fa-wallet"></i></div>
                            <p class="small mb-0">Pembayaran</p>
                        </div>
                        <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                            <div class="timeline-dot"><i class="fas fa-check-circle"></i></div>
                            <p class="small mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
                
                <div class="detail-card p-4">
                    <h5 class="fw-bold mb-4">Rincian Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless order-summary-table mb-0">
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td style="width: 60px;">
                                        @if($item->product && $item->product->gambar)
                                            <img src="{{ asset($item->product->gambar) }}" class="item-thumb">
                                        @else
                                            <div class="item-thumb d-flex align-items-center justify-content-center text-muted">
                                                <i class="fas fa-mug-hot"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-dark fw-bold">{{ $item->product->nama ?? 'Produk Dihapus' }}</h6>
                                        <small class="text-muted">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                                    </td>
                                    <td class="text-end fw-bold text-primary-custom">
                                        Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="detail-card p-4 mb-4">
                    <h6 class="fw-bold mb-3">Informasi Pembayaran</h6>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Metode</span>
                        <span class="fw-bold">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method ?? '-')) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Status</span>
                        <span class="fw-bold {{ $order->payment ? 'text-success' : 'text-warning' }}">
                            {{ $order->payment ? 'Lunas' : 'Belum Dibayar' }}
                        </span>
                    </div>
                    @if($order->payment)
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Waktu Bayar</span>
                        <span>{{ \Carbon\Carbon::parse($order->payment->paid_at)->format('d M, H:i') }}</span>
                    </div>
                    @endif
                    
                    <hr class="my-3 opacity-25">
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total Total</span>
                        <span class="fw-bold fs-5 text-primary-custom">
                            @php $total = $order->orderItems->sum(fn($i) => $i->harga * $i->jumlah); @endphp
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    @if($order->status == 'pending')
                        <a href="{{ route('customer.payment', $order->id) }}" class="btn btn-primary w-100 rounded-pill mt-3">
                            Bayar Sekarang
                        </a>
                    @endif
                </div>
                
                <div class="detail-card p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-headset fa-3x text-muted opacity-25"></i>
                    </div>
                    <h6 class="fw-bold">Butuh Bantuan?</h6>
                    <p class="small text-muted mb-3">Jika ada masalah dengan pesanan ini, hubungi kami.</p>
                    
                    @php
                        $phoneNumber = '6282110778946'; 
                        
                        $message = "Halo Admin Beanie Coffee, saya butuh bantuan mengenai pesanan Order #" . str_pad($order->id, 5, '0', STR_PAD_LEFT);

                        $whatsappUrl = "https://wa.me/$phoneNumber?text=" . urlencode($message);
                    @endphp

                    <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-4">
                        <i class="fab fa-whatsapp me-2"></i>Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection