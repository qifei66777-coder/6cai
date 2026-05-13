{{-- 图片展示模块 --}}
@php
    $sectionTitle = $section?->title ?: '图片展示';
@endphp
<div id="gallery-section" class="mx-3 mt-3">
    <div class="flex items-center justify-between mb-2 px-1">
        <h2 class="text-base font-bold text-gray-800">{{ $sectionTitle }}</h2>
    </div>

    @if($galleryImages->count() > 0)
        <div class="masonry-gallery">
            @foreach($galleryImages as $img)
                @php $imgUrl = Storage::disk('public')->url($img->image_path); @endphp
                <div class="masonry-item" onclick="openLightbox('{{ $imgUrl }}', '{{ addslashes($img->title ?? '') }}')">
                    <img src="{{ $imgUrl }}"
                         alt="{{ $img->title ?? '' }}"
                         class="w-full h-auto block"
                         loading="lazy">
                    @if($img->title)
                        <div class="px-2 py-1 text-xs text-gray-500 bg-white">{{ $img->title }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl py-10 text-center text-gray-400 text-sm shadow-sm">
            暂无图片
        </div>
    @endif
</div>

{{-- Lightbox --}}
<div id="gallery-lightbox" onclick="closeLightbox()"
     style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.92);align-items:center;justify-content:center;flex-direction:column;">
    <button onclick="closeLightbox()" style="position:absolute;top:16px;right:20px;color:#fff;font-size:32px;line-height:1;background:none;border:none;cursor:pointer;">&times;</button>
    <img id="lightbox-img" src="" alt=""
         style="max-width:96vw;max-height:86vh;object-fit:contain;border-radius:8px;">
    <p id="lightbox-caption" style="color:#ccc;font-size:13px;margin-top:10px;text-align:center;padding:0 16px;"></p>
</div>

<style>
.masonry-gallery {
    column-count: 2;
    column-gap: 8px;
}
.masonry-item {
    break-inside: avoid;
    margin-bottom: 8px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    background: #f3f4f6;
    transition: opacity .15s;
}
.masonry-item:active { opacity: 0.8; }
</style>

<script>
function openLightbox(url, caption) {
    const lb = document.getElementById('gallery-lightbox');
    document.getElementById('lightbox-img').src = url;
    document.getElementById('lightbox-caption').textContent = caption || '';
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('gallery-lightbox').style.display = 'none';
    document.getElementById('lightbox-img').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>
