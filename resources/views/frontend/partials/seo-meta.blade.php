{{-- resources/views/frontend/partials/seo-meta.blade.php --}}
<title>{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}</title>
<meta name="description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura — layanan publik, wisata, dan UMKM warga.' }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}">
<meta property="og:description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura.' }}">
<meta property="og:image" content="{{ $seoImage ?? asset('images/hero-okura.jpg') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="Kelurahan Tebing Tinggi Okura">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}">
<meta name="twitter:description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura.' }}">
<meta name="twitter:image" content="{{ $seoImage ?? asset('images/hero-okura.jpg') }}">
