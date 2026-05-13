{{-- 开奖展示模块 --}}
<div id="draw-section" class="mx-3 mt-3">
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        {{-- TAB 切换 --}}
        <div class="flex bg-gray-100 mx-3 mt-3 rounded-xl p-1 gap-1">
            <button id="tab-store"
                onclick="switchTab('store')"
                class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 bg-green-600 text-white shadow-sm">
                澳彩
                @if($storeDrawResult)
                    <div class="text-xs font-normal opacity-90 mt-0.5">
                        {{ $storeDrawResult->draw_date?->format('m月d日') }}开奖
                    </div>
                @endif
            </button>
            <button id="tab-online"
                onclick="switchTab('online')"
                class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500">
                港彩
                @if($onlineDrawResult)
                    <div class="text-xs font-normal opacity-80 mt-0.5">
                        {{ $onlineDrawResult->draw_date?->format('m月d日') }}开奖
                    </div>
                @endif
            </button>
        </div>

        {{-- 店内开奖内容 --}}
        <div id="content-store" class="px-3 pb-4">
            @if($storeDrawResult)
                @include('components.home.draw-card', ['draw' => $storeDrawResult, 'typeKey' => 'store'])
            @else
                <div class="py-10 text-center text-gray-400 text-sm">暂无澳彩开奖数据</div>
            @endif
        </div>

        {{-- 线上开奖内容 --}}
        <div id="content-online" class="px-3 pb-4 hidden">
            @if($onlineDrawResult)
                @include('components.home.draw-card', ['draw' => $onlineDrawResult, 'typeKey' => 'online'])
            @else
                <div class="py-10 text-center text-gray-400 text-sm">暂无港彩开奖数据</div>
            @endif
        </div>
    </div>
</div>

<script>
function switchTab(type) {
    const tabs = { store: document.getElementById('tab-store'), online: document.getElementById('tab-online') };
    const contents = { store: document.getElementById('content-store'), online: document.getElementById('content-online') };

    Object.keys(tabs).forEach(t => {
        if (t === type) {
            tabs[t].classList.add('bg-green-600','text-white','shadow-sm');
            tabs[t].classList.remove('text-gray-500');
            contents[t].classList.remove('hidden');
        } else {
            tabs[t].classList.remove('bg-green-600','text-white','shadow-sm');
            tabs[t].classList.add('text-gray-500');
            contents[t].classList.add('hidden');
        }
    });

    // 切换倒计时
    if (window.activeCountdownInterval) clearInterval(window.activeCountdownInterval);
    if (type === 'store' && window.storeCountdownTarget) {
        startCountdown(window.storeCountdownTarget, 'countdown-store');
    } else if (type === 'online' && window.onlineCountdownTarget) {
        startCountdown(window.onlineCountdownTarget, 'countdown-online');
    }
}

function startCountdown(targetTs, elId) {
    const el = document.getElementById(elId);
    if (!el) return;

    function update() {
        const diff = Math.floor(targetTs - Date.now() / 1000);
        if (diff <= 0) {
            el.innerHTML = '<span class="text-orange-500 font-semibold text-sm">开奖时间已到</span>';
            clearInterval(window.activeCountdownInterval);
            return;
        }
        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        el.innerHTML =
            `<span class="countdown-digit">${String(h).padStart(2,'0')}</span>` +
            `<span class="text-green-700 font-bold mx-1">:</span>` +
            `<span class="countdown-digit">${String(m).padStart(2,'0')}</span>` +
            `<span class="text-green-700 font-bold mx-1">:</span>` +
            `<span class="countdown-digit">${String(s).padStart(2,'0')}</span>`;
    }
    update();
    window.activeCountdownInterval = setInterval(update, 1000);
}

window.addEventListener('DOMContentLoaded', function() {
    @if($storeDrawResult && $storeDrawResult->draw_date && $storeDrawResult->draw_time)
        window.storeCountdownTarget = {{ \Carbon\Carbon::parse($storeDrawResult->draw_date->format('Y-m-d') . ' ' . $storeDrawResult->draw_time)->timestamp }};
        startCountdown(window.storeCountdownTarget, 'countdown-store');
    @endif
    @if($onlineDrawResult && $onlineDrawResult->draw_date && $onlineDrawResult->draw_time)
        window.onlineCountdownTarget = {{ \Carbon\Carbon::parse($onlineDrawResult->draw_date->format('Y-m-d') . ' ' . $onlineDrawResult->draw_time)->timestamp }};
    @endif
});
</script>
