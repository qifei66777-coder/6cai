@if($marqueeText)
<div style="overflow:hidden;display:flex;align-items:center;height:30px;
            background:linear-gradient(90deg,#7f1d1d 0%,#dc2626 40%,#ea580c 100%);">
    <div style="flex-shrink:0;display:flex;align-items:center;justify-content:center;
                height:100%;padding:0 12px;background:rgba(0,0,0,.25);">
        <span style="color:#fbbf24;font-size:10px;font-weight:900;letter-spacing:1px;">📢 公告</span>
    </div>
    <div style="flex-shrink:0;width:1px;height:14px;background:rgba(255,255,255,.25);"></div>
    <div style="flex:1;overflow:hidden;position:relative;height:30px;">
        <div class="marquee-inner"
             style="position:absolute;inset-y:0;display:flex;align-items:center;
                    white-space:nowrap;color:#fff;font-size:11px;font-weight:500;">
            {{ $marqueeText }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $marqueeText }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
</div>
<style>
.marquee-inner{animation:marquee-scroll 20s linear infinite;will-change:transform;}
@keyframes marquee-scroll{0%{transform:translateX(100%);}100%{transform:translateX(-100%);}}
</style>
@endif
