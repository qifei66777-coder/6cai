{{-- 单个开奖卡片内容 --}}
@php
    $isCompleted = $draw->status === 'completed';
    $isDrawing   = $draw->status === 'drawing';
    $isPending   = $draw->status === 'pending';
    $countdownId = 'countdown-' . $typeKey;
    $hasVideo    = !empty($draw->video_file) || !empty($draw->video_url);
    $videoSrc    = !empty($draw->video_file) ? Storage::disk('public')->url($draw->video_file) : $draw->video_url;

    $ballClass = fn($c) => match($c) {
        'red'   => 'ball-red',
        'blue'  => 'ball-blue',
        'green' => 'ball-green',
        default => 'ball-gray',
    };
@endphp

<style>
/* ══════════════════════════════════
   号码球 — 高光玻璃质感
   ══════════════════════════════════ */
.rb {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 16px; color: #fff;
    letter-spacing: -.5px;
    position: relative; flex-shrink: 0;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,.28), 0 1px 3px rgba(0,0,0,.15);
    transition: transform .12s;
}
.rb:active { transform: scale(.9); }
.rb span { position: relative; z-index: 2; text-shadow: 0 1px 3px rgba(0,0,0,.35); }

/* 上半部大面积高光 —— 玻璃感核心 */
.rb::before {
    content: '';
    position: absolute;
    top: -8%; left: -8%;
    width: 80%; height: 62%;
    background: radial-gradient(ellipse at 45% 45%,
        rgba(255,255,255,.92) 0%,
        rgba(255,255,255,.55) 35%,
        rgba(255,255,255,.0)  100%);
    border-radius: 50%;
    transform: rotate(-30deg);
    z-index: 1;
    pointer-events: none;
}
/* 底部暗面 */
.rb::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0; height: 38%;
    background: linear-gradient(to top, rgba(0,0,0,.22), transparent);
    z-index: 1;
    pointer-events: none;
}

