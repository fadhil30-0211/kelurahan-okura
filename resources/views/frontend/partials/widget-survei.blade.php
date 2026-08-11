{{-- resources/views/frontend/partials/widget-survei.blade.php --}}
<div class="bg-white rounded-2xl shadow-md border border-slate-100 p-6 sm:p-8"
     x-data="{ rating: 0, hover: 0, submitted: {{ session('success') ? 'true' : 'false' }} }">

    @if (session('success'))
        <div class="text-center py-4">
            <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-slate-700">{{ session('success') }}</p>
        </div>
    @else
        <h3 class="font-semibold text-slate-800 mb-1">Bagaimana Pelayanan Kami?</h3>
        <p class="text-xs text-slate-500 mb-4">Penilaian Anda membantu kami meningkatkan kualitas pelayanan kelurahan.</p>

        <form action="{{ route('survei.store') }}" method="POST">
            @csrf

            {{-- Star Rating --}}
            <div class="flex items-center justify-center gap-2 mb-5">
                <template x-for="star in 5" :key="star">
                    <button type="button" @click="rating = star" @mouseenter="hover = star" @mouseleave="hover = 0">
                        <svg class="w-9 h-9 transition-colors"
                             :class="(hover || rating) >= star ? 'text-amber-400' : 'text-slate-200'"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.956a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.363 1.118l1.287 3.955c.3.922-.755 1.688-1.538 1.118l-3.367-2.446a1 1 0 00-1.176 0l-3.367 2.446c-.783.57-1.838-.196-1.539-1.118l1.287-3.955a1 1 0 00-.363-1.118L2.813 9.383c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.956z"/>
                        </svg>
                    </button>
                </template>
            </div>
            <input type="hidden" name="rating" x-model="rating" required>

            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama <span class="text-slate-400">(opsional)</span></label>
                <input type="text" name="nama" placeholder="Boleh dikosongkan untuk anonim"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Layanan yang Dinilai</label>
                <select name="layanan_terkait" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <option value="umum">Pelayanan Umum</option>
                    <option value="surat">Layanan Surat</option>
                    <option value="aduan">Penanganan Pengaduan</option>
                    <option value="wisata">Informasi Wisata</option>
                    <option value="umkm">Direktori UMKM</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Saran <span class="text-slate-400">(opsional)</span></label>
                <textarea name="saran" rows="3" placeholder="Ceritakan pengalaman atau saran Anda..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none"></textarea>
            </div>

            <button type="submit" :disabled="rating === 0"
                    :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                    class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                Kirim Penilaian
            </button>
        </form>
    @endif
</div>
