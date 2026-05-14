@if($marqueeText)
<div class="mq-bar">
    {{-- 左侧公告标签 --}}
    <div class="mq-label">
        <div class="mq-label-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.585l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.069-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
        </div>
        <span class="mq-label-text">公告</span>
    </div>

    {{-- 跑马灯滚动文字 --}}
    <div class="mq-track">
        <div class="mq-inner">
            <span class="mq-text" data-text="{{ $marqueeText }}">{{ $marqueeText }}</span>
            <span class="mq-sep mq-sep-1">💎</span>
            <span class="mq-text" data-text="{{ $marqueeText }}">{{ $marqueeText }}</span>
            <span class="mq-sep mq-sep-2">✨</span>
            <span class="mq-text" data-text="{{ $marqueeText }}">{{ $marqueeText }}</span>
            <span class="mq-sep mq-sep-3">🎰</span>
        </div>
    </div>

    {{-- 右侧渐隐遮罩 --}}
    <div class="mq-fade-right"></div>
</div>

<style>
.mq-bar {
    margin: 8px 0 0;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: stretch;
    height: clamp(36px, 9.5vw, 44px);
    background:
        linear-gradient(135deg, #4b0000 0%, #7f1d1d 25%, #dc2626 55%, #ea580c 85%, #4b0000 100%);
    background-size: 200% 100%;
    animation: mq-bg-shift 6s ease-in-out infinite;
    box-shadow:
        0 2px 12px rgba(220,38,38,.35),
        inset 0 1px 0 rgba(255,255,255,.08),
        inset 0 -1px 0 rgba(0,0,0,.35);
}
@keyframes mq-bg-shift {
    0%,100% { background-position: 0% 50%; }
    50%     { background-position: 100% 50%; }
}

/* 左侧"公告"标签 - 黑底金字 */
.mq-label {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 0 12px;
    background: linear-gradient(180deg, #1a0000 0%, #0d0000 100%);
    border-right: 1px solid rgba(251,191,36,.4);
    box-shadow: 2px 0 8px rgba(0,0,0,.4);
    position: relative;
    z-index: 2;
}
.mq-label::after {
    content: '';
    position: absolute;
    right: -6px; top: 50%;
    width: 0; height: 0;
    border-left: 6px solid #0d0000;
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    transform: translateY(-50%);
}
.mq-label-icon {
    width: clamp(14px, 4vw, 17px);
    height: clamp(14px, 4vw, 17px);
    color: #fbbf24;
    animation: mq-icon-shake 1.8s ease-in-out infinite;
}
@keyframes mq-icon-shake {
    0%,100% { transform: rotate(-12deg); }
    25%     { transform: rotate(8deg); }
    50%     { transform: rotate(-8deg); }
    75%     { transform: rotate(10deg); }
}
.mq-label-text {
    font-size: clamp(11px, 3.2vw, 13px);
    font-weight: 900;
    color: #fbbf24;
    letter-spacing: 2px;
    text-shadow: 0 1px 4px rgba(0,0,0,.5), 0 0 8px rgba(251,191,36,.4);
}

/* 滚动轨道 */
.mq-track {
    flex: 1;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
}
.mq-inner {
    display: inline-flex;
    align-items: center;
    gap: clamp(20px, 6vw, 36px);
    white-space: nowrap;
    font-size: clamp(13px, 3.9vw, 16px);
    font-weight: 900;
    padding-left: 100%;
    animation: mq-scroll 28s linear infinite;
    will-change: transform;
}
.mq-inner:hover { animation-play-state: paused; }
@keyframes mq-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}

/* ★ 滚动文字特效 — 金色流光 + 光晕 + 呼吸 ★ */
.mq-text {
    flex-shrink: 0;
    letter-spacing: 1.2px;
    position: relative;
    /* 金色到白色再到金色的渐变 */
    background: linear-gradient(90deg,
        #fff8dc 0%,
        #fbbf24 15%,
        #fde68a 30%,
        #ffffff 45%,
        #fde68a 60%,
        #fbbf24 75%,
        #fff8dc 100%
    );
    background-size: 250% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
    /* 流光效果：渐变从右往左扫过文字 */
    animation:
        mq-text-shine 3s linear infinite,
        mq-text-breath 2s ease-in-out infinite;
    /* 多层光晕 */
    filter:
        drop-shadow(0 0 4px rgba(251,191,36,.6))
        drop-shadow(0 0 8px rgba(255,200,80,.35))
        drop-shadow(0 1px 2px rgba(0,0,0,.55));
}
@keyframes mq-text-shine {
    0%   { background-position: 250% center; }
    100% { background-position: 0% center; }
}
@keyframes mq-text-breath {
    0%,100% { filter:
                drop-shadow(0 0 4px rgba(251,191,36,.6))
                drop-shadow(0 0 8px rgba(255,200,80,.35))
                drop-shadow(0 1px 2px rgba(0,0,0,.55)); }
    50%     { filter:
                drop-shadow(0 0 7px rgba(251,191,36,.95))
                drop-shadow(0 0 14px rgba(255,200,80,.6))
                drop-shadow(0 1px 2px rgba(0,0,0,.55)); }
}

/* ★ Emoji 分隔符 — 旋转 + 缩放 + 不同延迟 ★ */
.mq-sep {
    flex-shrink: 0;
    font-size: clamp(15px, 4.2vw, 18px);
    filter: drop-shadow(0 0 6px rgba(251,191,36,.7));
    display: inline-block;
}
.mq-sep-1 { animation: mq-sep-bounce 2.5s ease-in-out infinite; }
.mq-sep-2 { animation: mq-sep-spin 2s linear infinite; }
.mq-sep-3 { animation: mq-sep-shake 1.8s ease-in-out infinite; }
@keyframes mq-sep-bounce {
    0%,100% { transform: scale(1) translateY(0); }
    50%     { transform: scale(1.3) translateY(-2px); }
}
@keyframes mq-sep-spin {
    0%   { transform: rotate(0deg) scale(1); }
    50%  { transform: rotate(180deg) scale(1.2); }
    100% { transform: rotate(360deg) scale(1); }
}
@keyframes mq-sep-shake {
    0%,100% { transform: rotate(-10deg) scale(1); }
    25%     { transform: rotate(12deg) scale(1.15); }
    50%     { transform: rotate(-8deg) scale(1); }
    75%     { transform: rotate(10deg) scale(1.1); }
}

/* 右侧渐隐遮罩 */
.mq-fade-right {
    position: absolute;
    right: 0; top: 0; bottom: 0;
    width: 28px;
    pointer-events: none;
    background: linear-gradient(to right, transparent, rgba(75,0,0,.6));
    z-index: 2;
}
</style>
@endif
