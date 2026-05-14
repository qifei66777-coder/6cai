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
                             loading="lazy">
                        @if($img->title)
                            <div class="gallery-item-caption">
                                <span class="gallery-item-caption-text">{{ $img->title }}</span>
                                <svg class="gallery-item-caption-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-4.35-4.35M11 17a6 6 0 100-12 6 6 0 000 12z"/>
                                </svg>
                            </div>
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
/* 单列卡片布局 */
.gallery-masonry {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.gallery-item {
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}
.gallery-item-inner {
    border-radius: 14px;
    overflow: hidden;
    background: linear-gradient(180deg,#1a0500,#0d0000);
    border: 1px solid rgba(220,38,38,.22);
    box-shadow: 0 3px 14px rgba(0,0,0,.5);
    transition: opacity .15s, transform .15s;
}
.gallery-item-inner:active {
    opacity: .9;
    transform: scale(.99);
}
.gallery-item-inner img {
    display: block;
    width: 100%;
    height: auto;
}

/* 标题区 - 卡片下方独立带左金色竖线 */
.gallery-item-caption {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 11px 13px;
    border-top: 1px solid rgba(220,38,38,.12);
    background: linear-gradient(180deg,rgba(220,38,38,.04),rgba(220,38,38,.10));
}
.gallery-item-caption::before {
    content: '';
    flex-shrink: 0;
    width: 3px;
    height: clamp(14px, 4vw, 18px);
    background: linear-gradient(180deg,#fbbf24,#ea580c,#dc2626);
    border-radius: 3px;
    box-shadow: 0 0 6px rgba(251,191,36,.4);
}
.gallery-item-caption-text {
    flex: 1;
    min-width: 0;
    font-size: clamp(13px, 3.6vw, 15px);
    font-weight: 700;
    color: rgba(255,255,255,.92);
    line-height: 1.4;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    letter-spacing: .3px;
}
.gallery-item-caption-icon {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    color: rgba(251,191,36,.55);
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
