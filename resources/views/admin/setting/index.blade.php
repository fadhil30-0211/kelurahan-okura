@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="custom-setting-wrapper">

    <!-- Header Section -->
    <div class="header-section">
        <div>
            <h2 class="header-title">Pengaturan Website</h2>
            <p class="header-subtitle">Kelola identitas instansi, logo, kontak WhatsApp, data kependudukan, dan lokasi peta.</p>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="custom-alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif

    <!-- Form Utama -->
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="setting-card">

            <!-- Navigation Tabs (JS Custom) -->
            <div class="tab-header">
                <button type="button" class="tab-btn active" id="btn-tab-umum" onclick="switchTab(event, 'tab-umum')">
                    Informasi Umum & Logo
                </button>
                <button type="button" class="tab-btn" id="btn-tab-penduduk" onclick="switchTab(event, 'tab-penduduk')">
                    Data Kependudukan
                </button>
                <button type="button" class="tab-btn" id="btn-tab-map" onclick="switchTab(event, 'tab-map')">
                    Peta & Lokasi
                </button>
            </div>

            <div class="card-body-content">

                <!-- TAB 1: INFORMASI UMUM -->
                <div id="tab-umum" class="tab-pane-custom active">
                    <h4 class="section-title">Profil & Identitas Instansi</h4>

                    <div class="form-grid">
                        {{-- Nama Header (Navbar Atas) --}}
                        <div class="form-group col-6">
                            <label>Nama Website / Instansi (Header Top) <span class="required">*</span></label>
                            <input type="text" name="nama_website" class="input-field @error('nama_website') is-invalid @enderror" value="{{ old('nama_website', $setting->nama_website ?? $setting->nama_instansi ?? '') }}" required placeholder="Contoh: Kelurahan Tebing Tinggi Okura">
                            <small class="help-text">Nama yang tampil di bagian menu navigasi atas.</small>
                            @error('nama_website') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        {{-- Nama Footer (Bagian Bawah) --}}
                        <div class="form-group col-6">
                            <label>Nama Website / Instansi (Footer) <span class="required">*</span></label>
                            <input type="text" name="nama_website_footer" class="input-field @error('nama_website_footer') is-invalid @enderror" value="{{ old('nama_website_footer', $setting->nama_website_footer ?? $setting->nama_website ?? '') }}" required placeholder="Contoh: Portal Resmi Kelurahan Tebing Tinggi Okura">
                            <small class="help-text">Nama yang tampil di bagian paling bawah (footer).</small>
                            @error('nama_website_footer') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-6">
                            <label>Email Resmi</label>
                            <input type="email" name="email" class="input-field @error('email') is-invalid @enderror" value="{{ old('email', $setting->email ?? '') }}" placeholder="kontak@desa.id">
                            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        {{-- Input Nomor Telepon Kantor --}}
                        <div class="form-group col-6">
                            <label>Nomor Telepon Kantor (Opsional)</label>
                            <input type="text" name="telepon" class="input-field @error('telepon') is-invalid @enderror" value="{{ old('telepon', $setting->telepon ?? '') }}" placeholder="(0761) XXXXXX">
                            @error('telepon') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        {{-- Input Nomor WhatsApp Layanan --}}
                        <div class="form-group col-6">
                            <label>Nomor WhatsApp Layanan Publik</label>
                            <input type="text" name="whatsapp" class="input-field @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp', $setting->whatsapp ?? '') }}" placeholder="0812XXXXXXX atau 62812XXXXXXX">
                            <small class="help-text">Nomor ini akan digunakan pada tombol Floating WhatsApp di halaman publik.</small>
                            @error('whatsapp') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        {{-- Input Pesan Otomatis WhatsApp --}}
                        <div class="form-group col-6">
                            <label>Pesan Otomatis WhatsApp (Default)</label>
                            <input type="text" name="pesan_wa" class="input-field @error('pesan_wa') is-invalid @enderror" value="{{ old('pesan_wa', $setting->pesan_wa ?? '') }}" placeholder="Halo Admin, saya ingin bertanya tentang layanan kelurahan.">
                            <small class="help-text">Teks default yang otomatis terisi saat warga menekan tombol WA.</small>
                            @error('pesan_wa') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-12">
                            <label>Alamat Kantor / Instansi</label>
                            <input type="text" name="alamat" class="input-field @error('alamat') is-invalid @enderror" value="{{ old('alamat', $setting->alamat ?? '') }}" placeholder="Jl. Raya Utama No. 123">
                            @error('alamat') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-12">
                            <label>Deskripsi Ringkas / Teks Footer</label>
                            <textarea name="deskripsi_footer" rows="3" class="input-field @error('deskripsi_footer') is-invalid @enderror" placeholder="Tulis deskripsi singkat yang akan tampil pada bagian footer.">{{ old('deskripsi_footer', $setting->deskripsi_footer ?? '') }}</textarea>
                            @error('deskripsi_footer') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-12">
                            <label>Logo Resmi Website</label>
                            <div class="logo-preview-box">
                                <div class="img-container">
                                    @if(isset($setting->logo) && $setting->logo)
                                        <img id="logo-preview-img" src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
                                    @else
                                        <img id="logo-preview-img" src="" alt="Logo" style="display: none;">
                                        <div id="no-img-text" class="no-img">No Image</div>
                                    @endif
                                </div>
                                <div class="file-input-wrapper">
                                    <input type="file" name="logo" id="logo-input" class="input-field @error('logo') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                                    <small class="help-text">Format: PNG, JPG, WEBP (Maksimal 2 MB).</small>
                                    @error('logo') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: DATA KEPENDUDUKAN -->
                <div id="tab-penduduk" class="tab-pane-custom">
                    <h4 class="section-title">Statistik Kependudukan</h4>

                    <div class="stat-card">
                        <label for="jumlah_penduduk">Total Jumlah Penduduk</label>
                        <small>Data ini akan ditampilkan di halaman utama</small>
                        <input type="number" name="jumlah_penduduk" id="jumlah_penduduk" class="input-field stat-input @error('jumlah_penduduk') is-invalid @enderror" value="{{ old('jumlah_penduduk', $setting->jumlah_penduduk ?? 0) }}" placeholder="0">
                        @error('jumlah_penduduk') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- TAB 3: PETA & LOKASI -->
                <div id="tab-map" class="tab-pane-custom">
                    <h4 class="section-title">Integrasi Google Maps</h4>

                    <div class="form-grid">
                        <div class="form-group col-12">
                            <label>Embed Code Google Maps (iFrame)</label>
                            <textarea name="link_map" rows="3" class="input-field code-font @error('link_map') is-invalid @enderror" placeholder="<iframe src='https://www.google.com/maps/embed?...'></iframe>">{{ old('link_map', $setting->link_map ?? $setting->google_map ?? '') }}</textarea>
                            @error('link_map') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-6">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="input-field @error('latitude') is-invalid @enderror" value="{{ old('latitude', $setting->latitude ?? '') }}" placeholder="-0.507068">
                            @error('latitude') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group col-6">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="input-field @error('longitude') is-invalid @enderror" value="{{ old('longitude', $setting->longitude ?? '') }}" placeholder="101.447779">
                            @error('longitude') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Card Footer Action -->
            <div class="card-footer-action">
                <span class="info-text">Periksa kembali data sebelum menyimpan perubahan.</span>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>

        </div>
    </form>
