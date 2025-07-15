@props(['breadcrumbs' => [], 'currentPage' => null])
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Hi👋🏻 &mdash; Selamat Datang {{ Auth::user()->name }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @foreach ($breadcrumbs as $item)
                        <li class="breadcrumb-item"><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
                    @endforeach
                    <li class="breadcrumb-item" aria-current="page">{{ $currentPage }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