/* ── 统一光照公式：145deg，亮→主→暗 ── */
.ball-blue {
    background: linear-gradient(145deg, #7dd4ff 0%, #1a9bf5 45%, #0b60c8 100%);
    box-shadow: 0 4px 12px rgba(26,155,245,.5), 0 1px 3px rgba(0,0,0,.15);
}
.ball-red {
    background: linear-gradient(145deg, #ff7878 0%, #ff1010 45%, #b80000 100%);
    box-shadow: 0 4px 12px rgba(255,16,16,.48), 0 1px 3px rgba(0,0,0,.15);
}
.ball-green {
    background: linear-gradient(145deg, #5ee888 0%, #16c244 45%, #097a28 100%);
    box-shadow: 0 4px 12px rgba(22,194,68,.48), 0 1px 3px rgba(0,0,0,.15);
}
.ball-gray {
    background: linear-gradient(145deg, #cdd4da 0%, #8e98a2 45%, #4a5460 100%);
    box-shadow: 0 4px 10px rgba(74,84,96,.38), 0 1px 3px rgba(0,0,0,.15);
}
/* ── 特别球：同款红，稍大 ── */
.ball-special {
    width: 46px; height: 46px; font-size: 17px;
    background: linear-gradient(145deg, #ff7878 0%, #ff1010 45%, #b80000 100%);
    box-shadow: 0 4px 14px rgba(255,16,16,.58), 0 1px 4px rgba(0,0,0,.2);
}
/* ── 待开奖 ── */
.ball-pending {
    background: radial-gradient(circle at 60% 65%,
        #8a9299 0%, #b0bec5 60%, #dde3e8 100%);
    animation: rb-idle 2s ease-in-out infinite;
}
@keyframes rb-idle {
    0%,100%{ opacity:1; transform:scale(1); }
    50%{ opacity:.5; transform:scale(.93); }
}
/* ── 开奖中 ── */
.ball-drawing {
    background: radial-gradient(circle at 60% 65%,
        #e65c00 0%, #ffa726 60%, #ffe082 100%);
    animation: rb-glow 1.2s ease-in-out infinite;
}
@keyframes rb-glow {
    0%,100%{ box-shadow:0 4px 10px rgba(230,92,0,.4); }
    50%{ box-shadow:0 4px 22px rgba(255,167,38,.75); }
}

/* ── 行容器 ── */
.balls-row {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    gap: 5px;
    flex-wrap: nowrap;
}
.ball-col { display: flex; flex-direction: column; align-items: center; gap: 4px; }
.ball-plus {
    font-size: 18px; font-weight: 900; color: #9ca3af;
    flex-shrink: 0; line-height: 1;
    margin-bottom: 18px; /* 与球底对齐 */
}
.ball-label {
    font-size: 10px; color: #9ca3af;
    text-align: center; line-height: 1.2;
    white-space: nowrap;
}
.ball-label-special { color: #f87171; font-weight: 600; }
</style>

{{-- 日期 + 倒计时 --}}
<div class="flex items-center justify-between mt-3 mb-2 px-1">
    <div class="flex items-center gap-1.5 text-xs text-gray-500">
        <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span>{{ $draw->draw_date?->format('Y年m月d日') }} {{ $draw->getWeekdayLabel() }}</span>
    </div>

    @if(!$isCompleted)
        <div class="bg-green-50 rounded-lg px-2.5 py-1 text-right">
            <div class="text-[10px] text-gray-400 mb-0.5">距开奖</div>
            <div id="{{ $countdownId }}" class="flex items-baseline gap-0.5">
                <span class="text-gray-400 text-xs">计算中...</span>
            </div>
            <div class="flex justify-end gap-2.5 text-[10px] text-gray-400 mt-0.5">
                <span>时</span><span>分</span><span>秒</span>
            </div>
        </div>
    @else
        <div class="flex items-center gap-1 bg-green-50 rounded-full px-3 py-1">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
            <span class="text-xs text-green-600 font-medium">已开奖</span>
        </div>
    @endif
</div>

{{-- 期数 + 状态 --}}
<div class="flex items-center justify-between mb-3 px-1">
    <div class="flex items-center gap-2">
        <span class="font-bold text-gray-800 text-sm">第 <span class="text-base">{{ $draw->issue_number }}</span> 期</span>
        @if($isDrawing)
            <span class="inline-flex items-center gap-1 text-xs text-red-500 font-semibold animate-pulse">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                正在开奖
            </span>
        @endif
    </div>
    @if($draw->history_url)
        <a href="{{ $draw->history_url }}" class="text-xs text-green-600 flex items-center gap-0.5">
            历史记录
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    @endif
</div>

{{-- ── 号码球区 ── --}}
<div class="rounded-2xl px-2 py-4 mb-3 mx-1"
     style="background:linear-gradient(160deg,#f8f9fa 0%,#eef0f2 100%);box-shadow:inset 0 2px 6px rgba(0,0,0,.07),inset 0 -1px 3px rgba(255,255,255,.8);">

    @if($isCompleted || ($isDrawing && $draw->drawNumbers->count() > 0))
        <div class="balls-row">
            @foreach($draw->drawNumbers as $num)
                <div class="ball-col">
                    <div class="rb {{ $ballClass($num->color) }}">
                        <span>{{ str_pad($num->number, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    @if($num->label)
                        <div class="ball-label">{{ $num->label }}</div>
                    @endif
                </div>
            @endforeach

            @if($draw->special_number)
                <div class="ball-plus">+</div>
                <div class="ball-col">
                    <div class="rb ball-special">
                        <span>{{ str_pad($draw->special_number, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="ball-label ball-label-special">
                        {{ $draw->special_label ?: '特别' }}
                    </div>
                </div>
            @endif
        </div>

    @elseif($isDrawing)
        <div class="balls-row">
            @for($i = 0; $i < 6; $i++)
                <div class="ball-col">
                    <div class="rb ball-drawing"><span>?</span></div>
                </div>
            @endfor
            <div class="ball-plus">+</div>
            <div class="ball-col">
                <div class="rb ball-drawing" style="width:46px;height:46px;font-size:17px;"><span>?</span></div>
                <div class="ball-label ball-label-special">特别</div>
            </div>
        </div>

    @else
        <div class="balls-row">
            @for($i = 0; $i < 6; $i++)
                <div class="ball-col">
                    <div class="rb ball-pending" style="animation-delay:{{ $i * 0.18 }}s"><span>?</span></div>
                </div>
            @endfor
            <div class="ball-plus" style="opacity:.35">+</div>
            <div class="ball-col">
                <div class="rb ball-pending" style="width:46px;height:46px;font-size:17px;animation-delay:1.1s"><span>?</span></div>
                <div class="ball-label" style="opacity:.5">特别</div>
            </div>
        </div>
        <div class="text-center text-xs text-gray-400 mt-3">开奖结果将在开奖后更新</div>
    @endif
</div>

{{-- 视频按钮 --}}
@if($hasVideo && ($isCompleted || $isDrawing))
    <button onclick="openVideoModal('{{ $videoSrc }}')"
        class="w-full flex items-center justify-center gap-2 rounded-xl py-2.5 mb-3 text-sm font-medium active:opacity-80"
        style="background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;box-shadow:0 3px 10px rgba(22,163,74,.35);">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
        查看开奖视频
    </button>
@endif

{{-- 底部信息栏 --}}
<div class="flex items-center justify-between pt-2 border-t border-gray-100 text-[11px] text-gray-400 px-1">
    <span>第 {{ $draw->issue_number }} 期</span>
    <span>{{ $draw->draw_date?->format('Y/m/d') }} {{ substr($draw->draw_time ?? '', 0, 5) }}</span>
    <span>{{ $draw->getTypeLabel() }}</span>
</div>
