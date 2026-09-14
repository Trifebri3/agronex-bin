@extends('layouts.mobile')

@section('title', 'Scan Tanaman - denrawit x agronex')

@section('content')
<div class="px-4 py-6 flex flex-col h-full min-h-[calc(100vh-140px)]">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Diagnosa <span class="text-emerald-500">Penyakit</span> 🔍</h2>
        <p class="text-slate-500 mt-1">Foto daun tanaman Anda untuk mengetahui penyakitnya.</p>
    </div>

    <!-- Camera / Upload Area -->
    <div class="flex-1 flex flex-col items-center justify-center">
        <div class="relative w-full max-w-sm aspect-square bg-slate-100 rounded-3xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center p-6 text-center overflow-hidden" id="upload-area">
            
            <div id="upload-placeholder">
                <div class="w-20 h-20 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-slate-800 text-lg">Ambil Foto</h3>
                <p class="text-slate-500 text-sm mt-2">Pastikan daun terlihat jelas dan terang</p>
            </div>

            <img id="preview-image" class="hidden absolute inset-0 w-full h-full object-cover" />
            
            <input type="file" id="image-input" accept="image/*" capture="environment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
        </div>

        <button id="analyze-btn" class="hidden mt-8 w-full max-w-sm bg-gradient-to-r from-emerald-500 to-blue-500 text-white font-semibold py-4 rounded-2xl shadow-lg shadow-emerald-500/30 hover:scale-[1.02] active:scale-[0.98] transition-transform">
            Analisis Sekarang
        </button>
    </div>

    <!-- Result Modal (Hidden by default) -->
    <div id="result-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[60] hidden items-end justify-center sm:items-center">
        <div class="bg-white w-full max-w-md sm:rounded-2xl rounded-t-3xl p-6 transform transition-transform translate-y-full" id="result-content">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden"></div>
            
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4" id="result-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800" id="result-title">Bercak Daun</h3>
                <p class="text-emerald-600 font-medium mt-1 text-sm">Tingkat Keyakinan: <span id="result-confidence">85%</span></p>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 mb-6">
                <h4 class="font-semibold text-slate-700 text-sm mb-2">Rekomendasi Tindakan:</h4>
                <p class="text-slate-600 text-sm leading-relaxed" id="result-recommendation">Gunakan fungisida berbahan aktif mankozeb, dan kurangi kelembapan di sekitar tanaman.</p>
            </div>

            <button id="close-modal" class="w-full bg-slate-100 text-slate-700 font-semibold py-3 rounded-xl hover:bg-slate-200 transition-colors">Tutup</button>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const imageInput = document.getElementById('image-input');
    const previewImage = document.getElementById('preview-image');
    const placeholder = document.getElementById('upload-placeholder');
    const analyzeBtn = document.getElementById('analyze-btn');
    const resultModal = document.getElementById('result-modal');
    const resultContent = document.getElementById('result-content');
    const closeModal = document.getElementById('close-modal');

    imageInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                placeholder.classList.add('hidden');
                analyzeBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    analyzeBtn.addEventListener('click', function() {
        if (!imageInput.files[0]) {
            alert('Silakan ambil foto terlebih dahulu!');
            return;
        }

        const originalText = this.innerText;
        this.innerText = 'Menganalisis...';
        this.disabled = true;
        this.classList.add('opacity-75', 'cursor-not-allowed');

        const formData = new FormData();
        formData.append('image', imageInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('diagnosis.analyze') }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('result-title').innerText = data.disease;
            document.getElementById('result-confidence').innerText = data.confidence + '%';
            document.getElementById('result-recommendation').innerText = data.recommendation;

            // Show result modal
            resultModal.classList.remove('hidden');
            resultModal.classList.add('flex');
            
            // Slight delay for animation
            setTimeout(() => {
                resultContent.classList.remove('translate-y-full');
            }, 10);
        })
        .catch(error => {
            alert('Terjadi kesalahan saat memproses gambar: ' + error);
        })
        .finally(() => {
            this.innerText = originalText;
            this.disabled = false;
            this.classList.remove('opacity-75', 'cursor-not-allowed');
        });
    });

    closeModal.addEventListener('click', function() {
        resultContent.classList.add('translate-y-full');
        setTimeout(() => {
            resultModal.classList.add('hidden');
            resultModal.classList.remove('flex');
            
            // Reset state
            previewImage.classList.add('hidden');
            previewImage.src = '';
            placeholder.classList.remove('hidden');
            analyzeBtn.classList.add('hidden');
            imageInput.value = '';
        }, 300);
    });
</script>
@endpush
@endsection
