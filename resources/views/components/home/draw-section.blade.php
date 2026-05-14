{{-- 开奖结果模块 ── 红橙金主题 --}}
@php
    $storeLabel  = \App\Models\DrawSchedule::where('type','store')->value('type_label')  ?? '澳彩';
    $onlineLabel = \App\Models\DrawSchedule::where('type','online')->value('type_label') ?? '港彩';
@endphp
<div id="draw-section" class="px-3 pt-4">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
        <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:32px;height:32px;border-radius:10px;flex-shrink:0;
                        background:linear-gradient(135deg,#fbbf24,#ea580c,#dc2626);
                        display:flex;align-items:center;justify-content:center;
                        box-shadow:0 3px 12px rgba(220,38,38,.55);
                        animation:pulse-hot 2s ease infinite;">
                <span style="font-size:16px;line-height:1;">🎯</span>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;
                             background:linear-gradient(90deg,#fbbf24,#f97316);
                             -webkit-background-clip:text;-webkit-text-fill-color:transparent;line-height:1.2;">
                    今日开奖结果
                </div>
                <div style="font-size:10px;color:rgba(251,191,36,.55);margin-top:1px;">实时更新 · 准确可信</div>
            </div>
        </div>
        <div style="display:inline-flex;align-items:center;gap:4px;
                    background:rgba(220,38,38,.15);border:1px solid rgba(220,38,38,.4);
                    border-radius:20px;padding:4px 10px;">
            <span style="width:6px;height:6px;border-radius:50%;background:#ef4444;display:inline-block;animation:pulse-hot 1.5s ease infinite;"></span>
            <span style="font-size:11px;font-weight:800;color:#ef4444;letter-spacing:1px;">LIVE</span>
        </div>
    </div>

    <div style="border-radius:20px;overflow:hidden;border:1px solid rgba(220,38,38,.22);
                animation:draw-outer-glow 3s ease-in-out infinite;background:#2a2123;">

        <div style="display:flex;padding:10px 10px 0;gap:8px;
                    background:linear-gradient(180deg,#372a2c,#2a2123);">
            <button id="tab-store" onclick="dswitchTab('store')"
                    style="flex:1;padding:10px 0;border-radius:12px;border:none;cursor:pointer;
                           font-size:13px;font-weight:800;transition:all .2s;
                           background:linear-gradient(135deg,#fbbf24,#ea580c,#dc2626);
                           color:#fff;box-shadow:0 3px 12px rgba(220,38,38,.55);">
                <span style="display:block;line-height:1.2;">🇸🇬 {{ $storeLabel }}</span>
                @if($storeDrawResult)
                    <span style="display:block;font-size:9px;font-weight:400;opacity:.85;margin-top:2px;">
                        {{ $storeDrawResult->draw_date?->format('m月d日') }}
                    </span>
                @endif
            </button>
            <button id="tab-online" onclick="dswitchTab('online')"
                    style="flex:1;padding:10px 0;border-radius:12px;border:none;cursor:pointer;
                           font-size:13px;font-weight:800;transition:all .2s;
                           background:rgba(255,255,255,.06);color:rgba(255,255,255,.45);">
                <span style="display:block;line-height:1.2;">🇲🇾 {{ $onlineLabel }}</span>
                @if($onlineDrawResult)
                    <span style="display:block;font-size:9px;font-weight:400;opacity:.7;margin-top:2px;">
                        {{ $onlineDrawResult->draw_date?->format('m月d日') }}
                    </span>
                @endif
            </button>
        </div>

        <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(220,38,38,.4),transparent);margin:8px 10px 0;"></div>

        <div id="content-store" class="pb-2">
            @if($storeDrawResult)
                @include('components.home.draw-card',['draw'=>$storeDrawResult,'typeKey'=>'store'])
            @else
                <div style="padding:48px 0;display:flex;flex-direction:column;align-items:center;gap:8px;color:rgba(255,255,255,.3);">
                    <svg style="width:36px;height:36px;opacity:.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size:12px;">暂无{{ $storeLabel }}开奖数据</span>
                </div>
            @endif
        </div>
        <div id="content-online" class="pb-2 hidden">
            @if($onlineDrawResult)
                @include('components.home.draw-card',['draw'=>$onlineDrawResult,'typeKey'=>'online'])
            @else
                <div style="padding:48px 0;display:flex;flex-direction:column;align-items:center;gap:8px;color:rgba(255,255,255,.3);">
                    <svg style="width:36px;height:36px;opacity:.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size:12px;">暂无{{ $onlineLabel }}开奖数据</span>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function dswitchTab(type){
    var tabs={store:document.getElementById('tab-store'),online:document.getElementById('tab-online')};
    var contents={store:document.getElementById('content-store'),online:document.getElementById('content-online')};
    Object.keys(tabs).forEach(function(t){
        if(t===type){
            tabs[t].style.background='linear-gradient(135deg,#fbbf24,#ea580c,#dc2626)';
            tabs[t].style.color='#fff';tabs[t].style.boxShadow='0 3px 12px rgba(220,38,38,.55)';
            contents[t].classList.remove('hidden');
        }else{
            tabs[t].style.background='rgba(255,255,255,.06)';
            tabs[t].style.color='rgba(255,255,255,.45)';tabs[t].style.boxShadow='none';
            contents[t].classList.add('hidden');
        }
    });
    if(window.activeCountdownInterval)clearInterval(window.activeCountdownInterval);
    if(type==='store'  &&window.storeCountdownTarget) startCountdown(window.storeCountdownTarget,'countdown-store');
    if(type==='online'&&window.onlineCountdownTarget) startCountdown(window.onlineCountdownTarget,'countdown-online');
}
function startCountdown(targetTs,elId){
    var el=document.getElementById(elId);if(!el)return;
    function update(){
        var diff=Math.floor(targetTs-Date.now()/1000);
        if(diff<=0){el.innerHTML='<span style="color:#fbbf24;font-weight:800;font-size:13px;">开奖时间已到</span>';clearInterval(window.activeCountdownInterval);return;}
        var h=Math.floor(diff/3600),m=Math.floor((diff%3600)/60),s=diff%60;
        el.innerHTML='<span class="countdown-digit">'+String(h).padStart(2,'0')+'</span>'+
            '<span style="color:rgba(251,191,36,.5);font-weight:700;margin:0 3px;font-size:18px;">:</span>'+
            '<span class="countdown-digit">'+String(m).padStart(2,'0')+'</span>'+
            '<span style="color:rgba(251,191,36,.5);font-weight:700;margin:0 3px;font-size:18px;">:</span>'+
            '<span class="countdown-digit">'+String(s).padStart(2,'0')+'</span>';
    }
    update();window.activeCountdownInterval=setInterval(update,1000);
}
window.addEventListener('DOMContentLoaded',function(){
    @if($storeDrawResult && $storeDrawResult->draw_date && $storeDrawResult->draw_time)
        window.storeCountdownTarget={{{\Carbon\Carbon::parse($storeDrawResult->draw_date->format('Y-m-d').' '.$storeDrawResult->draw_time)->timestamp}}};
        startCountdown(window.storeCountdownTarget,'countdown-store');
    @endif
    @if($onlineDrawResult && $onlineDrawResult->draw_date && $onlineDrawResult->draw_time)
        window.onlineCountdownTarget={{{\Carbon\Carbon::parse($onlineDrawResult->draw_date->format('Y-m-d').' '.$onlineDrawResult->draw_time)->timestamp}}};
    @endif
});
</script>
