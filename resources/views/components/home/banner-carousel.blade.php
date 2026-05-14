@if($banners->isNotEmpty())
<div class="relative overflow-hidden bg-gray-200" id="banner-wrap"
     style="aspect-ratio:16/6;">
    {{-- 滑动轨道 --}}
    <div id="banner-track"
         class="flex h-full"
         style="transition:transform .45s cubic-bezier(.4,0,.2,1);will-change:transform;">
        @foreach($banners as $banner)
            @if($banner->link_url)
                <a href="{{ $banner->link_url }}" target="_blank" rel="noopener"
                   class="flex-shrink-0 w-full h-full block">
            @else
                <div class="flex-shrink-0 w-full h-full">
            @endif
                <img src="{{ Storage::disk('public')->url($banner->image_path) }}"
                     alt="{{ $banner->title ?? '' }}"
                     class="w-full h-full object-cover block"
                     loading="lazy">
            @if($banner->link_url)
                </a>
            @else
                </div>
            @endif
        @endforeach
    </div>

    {{-- 底部渐变遮罩 + 指示点 --}}
    @if($banners->count() > 1)
    <div class="absolute bottom-0 left-0 right-0 flex justify-center items-end pb-2.5 gap-1.5 z-10"
         style="background:linear-gradient(to top,rgba(0,0,0,.28) 0%,transparent 100%);height:50px;">
        @foreach($banners as $i => $banner)
            <button onclick="bannerGo({{ $i }})"
                    class="banner-dot transition-all rounded-full"
                    style="{{ $i === 0 ? 'width:18px;height:6px;background:#fff;' : 'width:6px;height:6px;background:rgba(255,255,255,.5);' }}"
                    id="dot-{{ $i }}"></button>
        @endforeach
    </div>
    @endif
</div>

<script>
(function(){
    const total = {{ $banners->count() }};
    if (total <= 1) return;
    let cur = 0;
    const track = document.getElementById('banner-track');
    const dots  = document.querySelectorAll('.banner-dot');

    function go(n) {
        cur = (n + total) % total;
        track.style.transform = 'translateX(-' + (cur * 100) + '%)';
        dots.forEach(function(d, i) {
            if (i === cur) {
                d.style.width   = '18px';
                d.style.height  = '6px';
                d.style.background = '#fff';
                d.style.borderRadius = '3px';
            } else {
                d.style.width   = '6px';
                d.style.height  = '6px';
                d.style.background = 'rgba(255,255,255,.5)';
                d.style.borderRadius = '50%';
            }
        });
    }

    window.bannerGo = go;

    // 触摸滑动支持
    var touchStartX = 0;
    var wrap = document.getElementById('banner-wrap');
    wrap.addEventListener('touchstart', function(e){ touchStartX = e.touches[0].clientX; }, {passive:true});
    wrap.addEventListener('touchend', function(e){
        var dx = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 40) { go(dx < 0 ? cur + 1 : cur - 1); }
    }, {passive:true});

    var timer = setInterval(function(){ go(cur + 1); }, 4000);
    wrap.addEventListener('touchstart', function(){ clearInterval(timer); }, {passive:true});
    wrap.addEventListener('touchend',   function(){ timer = setInterval(function(){ go(cur + 1); }, 4000); }, {passive:true});
})();
</script>
@endif
