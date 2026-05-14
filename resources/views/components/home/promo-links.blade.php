@if($promoLinks->isNotEmpty())
<div class="px-3 pt-4">
    <div class="section-header mb-3">
        <div class="section-title-bar">
            <div class="section-accent"></div>
            <div>
                <div class="section-title-text">推荐平台</div>
                <div class="section-subtitle-text">精选合作平台，安全可靠</div>
            </div>
        </div>
    </div>
    <div style="border-radius:16px;overflow:hidden;border:1px solid rgba(220,38,38,.15);background:linear-gradient(180deg,#1a0505,#110000);">
        @foreach($promoLinks as $link)
            <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;
                        {{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,.05);' : '' }}">
                <div style="flex-shrink:0;width:38px;height:38px;border-radius:10px;
                            display:flex;align-items:center;justify-content:center;
                            background:linear-gradient(135deg,rgba(251,191,36,.15),rgba(234,88,12,.15));
                            border:1px solid rgba(251,191,36,.2);">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#fbbf24" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:700;color:#fff;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $link->title }}</div>
                    @if($link->description)
                        <div style="font-size:10px;color:rgba(255,255,255,.35);margin-top:2px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">{{ $link->description }}</div>
                    @endif
                </div>
                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                   style="flex-shrink:0;font-size:11px;font-weight:800;color:#1a0000;
                          padding:6px 14px;border-radius:20px;white-space:nowrap;
                          background:linear-gradient(135deg,#fbbf24,#ea580c);
                          box-shadow:0 2px 10px rgba(234,88,12,.4);">
                    {{ $link->button_text ?: '立即查看' }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif
