@php
    use App\Models\User;
    use App\Models\Buku;
    use App\Models\Pesanan;
    use App\Models\Refund;
    use App\Models\KategoriBuku;

    // Initialize values with safe defaults
    $totalOrders = 0;
    $completedOrders = 0;
    $pendingOrders = 0;
    $cancelledOrders = 0;
    $totalSales = 0;
    $monthlySales = 0;
    $previousMonthSales = 0;
    $salesPercentageChange = 0;
    $totalRefunds = 0;
    $pendingRefunds = 0;
    $refundAmount = 0;

    try {
        // Calculate order statistics
        $totalOrders = Pesanan::count() ?: 0;
        $completedOrders = Pesanan::where('status', 'selesai')->count() ?: 0;
        $pendingOrders = Pesanan::whereIn('status', ['diproses', 'disetujui', 'dikemas', 'diantarkan'])->count() ?: 0;
        $cancelledOrders = Pesanan::whereIn('status', ['cancelled', 'dibatalkan'])->count() ?: 0;

        // Calculate sales amount
        $totalSales = Pesanan::where('status', 'selesai')->sum('total_harga') ?: 0;
        $monthlySales =
            Pesanan::where('status', 'selesai')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total_harga') ?:
            0;
        $previousMonthSales =
            Pesanan::where('status', 'selesai')
                ->whereYear('created_at', now()->subMonth()->year)
                ->whereMonth('created_at', now()->subMonth()->month)
                ->sum('total_harga') ?:
            0;

        // Calculate percentage change for sales (safely)
        if ($previousMonthSales > 0) {
            $salesPercentageChange = (($monthlySales - $previousMonthSales) / $previousMonthSales) * 100;
        } else {
            $salesPercentageChange = $monthlySales > 0 ? 100 : 0; // If previous month was 0, but current month has sales, that's a 100% increase
    }

    // Get refund statistics
    $totalRefunds = Refund::count() ?: 0;
    $pendingRefunds = Refund::where('status', 'pending')->count() ?: 0;
    $refundAmount = Refund::where('status', 'completed')->sum('jumlah') ?: 0;
} catch (\Exception $e) {
    // Log error but continue displaying the dashboard
    \Log::error('Dashboard calculation error: ' . $e->getMessage());
    }