</div>

<!-- STYLESHEET MANDIRI -->
<style>
    .custom-setting-wrapper {
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
        font-family: system-ui, -apple-system, sans-serif;
        color: #1e293b;
    }

    .header-section {
        margin-bottom: 24px;
    }

    .header-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 6px 0;
        color: #0f172a;
    }

    .header-subtitle {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .custom-alert {
        background-color: #dcfce7;
        color: #15803d;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .alert-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #15803d;
    }

    .setting-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .tab-header {
        display: flex;
        gap: 8px;
        padding: 16px 20px 0 20px;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .tab-btn {
        padding: 10px 18px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        border-radius: 8px 8px 0 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .tab-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .card-body-content {
        padding: 24px;
    }

    .tab-pane-custom {
        display: none;
    }

    .tab-pane-custom.active {
        display: block;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        color: #2563eb;
        margin: 0 0 20px 0;
        letter-spacing: 0.5px;
    }

    .form-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .col-6 { width: calc(50% - 8px); }
    .col-12 { width: 100%; }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }

    .required { color: #ef4444; }

    .input-field {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s ease;
    }

    .input-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .code-font {
        font-family: monospace;
        font-size: 12px;
    }

    .logo-preview-box {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
    }

    .img-container {
        width: 90px;
        height: 70px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .no-img {
        font-size: 11px;
        color: #94a3b8;
    }

    .file-input-wrapper {
        flex: 1;
    }

    .help-text {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
        display: block;
    }

    .stat-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 10px;
        max-width: 400px;
    }

    .stat-card label {
        font-weight: 700;
        font-size: 15px;
        display: block;
    }

    .stat-card small {
        color: #64748b;
        margin-bottom: 12px;
        display: block;
    }

    .stat-input {
        font-size: 18px;
        font-weight: 700;
        text-align: center;
    }

    .card-footer-action {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-text {
        font-size: 13px;
        color: #64748b;
    }

    .btn-submit {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .error-msg {
        font-size: 12px;
        color: #ef4444;
        margin-top: 4px;
    }

    .is-invalid {
        border-color: #ef4444;
    }

    @media (max-width: 768px) {
        .col-6 { width: 100%; }
        .card-footer-action { flex-direction: column; gap: 12px; }
    }
</style>

<!-- JAVASCRIPT TAB SWITCHER & PREVIEW LOGO -->
<script>
    function switchTab(evt, tabId) {
        let i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tab-pane-custom");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active");
        }

        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }

        document.getElementById(tabId).classList.add("active");
        if(evt) evt.currentTarget.classList.add("active");
    }

    // Live preview gambar saat diupload
    function previewImage(input) {
        const preview = document.getElementById('logo-preview-img');
        const noImgText = document.getElementById('no-img-text');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if(noImgText) noImgText.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Pindah tab otomatis jika terjadi error validasi pada tab 2 atau tab 3
    document.addEventListener("DOMContentLoaded", function() {
        @if ($errors->has('jumlah_penduduk'))
            document.getElementById('btn-tab-penduduk').click();
        @elseif ($errors->has('link_map') || $errors->has('latitude') || $errors->has('longitude'))
            document.getElementById('btn-tab-map').click();
        @endif
    });
</script>
@endsection
