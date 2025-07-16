<x-layouts.frontend.master :pageName="$pageName">
    <style>
        /* Custom styling for quantity input */
        .quantity {
            display: flex;
        }

        .quantity .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }

        .quantity .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            width: 35px;
        }

        .quantity .btn-minus {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .quantity .btn-plus {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        /* Hide number input arrows */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Loading overlay styles */
        .loading-overlay {
            font-size: 1.2em;
            color: #007bff;
        }

        .quantity-wrapper {
            position: relative;
        }

        /* Disable pointer events when loading */
        .quantity.loading {
            pointer-events: none;
            opacity: 0.7;
        }
    </style>

    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12">
                    <h1 class="mb-5 display-3 text-primary">Keranjang Belanja</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if ($cartItems->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3>Keranjang Belanja Anda Kosong</h3>
                    <p>Silakan tambahkan beberapa buku ke keranjang Anda.</p>
                    <a href="{{ route('frontend.products') }}" class="btn btn-primary mt-3">Jelajahi Buku</a>
                </div>
            @else
                <div class="table-responsive mb-5">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">Buku</th>
                                <th scope="col" class="border-0">Harga</th>
                                <th scope="col" class="border-0">Jumlah</th>
                                <th scope="col" class="border-0">Subtotal</th>
                                <th scope="col" class="border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->buku->gambar_cover) }}"
                                                style="width: 80px; height: 100px; object-fit: cover;"
                                                class="rounded me-3" alt="{{ $item->buku->judul }}">
                                            <div>
                                                <h6 class="mb-1">{{ $item->buku->judul }}</h6>
                                                <small class="text-muted">{{ $item->buku->penulis }}</small>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="align-middle">
                                        <p class="mb-0">Rp {{ number_format($item->buku->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('customer.cart.update', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="quantity-wrapper">
                                                <div class="input-group quantity" style="width: 120px;">
                                                    <button type="button" class="btn btn-primary btn-minus"
                                                        onclick="decrementQuantity(this)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="jumlah"
                                                        class="form-control bg-light fw-bold fs-6 text-center border-primary quantity-input"
                                                        value="{{ $item->jumlah }}" min="1"
                                                        max="{{ $item->buku->stok }}">
                                                    <button type="button" class="btn btn-primary btn-plus"
                                                        onclick="incrementQuantity(this, {{ $item->buku->stok }})">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted d-block">Stok: {{ $item->buku->stok }}</small>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <p class="mb-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('customer.cart.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete(this.form)">
                                                <i class="fa fa-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end">
                    <div class="col-lg-6">
                        <a href="{{ route('frontend.products') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i> Lanjutkan Belanja
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4">Ringkasan Keranjang</h4>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Total:</h5>
                                <p class="mb-0 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('customer.checkout') }}" class="btn btn-primary w-100 py-3">
                                Lanjutkan ke Checkout <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End --> @push('scripts')
        <script>
            // Variable untuk mencegah multiple submissions
            let isSubmitting = false;

            function incrementQuantity(element, maxStock) {
                if (isSubmitting) return;

                const inputElement = element.closest('.quantity').querySelector('.quantity-input');
                const currentValue = parseInt(inputElement.value);
                if (currentValue < maxStock) {
                    inputElement.value = currentValue + 1;
                    submitFormWithLoading(element);
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stok Terbatas',
                            text: 'Stok buku tidak mencukupi untuk menambah jumlah lagi.',
                            confirmButtonColor: '#28a745'
                        });
                    } else {
                        alert('Stok buku tidak mencukupi untuk menambah jumlah lagi.');
                    }
                }
            }

            function decrementQuantity(element) {
                if (isSubmitting) return;

                const inputElement = element.closest('.quantity').querySelector('.quantity-input');
                const currentValue = parseInt(inputElement.value);
                if (currentValue > 1) {
                    inputElement.value = currentValue - 1;
                    submitFormWithLoading(element);
                }
            }

            function submitFormWithLoading(element) {
                if (isSubmitting) return;

                isSubmitting = true;
                const form = element.closest('form');
                const quantityWrapper = form.querySelector('.quantity-wrapper');
                const buttons = form.querySelectorAll('button');

                // Disable buttons to prevent multiple clicks
                buttons.forEach(btn => btn.disabled = true);

                // Show loading spinner overlay
                const loadingOverlay = document.createElement('div');
                loadingOverlay.className = 'loading-overlay position-absolute d-flex align-items-center justify-content-center';
                loadingOverlay.style.cssText = `
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(255, 255, 255, 0.9);
                    border-radius: 4px;
                    z-index: 1000;
                `;
                loadingOverlay.innerHTML = '<i class="fa fa-spinner fa-spin text-primary"></i>';

                // Set relative position on quantity wrapper
                quantityWrapper.style.position = 'relative';
                quantityWrapper.appendChild(loadingOverlay);

                // Submit form
                setTimeout(() => {
                    form.submit();
                }, 100); // Small delay to show loading animation
            }

            function confirmDelete(form) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Hapus Item?',
                        text: 'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading pada button hapus
                            const deleteBtn = form.querySelector('button[type="button"]');
                            if (deleteBtn) {
                                deleteBtn.disabled = true;
                                deleteBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
                            }
                            form.submit();
                        }
                    });
                } else {
                    // Fallback to native confirm if SweetAlert is not loaded
                    if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                        const deleteBtn = form.querySelector('button[type="button"]');
                        if (deleteBtn) {
                            deleteBtn.disabled = true;
                            deleteBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Menghapus...';
                        }
                        form.submit();
                    }
                }
            }

            // Event listener untuk input manual
            document.querySelectorAll('.quantity-input').forEach(input => {
                let timeout;

                input.addEventListener('input', function() {
                    // Clear timeout sebelumnya
                    clearTimeout(timeout);

                    // Set timeout baru untuk menghindari terlalu banyak request
                    timeout = setTimeout(() => {
                        const maxStock = parseInt(this.getAttribute('max'));
                        const currentValue = parseInt(this.value);

                        if (isNaN(currentValue) || currentValue < 1) {
                            this.value = 1;
                        } else if (currentValue > maxStock) {
                            this.value = maxStock;
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Stok Terbatas',
                                    text: 'Jumlah telah disesuaikan dengan stok yang tersedia.',
                                    confirmButtonColor: '#28a745'
                                });
                            } else {
                                alert(
                                    'Stok terbatas. Jumlah telah disesuaikan dengan stok yang tersedia.');
                            }
                        }

                        // Submit form setelah delay
                        submitFormWithLoading(this);
                    }, 1000); // 1 detik delay
                });
            });

            // Reset isSubmitting ketika halaman dimuat ulang
            window.addEventListener('pageshow', function() {
                isSubmitting = false;
            });
        </script>
    @endpush
</x-layouts.frontend.master>
