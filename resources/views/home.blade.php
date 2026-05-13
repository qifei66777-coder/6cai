@extends('layouts.app')

@section('title', '开奖信息首页')

@section('content')
    <div class="pt-1 pb-4">
        @foreach($sections as $section)
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
        @endforeach

        @if($sections->isEmpty())
            <div class="text-center py-20 text-gray-400 text-sm">
                后台尚未配置首页模块，请登录后台进行设置。
            </div>
        @endif
    </div>
@endsection
