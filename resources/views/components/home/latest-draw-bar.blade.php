@if($storeDrawResult || $onlineDrawResult)
@php
    $miniColorStyle = fn($c) => match($c) {
        'red'   => 'background:linear-gradient(135deg,#FF8888,#E53030);',
        'green' => 'background:linear-gradient(135deg,#70E098,#25B358);',
        'blue'  => 'background:linear-gradient(135deg,#8FC8FF,#3B92ED);',
        default => 'background:linear-gradient(135deg,#8FC8FF,#3B92ED);',
    };
@endphp
<div style="margin-top:10px;border-radius:12px 12px 0 0;overflow:hidden;border-bottom:1px solid rgba(220,38,38,.2);background:linear-gradient(180deg,#1a0000,#110000);margin:10px 12px 0;border-radius:12px;border:1px solid rgba(220,38,38,.15);">
    @foreach([['label'=>'澳彩','draw'=>$storeDrawResult],['label'=>'港彩','draw'=>$onlineDrawResult]] as $item)
        @if($item['draw'])
        @php $d=$item['draw']; @endphp
        <div style="display:flex;align-items:center;gap:8px;padding:0 12px;height:36px;border-bottom:1px solid rgba(255,255,255,.04);">
            <span style="flex-shrink:0;font-size:10px;font-weight:800;color:#1a0000;
                         background:linear-gradient(135deg,#fbbf24,#ea580c);
                         padding:2px 6px;border-radius:5px;letter-spacing:.5px;">
                {{ $item['label'] }}
            </span>
            <span style="font-size:10px;color:rgba(255,255,255,.3);flex-shrink:0;">第{{ $d->issue_number }}期</span>
            @if($d->status==='completed')
                <div style="display:flex;align-items:center;gap:3px;flex:1;min-width:0;overflow:hidden;">
                    @foreach($d->drawNumbers as $num)
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;font-size:9px;font-weight:800;color:#fff;flex-shrink:0;{{ $miniColorStyle($num->color) }}">
                            {{ str_pad($num->number,2,'0',STR_PAD_LEFT) }}
                        </span>
                    @endforeach
                    @if($d->special_number)
                        <span style="color:rgba(251,191,36,.5);font-size:10px;font-weight:700;flex-shrink:0;">+</span>
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;font-size:9px;font-weight:800;color:#fff;flex-shrink:0;background:linear-gradient(135deg,#FFD080,#FFA020);">
                            {{ str_pad($d->special_number,2,'0',STR_PAD_LEFT) }}
                        </span>
                    @endif
                </div>
                <span style="font-size:10px;color:rgba(255,255,255,.25);flex-shrink:0;margin-left:auto;">{{ $d->draw_date?->format('m/d') }}</span>
            @else
                <span style="font-size:10px;color:rgba(255,255,255,.25);font-style:italic;flex:1;">待开奖</span>
            @endif
        </div>
        @endif
    @endforeach
</div>
@endif
