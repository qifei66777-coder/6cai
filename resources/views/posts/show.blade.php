@extends('layouts.app')

@section('title', $post->title)
@section('header-title', '帖子详情')
@section('back-btn', true)

@section('content')
    <article class="mx-3 mt-3">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            {{-- 封面图 --}}
            @if($post->cover_image)
                <div class="w-full aspect-video bg-gray-100">
                    <img src="{{ Storage::disk('public')->url($post->cover_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif

            <div class="px-4 py-4">
                {{-- 标签 --}}
                @if($post->tag)
                    <span class="inline-block text-xs px-2 py-0.5 rounded mb-2 font-semibold
                        {{ $post->tag === '置顶' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-600' }}">
                        {{ $post->tag }}
                    </span>
                @endif

                {{-- 标题 --}}
                <h1 class="text-lg font-bold text-gray-900 leading-snug mb-2">
                    {{ $post->title }}
                </h1>

                {{-- 发布时间 --}}
                <div class="text-xs text-gray-400 flex items-center gap-1 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $post->published_at?->format('Y-m-d H:i') ?? $post->created_at->format('Y-m-d H:i') }}
                </div>

                <hr class="border-gray-100 mb-4">

                {{-- 正文 --}}
                <div class="prose text-sm text-gray-700 leading-relaxed">
                    {!! $post->content !!}
                </div>
            </div>
        </div>

        {{-- 返回按钮 --}}
        <a href="{{ route('home') }}"
           class="flex items-center justify-center gap-2 mt-4 mb-4 py-3 bg-white rounded-2xl shadow-sm text-green-600 text-sm font-medium active:bg-gray-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            返回首页
        </a>
    </article>
@endsection
