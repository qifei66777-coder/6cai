{{-- 网站宣传动态条 $variant = 2|3 --}}
@php $v = (int)($variant ?? 2); @endphp

@once
<style>
@keyframes pb-gradshift{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
@keyframes pb-shimmer{0%{left:-100%;}100%{left:160%;}}
@keyframes pb-float{0%,100%{transform:translateY(0) rotate(0deg);}33%{transform:translateY(-8px) rotate(5deg);}66%{transform:translateY(4px) rotate(-4deg);}}
@keyframes pb-glow-gold{0%,100%{text-shadow:0 0 8px rgba(251,191,36,.7),0 1px 2px rgba(0,0,0,.5);}50%{text-shadow:0 0 22px rgba(251,191,36,1),0 0 40px rgba(234,88,12,.5);}}
@keyframes pb-badge-in{from{opacity:0;transform:scale(.7) translateY(6px);}to{opacity:1;transform:scale(1) translateY(0);}}
@keyframes pb-border-red{0%,100%{border-color:rgba(220,38,38,.3);}50%{border-color:rgba(251,191,36,.6);}}
</style>
@endonce

@if($v === 2)
{{-- 变体2：橙红渐变 + 光晕 + 三优势 --}}
<div class="mx-3 my-4 rounded-2xl overflow-hidden relative"
     style="height:100px;
            background:linear-gradient(135deg,#450a0a 0%,#7f1d1d 30%,#9a3412 65%,#7c2d12 100%);
            background-size:200% 200%;animation:pb-gradshift 5s ease infinite;
            border:1px solid rgba(251,191,36,.2);">
    <div style="position:absolute;top:0;bottom:0;width:70px;pointer-events:none;
                background:linear-gradient(90deg,transparent,rgba(255,255,255,.1),transparent);
                animation:pb-shimmer 3.5s ease-in-out infinite;"></div>
    <div style="position:absolute;left:14px;top:0;bottom:0;
                display:flex;flex-direction:column;justify-content:center;width:44%;">
        <div style="font-size:16px;font-weight:900;color:#fff;line-height:1.3;">
            专业彩票资讯<br>平台
        </div>
        <div style="font-size:10px;color:rgba(251,191,36,.6);margin-top:5px;font-weight:600;">mlxylhc.com</div>
    </div>
    <div style="position:absolute;right:12px;top:0;bottom:0;display:flex;flex-direction:column;justify-content:center;gap:6px;">
        @php $badges=[['icon'=>'🔒','t'=>'安全可信'],['icon'=>'⚡','t'=>'实时更新'],['icon'=>'🏆','t'=>'权威数据']]; @endphp
        @foreach($badges as $b)
        <div style="display:flex;align-items:center;gap:5px;background:rgba(0,0,0,.25);border:1px solid rgba(251,191,36,.2);
                    border-radius:20px;padding:3px 10px;
                    animation:pb-badge-in .4s ease both;animation-delay:{{ $loop->index * 0.12 }}s;">
            <span style="font-size:11px;">{{ $b['icon'] }}</span>
            <span style="font-size:10px;font-weight:700;color:#fbbf24;">{{ $b['t'] }}</span>
        </div>
        @endforeach
    </div>
</div>

@elseif($v === 3)
{{-- 变体3：黑红底 + 域名金字发光 --}}
<div class="mx-3 my-4 rounded-2xl overflow-hidden relative"
     style="height:90px;background:linear-gradient(135deg,#0d0000,#1a0500,#0d0000);
            border:1px solid rgba(251,191,36,.25);animation:pb-border-red 3s ease-in-out infinite;">
    <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,#fbbf24,#ea580c,#fbbf24,transparent);"></div>
    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;">
        <div style="font-size:9px;color:rgba(251,191,36,.55);letter-spacing:4px;font-weight:600;">✦ 官方彩票资讯平台 ✦</div>
        <div style="font-size:24px;font-weight:900;color:#fbbf24;letter-spacing:2px;animation:pb-glow-gold 2s ease-in-out infinite;">
            MLXYLHC.COM
        </div>
        <div style="font-size:9px;color:rgba(234,88,12,.7);letter-spacing:2px;">安全 · 权威 · 准确 · 实时</div>
    </div>
    <div style="position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,#fbbf24,#ea580c,#fbbf24,transparent);"></div>
</div>
@endif
