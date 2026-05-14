{{-- 单个开奖卡片（红橙金主题） --}}
@php
    $isCompleted = $draw->status === 'completed';
    $isDrawing   = $draw->status === 'drawing';
    $isPending   = $draw->status === 'pending';
    $countdownId = 'countdown-' . $typeKey;
    $hasVideo    = !empty($draw->video_file) || !empty($draw->video_url);
    $videoSrc    = !empty($draw->video_file) ? Storage::disk('public')->url($draw->video_file) : $draw->video_url;
    $ballClass   = fn($c) => match($c) {
        'red'   => 'ball-red',
        'blue'  => 'ball-blue',
        'green' => 'ball-green',
        default => 'ball-gray',
    };
    $specialBallClass = $draw->special_number
        ? $ballClass(\App\Helpers\LotteryHelper::getColor((int)$draw->special_number))
        : 'ball-gray';
@endphp

@once
<style>
.rb{width:54px;height:54px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:900;font-size:19px;color:#fff;letter-spacing:-.5px;position:relative;flex-shrink:0;overflow:hidden;transition:transform .12s;}
.rb:active{transform:scale(.9);}
.rb span{position:relative;z-index:2;text-shadow:0 1px 4px rgba(0,0,0,.35);}
.rb::before{content:'';position:absolute;top:7%;left:7%;width:50%;height:42%;background:radial-gradient(ellipse at 38% 38%,rgba(255,255,255,.9) 0%,rgba(255,255,255,.5) 42%,rgba(255,255,255,0) 100%);border-radius:50%;transform:rotate(-22deg);z-index:1;pointer-events:none;}
.rb::after{content:'';position:absolute;bottom:0;left:0;right:0;height:32%;background:linear-gradient(to top,rgba(0,0,0,.22),transparent);z-index:1;pointer-events:none;}
.ball-blue {background:radial-gradient(circle at 38% 35%,#8FC8FF 0%,#3B92ED 42%,#1A68CC 100%);box-shadow:0 4px 14px rgba(59,146,237,.55),0 1px 3px rgba(0,0,0,.2);}
.ball-green{background:radial-gradient(circle at 38% 35%,#70E098 0%,#25B358 42%,#0D7A30 100%);box-shadow:0 4px 14px rgba(37,179,88,.55), 0 1px 3px rgba(0,0,0,.2);}
.ball-red  {background:radial-gradient(circle at 38% 35%,#FF8888 0%,#E53030 42%,#B80E0E 100%);box-shadow:0 4px 14px rgba(229,48,48,.55),  0 1px 3px rgba(0,0,0,.2);}
.ball-gray {background:radial-gradient(circle at 38% 35%,#D0D8DE 0%,#8E98A2 42%,#4A5460 100%);box-shadow:0 4px 10px rgba(74,84,96,.4),    0 1px 3px rgba(0,0,0,.2);}
.ball-special{width:54px;height:54px;font-size:19px;outline:2.5px solid rgba(255,255,255,.45);outline-offset:2px;}
.ball-pending{background:radial-gradient(circle at 38% 35%,#4a1010 0%,#2a0808 42%,#180303 100%);animation:rb-idle 2s ease-in-out infinite;}
.ball-drawing{background:radial-gradient(circle at 38% 35%,#FFD080 0%,#FFA020 42%,#E07000 100%);animation:rb-glow 1.2s ease-in-out infinite;}
@keyframes rb-idle{0%,100%{opacity:.6;transform:scale(1);}50%{opacity:.3;transform:scale(.9);}}
@keyframes rb-glow{0%,100%{box-shadow:0 4px 10px rgba(224,112,0,.4);}50%{box-shadow:0 4px 28px rgba(255,160,32,.85);}}
.balls-row{display:flex;align-items:flex-end;justify-content:center;gap:5px;flex-wrap:nowrap;}
.ball-col{display:flex;flex-direction:column;align-items:center;gap:5px;}
.ball-plus{font-size:18px;font-weight:900;color:rgba(251,191,36,.5);flex-shrink:0;line-height:1;margin-bottom:22px;}
.ball-label{font-size:10px;color:rgba(255,255,255,.65);text-align:center;line-height:1.2;white-space:nowrap;font-weight:500;}
.ball-label-special{color:rgba(255,210,80,.9);font-weight:700;}
.countdown-box{background:rgba(220,38,38,.12);border:1px solid rgba(220,38,38,.25);border-radius:12px;padding:10px 14px;text-align:center;}
.countdown-labels{display:flex;justify-content:center;gap:4px;margin-top:3px;}
.countdown-lbl{font-size:9px;color:rgba(251,191,36,.4);min-width:2ch;text-align:center;}
</style>
@endonce

<div style="margin:10px 10px 8px;border-radius:18px;overflow:hidden;
            border:1px solid rgba(220,38,38,.2);
            background:linear-gradient(180deg,#200505,#150000);">

    {{-- 卡片头 --}}
    <div style="padding:12px 14px 10px;background:linear-gradient(135deg,#2d0808,#1a0000);
                border-bottom:1px solid rgba(220,38,38,.15);
                display:flex;align-items:flex-start;justify-content:space-between;">
        <div>
            <div style="display:flex;align-items:baseline;gap:5px;">
                <span style="font-size:11px;color:rgba(251,191,36,.5);">第</span>
                <span style="font-size:26px;font-weight:900;line-height:1;
                             background:linear-gradient(90deg,#fbbf24,#f97316);
                             -webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                    {{ $draw->issue_number }}
                </span>
                <span style="font-size:11px;color:rgba(251,191,36,.5);">期</span>
                @if($isDrawing)
                    <span style="display:inline-flex;align-items:center;gap:3px;font-size:11px;color:#fbbf24;font-weight:700;margin-left:4px;">
                        <span style="width:5px;height:5px;border-radius:50%;background:#fbbf24;display:inline-block;animation:rb-glow 1s ease infinite;"></span>
                        正在开奖
                    </span>
                @endif
            </div>
            <div style="display:flex;align-items:center;gap:5px;margin-top:3px;font-size:11px;color:rgba(255,255,255,.4);">
                <svg style="width:12px;height:12px;color:#ea580c;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $draw->draw_date?->format('Y年m月d日') }}
                <span style="color:rgba(255,255,255,.2);">·</span>{{ $draw->getWeekdayLabel() }}
                @if($draw->draw_time)<span style="color:rgba(255,255,255,.2);">·</span>{{ substr($draw->draw_time,0,5) }}@endif
            </div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:5px;">
            <span style="font-size:10px;font-weight:800;padding:3px 8px;border-radius:6px;
                         background:linear-gradient(135deg,#fbbf24,#ea580c);color:#1a0000;
                         box-shadow:0 2px 8px rgba(251,191,36,.35);">
                {{ $draw->getTypeLabel() }}
            </span>
            @if($isCompleted)
                <span style="display:inline-flex;align-items:center;gap:3px;font-size:9px;color:#fbbf24;
                             background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.25);
                             border-radius:20px;padding:2px 7px;font-weight:600;">
                    <span style="width:4px;height:4px;border-radius:50%;background:#fbbf24;display:inline-block;"></span>已开奖
                </span>
            @elseif($isPending)
                <span style="font-size:9px;color:rgba(255,255,255,.3);background:rgba(255,255,255,.06);border-radius:20px;padding:2px 7px;font-weight:500;">待开奖</span>
            @endif
        </div>
    </div>

    {{-- 球区 --}}
    <div style="padding:18px 12px;background:linear-gradient(160deg,#0d0000,#060000);">
        @if($isCompleted || ($isDrawing && $draw->drawNumbers->count() > 0))
            <div class="balls-row">
                @foreach($draw->drawNumbers as $num)
                    <div class="ball-col">
                        <div class="rb {{ $ballClass($num->color) }}"><span>{{ str_pad($num->number,2,'0',STR_PAD_LEFT) }}</span></div>
                        <div class="ball-label">{{ \App\Helpers\LotteryHelper::getLabel((int)$num->number) }}</div>
                    </div>
                @endforeach
                @if($draw->special_number)
                    <div class="ball-plus">+</div>
                    <div class="ball-col">
                        <div class="rb {{ $specialBallClass }} ball-special"><span>{{ str_pad($draw->special_number,2,'0',STR_PAD_LEFT) }}</span></div>
                        <div class="ball-label ball-label-special">{{ \App\Helpers\LotteryHelper::getLabel((int)$draw->special_number) }}</div>
                    </div>
                @endif
            </div>
        @elseif($isDrawing)
            <div class="balls-row">
                @for($i=0;$i<6;$i++)
                    <div class="ball-col">
                        <div class="rb ball-drawing" style="animation-delay:{{ $i*.15 }}s"><span>?</span></div>
                        <div class="ball-label" style="color:rgba(255,200,80,.6);">开奖中</div>
                    </div>
                @endfor
                <div class="ball-plus">+</div>
                <div class="ball-col">
                    <div class="rb ball-drawing" style="animation-delay:.9s"><span>?</span></div>
                    <div class="ball-label ball-label-special">特别</div>
                </div>
            </div>
        @else
            <div class="balls-row" style="margin-bottom:14px;">
                @for($i=0;$i<6;$i++)
                    <div class="ball-col">
                        <div class="rb ball-pending" style="animation-delay:{{ $i*.18 }}s"><span style="opacity:.4;">?</span></div>
                        <div class="ball-label" style="opacity:.3;">--</div>
                    </div>
                @endfor
                <div class="ball-plus" style="opacity:.25;">+</div>
                <div class="ball-col">
                    <div class="rb ball-pending" style="animation-delay:1.08s"><span style="opacity:.4;">?</span></div>
                    <div class="ball-label" style="opacity:.3;">特别</div>
                </div>
            </div>
            <div class="countdown-box">
                <div style="font-size:10px;color:rgba(251,191,36,.5);margin-bottom:5px;letter-spacing:1px;">距开奖还有</div>
                <div id="{{ $countdownId }}" style="display:flex;align-items:baseline;justify-content:center;">
                    <span style="color:rgba(251,191,36,.3);font-size:12px;">计算中...</span>
                </div>
                <div class="countdown-labels">
                    <span class="countdown-lbl">时</span><span class="countdown-lbl" style="min-width:8px;"></span>
                    <span class="countdown-lbl">分</span><span class="countdown-lbl" style="min-width:8px;"></span>
                    <span class="countdown-lbl">秒</span>
                </div>
            </div>
        @endif
    </div>

    {{-- 视频按钮 --}}
    @if($hasVideo && ($isCompleted || $isDrawing))
        <div style="padding:0 12px 8px;">
            <button onclick="openVideoModal('{{ $videoSrc }}')"
                    style="width:100%;display:flex;align-items:center;justify-content:center;gap:6px;
                           border-radius:12px;padding:10px 0;border:none;cursor:pointer;
                           background:linear-gradient(135deg,#fbbf24,#ea580c,#dc2626);
                           color:#fff;font-size:13px;font-weight:800;
                           box-shadow:0 4px 16px rgba(220,38,38,.45);">
                <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                查看开奖视频
            </button>
        </div>
    @endif

    {{-- 底部 --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 14px 12px;border-top:1px solid rgba(220,38,38,.1);">
        <div style="display:flex;align-items:center;gap:4px;font-size:10px;color:rgba(255,255,255,.25);">
            <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $draw->draw_date?->format('Y/m/d') }}
        </div>
        @if($draw->history_url)
            <a href="{{ $draw->history_url }}"
               style="display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:700;
                      color:#fbbf24;background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.2);
                      padding:4px 12px;border-radius:20px;">
                历史记录
                <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <span style="font-size:10px;color:rgba(255,255,255,.2);">{{ $draw->getTypeLabel() }}</span>
        @endif
    </div>
</div>
