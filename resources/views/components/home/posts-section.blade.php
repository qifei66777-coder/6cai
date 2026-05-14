{{-- 帖子列表模块（按是否有封面图智能切换：有图=大图卡 / 无图=纯标题，连续无图自动合并成列表） --}}
@php
    $sectionTitle    = $section?->title    ?: '最新资讯';
    $sectionSubtitle = $section?->subtitle ?: '开奖动态与彩票资讯';
@endphp

@once
<style>
/* ── 带图卡片 ── */
.pc-img {
    display:block; border-radius:14px; margin-bottom:8px; overflow:hidden;
    border:1px solid rgba(220,38,38,.2);
    background:#150000;
    box-shadow:0 2px 16px rgba(0,0,0,.45);
    -webkit-tap-highlight-color:transparent;
    transition:opacity .15s;
    text-decoration:none;
}
.pc-img:active { opacity:.85; }

/* ── 纯标题卡片 ── */
.pc-text {
    display:flex; align-items:center;
    border-radius:10px; margin-bottom:5px;
    padding:0 12px;
    height:50px;
    border:1px solid rgba(255,255,255,.05);
    background:rgba(255,255,255,.03);
    -webkit-tap-highlight-color:transparent;
    transition:background .15s;
    text-decoration:none;
    overflow:hidden;
}
.pc-text:active { background:rgba(220,38,38,.08); }

/* 纯标题 — 左红竖线 */
.pc-text-accent {
    flex-shrink:0; width:2px; height:16px;
    background:linear-gradient(180deg,#fbbf24,#dc2626);
    border-radius:2px; margin-right:10px;
}

/* 纯标题列表容器 */
.pc-list {
    border-radius:12px; overflow:hidden;
    border:1px solid rgba(220,38,38,.15);
    background:linear-gradient(180deg,#180000,#100000);
    margin-bottom:8px;
    padding:4px 0;
}

/* 纯标题列表内分隔线 */
.pc-list a + a {
    border-top:1px solid rgba(255,255,255,.04);
}

/* 多行截断 */
.pc-title-1 { display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden; }
.pc-title-2 { display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
</style>
@endonce

<div id="posts-section" class="px-3 pt-4">

    {{-- 板块标题 --}}
    <div class="section-header">
        <div class="section-title-bar">
            <div class="section-accent"></div>
            <div>
                <div class="section-title-text">{{ $sectionTitle }}</div>
                <div class="section-subtitle-text">{{ $sectionSubtitle }}</div>
            </div>
        </div>
        <a href="#" style="display:flex;align-items:center;gap:2px;font-size:12px;font-weight:700;color:#fbbf24;">
            更多
            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @php $textListOpen = false; @endphp

    @forelse($posts as $post)
    @php
        $postUrl   = route('post.show', $post->id);
        $hasCover  = !empty($post->cover_image);
        $coverUrl  = $hasCover ? Storage::disk('public')->url($post->cover_image) : null;
        $catName   = $post->tag ?? '';
        $dateStr   = $post->published_at?->format('m-d') ?? $post->created_at->format('m-d');
    @endphp

    @if($hasCover)
        {{-- 遇到带图帖子：先关闭可能开着的列表 --}}
        @if($textListOpen)</div>@php $textListOpen = false; @endphp @endif

        {{-- ═══════════════════════════
             带图卡片
             ═══════════════════════════ --}}
        <a href="{{ $postUrl }}" class="pc-img">
            <div style="width:100%;height:155px;position:relative;overflow:hidden;">
                <img src="{{ $coverUrl }}" alt="{{ $post->title }}"
                     style="width:100%;height:100%;object-fit:cover;display:block;">
                <div style="position:absolute;inset:0;
                            background:linear-gradient(to top,rgba(10,0,0,.85) 0%,rgba(10,0,0,.3) 50%,transparent 100%);"></div>
                @if($catName)
                    <span style="position:absolute;top:10px;left:10px;
                                 font-size:9px;font-weight:800;color:#1a0000;
                                 background:linear-gradient(135deg,#fbbf24,#ea580c);
                                 padding:2px 8px;border-radius:20px;">
                        {{ $catName }}
                    </span>
                @endif
                <div style="position:absolute;bottom:10px;left:12px;right:12px;">
                    <div class="pc-title-2"
                         style="font-size:15px;font-weight:800;color:#fff;line-height:1.35;
                                text-shadow:0 1px 8px rgba(0,0,0,.7);">
                        {{ $post->title }}
                    </div>
                    <div style="display:flex;align-items:center;gap:4px;margin-top:4px;
                                font-size:10px;color:rgba(255,255,255,.45);">
                        <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $post->published_at?->format('Y-m-d') ?? $post->created_at->format('Y-m-d') }}
                        <span style="margin-left:auto;color:rgba(251,191,36,.7);font-weight:600;">
                            阅读全文 →
                        </span>
                    </div>
                </div>
            </div>
        </a>

    @else
        {{-- 遇到无图帖子：如未开列表则开启 --}}
        @if(!$textListOpen)<div class="pc-list">@php $textListOpen = true; @endphp @endif

        <a href="{{ $postUrl }}" class="pc-text">
            <div class="pc-text-accent"></div>
            <div style="flex:1;min-width:0;">
                <div class="pc-title-1"
                     style="font-size:13px;font-weight:600;color:rgba(255,255,255,.85);line-height:1.4;">
                    {{ $post->title }}
                </div>
                @if($catName || $dateStr)
                    <div style="display:flex;align-items:center;gap:6px;margin-top:2px;">
                        @if($catName)
                            <span style="font-size:9px;font-weight:700;color:#ea580c;">{{ $catName }}</span>
                        @endif
                        <span style="font-size:9px;color:rgba(255,255,255,.2);">{{ $dateStr }}</span>
                    </div>
                @endif
            </div>
            <svg style="width:12px;height:12px;flex-shrink:0;color:rgba(220,38,38,.35);margin-left:8px;"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- 如果是最后一篇且列表还开着，关闭 --}}
        @if($loop->last && $textListOpen)</div>@php $textListOpen = false; @endphp @endif
    @endif

    @empty
    <div style="border-radius:14px;padding:40px 0;display:flex;flex-direction:column;
                align-items:center;gap:8px;background:rgba(30,3,3,.5);
                border:1px solid rgba(220,38,38,.1);">
        <svg style="width:40px;height:40px;opacity:.2;" fill="none" stroke="rgba(251,191,36,.6)" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <span style="font-size:13px;color:rgba(255,255,255,.2);">暂无资讯</span>
    </div>
    @endforelse

    {{-- 兜底：如循环结束后列表还开着 --}}
    @if($textListOpen ?? false)</div>@endif
</div>
