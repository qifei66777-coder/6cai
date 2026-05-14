@extends('layouts.app')

@section('title', '开奖信息首页')

@section('content')
    {{-- 最新开奖快览条 --}}
    @include('components.home.latest-draw-bar')

    {{-- 跑马灯公告 --}}
    @include('components.home.marquee-bar')

    {{-- Banner 轮播 --}}
    @include('components.home.banner-carousel')

    <div class="pb-6">
        @php $sectionIndex = 0; @endphp

        @foreach($sections as $section)
            @php $sectionIndex++; @endphp

            @switch($section->section_key)
                @case('draw')
                    @include('components.home.draw-section')
                    @break
                @case('posts')
                    @include('components.home.posts-section', ['section' => $section])
                    @break
                @case('gallery')
                    @include('components.home.gallery-section', ['section' => $section])
                    @break
            @endswitch

            {{-- draw 板块之后插入宣传条2 --}}
            @if($section->section_key === 'draw')
                @include('components.home.site-promo-banner', ['variant' => 2])
            @endif

            {{-- posts 板块之后插入宣传条3 --}}
            @if($section->section_key === 'posts')
                @include('components.home.site-promo-banner', ['variant' => 3])
            @endif

        @endforeach

        {{-- 推广链接区 --}}
        @include('components.home.promo-links')
    </div>
@endsection