@endphp
<x-layouts.admin.dashboard :pageName="$pageName ?? 'No title'" :currentPage="$currentPage ?? 'Dashboard'" :breadcrumbs="$breadcrumbs ?? []">
    <!-- Sales Overview Cards Row -->
    <div class="col-12 mb-4">
        <h5 class="mb-3">Ikhtisar Penjualan</h5>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Total Penjualan</h6>
                                <h3 class="fw-bold mb-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-muted text-sm">Dari pesanan selesai</p>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="ti ti-report-money bg-light-success text-success p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Pendapatan Bulanan</h6>
                                <h3 class="fw-bold mb-1">Rp {{ number_format($monthlySales, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <span class="{{ $salesPercentageChange >= 0 ? 'text-success' : 'text-danger' }}">
                                        <i
                                            class="ti ti-trending-{{ $salesPercentageChange >= 0 ? 'up' : 'down' }} me-1"></i>
                                        {{ abs(round($salesPercentageChange, 1)) }}%
                                    </span>
                                    dari bulan lalu
                                </p>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="ti ti-calendar-stats bg-light-primary text-primary p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Total Pesanan</h6>
                                <h3 class="fw-bold mb-1">{{ $totalOrders }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <span class="text-success">{{ $completedOrders }}</span> selesai,
                                    <span class="text-warning">{{ $pendingOrders }}</span> dalam proses
                                </p>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="ti ti-shopping-cart bg-light-warning text-warning p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Pesanan Dibatalkan</h6>
                                <h3 class="fw-bold mb-1">{{ $cancelledOrders }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <span
                                        class="text-danger">{{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}%</span>
                                    dari total pesanan
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-receipt-off bg-light-danger text-danger p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Stats Cards Row -->
    <div class="col-12 mb-4">
        <h5 class="mb-3">Statistik Sistem</h5>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Total Pengguna</h6>
                                <h3 class="fw-bold mb-1">{{ User::count() }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <a href="{{ route('pengguna.index') }}" class="text-primary">
                                        Kelola pengguna <i class="ti ti-arrow-right ms-1"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-users bg-light-info text-info p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Total Produk</h6>
                                <h3 class="fw-bold mb-1">{{ Buku::count() }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <a href="{{ route('buku.index') }}" class="text-primary">
                                        Kelola produk <i class="ti ti-arrow-right ms-1"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-notebook bg-light-success text-success p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Kategori</h6>
                                <h3 class="fw-bold mb-1">{{ KategoriBuku::count() }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <a href="{{ route('kategori-buku.index') }}" class="text-primary">
                                        Kelola kategori <i class="ti ti-arrow-right ms-1"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-list bg-light-warning text-warning p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Refund</h6>
                                <h3 class="fw-bold mb-1">{{ $totalRefunds }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <span class="text-warning">{{ $pendingRefunds }}</span> permintaan pending
                                </p>
                            </div>
                            <div class="col-auto">
                                <i
                                    class="ti ti-cash-banknote-off bg-light-danger text-danger p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Stats Cards Row -->
    <div class="col-12 mb-4">
        <h5 class="mb-3">Statistik Inventaris</h5>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Produk Stok Rendah</h6>
                                <h3 class="fw-bold mb-1">{{ Buku::where('stok', '<', 10)->count() }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <a href="{{ route('buku.index') }}?stock=low" class="text-danger">
                                        Lihat produk <i class="ti ti-arrow-right ms-1"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-alert-circle bg-light-danger text-danger p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Stok Habis</h6>
                                <h3 class="fw-bold mb-1">{{ Buku::where('stok', 0)->count() }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    <a href="{{ route('buku.index') }}?stock=out" class="text-danger">
                                        Kelola inventaris <i class="ti ti-arrow-right ms-1"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-circle-off bg-light-danger text-danger p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Penjualan Terbaik</h6>
                                @php
                                    $totalSold = \DB::table('pesanan_items')
                                        ->join('pesanans', 'pesanan_items.pesanan_id', '=', 'pesanans.id')
                                        ->where('pesanans.status', 'selesai')
                                        ->sum('pesanan_items.jumlah');
                                @endphp
                                <h3 class="fw-bold mb-1">{{ $totalSold }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    Total buku terjual
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-chart-bar bg-light-success text-success p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25 f-w-400 text-muted">Rata-Rata Nilai Pesanan</h6>
                                @php
                                    $avgOrderValue = $completedOrders > 0 ? $totalSales / $completedOrders : 0;
                                @endphp
                                <h3 class="fw-bold mb-1">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-muted text-sm">
                                    {{ $completedOrders > 0 ? 'Per pesanan selesai' : 'Belum ada pesanan selesai' }}
                                </p>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-calculator bg-light-primary text-primary p-3 rounded-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Statistics Row -->
    <div class="col-12">
        <div class="row">
            <!-- Sales Overview Chart -->
            <div class="col-xl-8 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Ikhtisar Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <div id="sales-overview-chart"></div>
                    </div>
                </div>
            </div>

            <!-- Order Status Chart -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Status Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div id="order-status-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Row -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Pesanan Terbaru</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                try {
                                    $recentOrders = Pesanan::with('user')->latest()->take(5)->get();
                                } catch (\Exception $e) {
                                    $recentOrders = collect([]);
                                    \Log::error('Dashboard recent orders error: ' . $e->getMessage());
                                }
                            @endphp
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->kode_pesanan }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($order->status == 'diproses')
                                            <span class="badge bg-warning text-dark">Diproses</span>
                                        @elseif($order->status == 'disetujui')
                                            <span class="badge bg-info">Disetujui</span>
                                        @elseif($order->status == 'dikemas')
                                            <span class="badge bg-primary">Dikemas</span>
                                        @elseif($order->status == 'diantarkan')
                                            <span class="badge bg-primary">Diantarkan</span>
                                        @elseif($order->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($order->status == 'dibatalkan' || $order->status == 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @elseif($order->status == 'refunded')
                                            <span class="badge bg-secondary">Refund</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada pesanan ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin.dashboard>

@push('scripts')
    <script>
        // Check if ApexCharts is loaded
        if (typeof ApexCharts === 'undefined') {
            // If not loaded, load it dynamically
            var script = document.createElement('script');
            script.src = "{{ URL::asset('assets/js/plugins/apexcharts.min.js') }}";
            script.onload = function() {
                initializeCharts();
            };
            document.head.appendChild(script);
        } else {
            // If already loaded, initialize charts directly
            document.addEventListener('DOMContentLoaded', function() {
                initializeCharts();
            });
        }

        function initializeCharts() {
            // Sales Overview Chart
            @php
                // Get monthly sales data for the current year
                $monthlySalesData = [];
                $prevYearMonthlySalesData = [];

                try {
                    for ($i = 1; $i <= 12; $i++) {
                        $monthlySalesData[] = Pesanan::where('status', 'selesai')->whereYear('created_at', now()->year)->whereMonth('created_at', $i)->sum('total_harga') ?: 0;
                    }

                    // Get monthly sales data for the previous year
                    for ($i = 1; $i <= 12; $i++) {
                        $prevYearMonthlySalesData[] =
                            Pesanan::where('status', 'selesai')
                                ->whereYear('created_at', now()->subYear()->year)
                                ->whereMonth('created_at', $i)
                                ->sum('total_harga') ?:
                            0;
                    }
                } catch (\Exception $e) {
                    // Ensure we always have 12 values for each array
                    $monthlySalesData = array_fill(0, 12, 0);
                    $prevYearMonthlySalesData = array_fill(0, 12, 0);
                    \Log::error('Dashboard chart data error: ' . $e->getMessage());
                }
            @endphp

            var salesOptions = {
                series: [{
                    name: 'Penjualan {{ now()->year }}',
                    data: [{{ implode(',', $monthlySalesData) }}]
                }, {
                    name: 'Penjualan {{ now()->subYear()->year }}',
                    data: [{{ implode(',', $prevYearMonthlySalesData) }}]
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: false,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                        }
                    }
                }
            };

            if (document.querySelector("#sales-overview-chart")) {
                var salesChart = new ApexCharts(document.querySelector("#sales-overview-chart"), salesOptions);
                salesChart.render();
            }

            // Order Status Chart
            @php
                // Get order status data with safe defaults
                try {
                    $processingOrders = Pesanan::whereIn('status', ['diproses', 'disetujui', 'dikemas', 'diantarkan'])->count() ?: 0;
                    $completedOrders = Pesanan::where('status', 'selesai')->count() ?: 0;
                    $cancelledOrders = Pesanan::whereIn('status', ['dibatalkan', 'cancelled'])->count() ?: 0;
                    $refundedOrders = Pesanan::where('status', 'refunded')->count() ?: 0;

                    // Ensure at least one value is present for the pie chart
                    if ($processingOrders == 0 && $completedOrders == 0 && $cancelledOrders == 0 && $refundedOrders == 0) {
                        $processingOrders = 1; // Add a dummy value so chart renders
                    }
                } catch (\Exception $e) {
                    $processingOrders = 1;
                    $completedOrders = 0;
                    $cancelledOrders = 0;
                    $refundedOrders = 0;
                    \Log::error('Dashboard order status chart error: ' . $e->getMessage());
                }
            @endphp

            var orderStatusOptions = {
                series: [{{ $processingOrders }}, {{ $completedOrders }}, {{ $cancelledOrders }},
                    {{ $refundedOrders }}
                ],
                chart: {
                    width: '100%',
                    height: 300,
                    type: 'pie',
                },
                labels: ['Diproses', 'Selesai', 'Dibatalkan', 'Refund'],
                colors: ['#3498db', '#2ecc71', '#e74c3c', '#95a5a6'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            if (document.querySelector("#order-status-chart")) {
                var orderStatusChart = new ApexCharts(document.querySelector("#order-status-chart"), orderStatusOptions);
                orderStatusChart.render();
            }
        }
    </script>
@endpush
