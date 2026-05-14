{{-- 图片展示模块 --}}
@php
    $sectionTitle    = $section?->title    ?: '图片展示';
    $sectionSubtitle = $section?->subtitle ?: '精彩图片一览';
@endphp
<div id="gallery-section" class="px-3 pt-4">

    {{-- 板块标题 --}}
    <div class="section-header mb-3">
        <div class="section-title-bar">
            <div class="section-accent"></div>
            <div>
                <div class="section-title-text">{{ $sectionTitle }}</div>
                <div class="section-subtitle-text">{{ $sectionSubtitle }}</div>
            </div>
        </div>
    </div>

    @if($galleryImages->count() > 0)
        <div class="gallery-masonry">
            @foreach($galleryImages as $img)
                @php $imgUrl = Storage::disk('public')->url($img->image_path); @endphp
                <div class="gallery-item"
                     onclick="openGalleryLightbox('{{ addslashes($imgUrl) }}', '{{ addslashes($img->title ?? '') }}')">
                    <div class="gallery-item-inner">
                        <img src="{{ $imgUrl }}"
                             alt="{{ $img->title ?? '' }}"
                             class="w-full h-auto block"
                             loading="lazy">
                        @if($img->title)
                            <div class="gallery-item-caption">{{ $img->title }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl py-10 flex flex-col items-center gap-2 text-gray-400"
             style="box-shadow:0 1px 8px rgba(0,0,0,.06);">
            <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm">暂无图片</span>
        </div>
    @endif
</div>

{{-- Lightbox 全屏预览 --}}
<div id="gallery-lightbox"
     onclick="closeGalleryLightbox(event)"
     style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.94);
            align-items:center;justify-content:center;flex-direction:column;touch-action:none;">
    <button onclick="closeGalleryLightboxBtn()"
            style="position:absolute;top:16px;right:16px;color:#fff;font-size:28px;
                   line-height:1;background:rgba(255,255,255,.15);border:none;cursor:pointer;
                   width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
        &times;
    </button>
    <img id="gallery-lb-img" src="" alt=""
         style="max-width:94vw;max-height:80vh;object-fit:contain;border-radius:10px;
                box-shadow:0 20px 60px rgba(0,0,0,.6);">
    <p id="gallery-lb-caption"
       style="color:rgba(255,255,255,.6);font-size:12px;margin-top:12px;
              text-align:center;padding:0 20px;max-width:90vw;"></p>
</div>

<style>
/* 单列布局 */
.gallery-masonry {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.gallery-item {
    cursor: pointer;
}
.gallery-item-inner {
    border-radius: 10px;
    overflow: hidden;
    background: #e5e7eb;
    transition: opacity .15s, transform .15s;
    position: relative;
}
.gallery-item-inner:active {
    opacity: .85;
    transform: scale(.98);
}
.gallery-item-caption {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 4px 6px;
    font-size: 10px;
    color: #fff;
    background: linear-gradient(to top, rgba(0,0,0,.55), transparent);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
</style>

<script>
function openGalleryLightbox(url, caption) {
    var lb = document.getElementById('gallery-lightbox');
    document.getElementById('gallery-lb-img').src       = url;
    document.getElementById('gallery-lb-caption').textContent = caption || '';
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeGalleryLightboxBtn() {
    var lb = document.getElementById('gallery-lightbox');
    lb.style.display = 'none';
    document.getElementById('gallery-lb-img').src = '';
    document.body.style.overflow = '';
}
function closeGalleryLightbox(e) {
    if (e.target === document.getElementById('gallery-lightbox')) {
        closeGalleryLightboxBtn();
    }
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeGalleryLightboxBtn();
});
</script>
