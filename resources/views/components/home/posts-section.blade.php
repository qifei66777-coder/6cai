{{-- 帖子列表模块 --}}
@php
    $sectionTitle = $section?->title ?: '最新帖子';
@endphp
<div id="posts-section" class="mx-3 mt-3">
    <div class="flex items-center justify-between mb-2 px-1">
        <h2 class="text-base font-bold text-gray-800">{{ $sectionTitle }}</h2>
        <a href="#" class="text-green-600 text-sm flex items-center gap-0.5">
            查看更多
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        @forelse($posts as $post)
            <a href="{{ route('post.show', $post) }}"
               class="flex items-start gap-3 px-4 py-3 border-b border-gray-50 last:border-b-0 active:bg-gray-50">
                {{-- 左侧文字 --}}
                <div class="flex-1 min-w-0">
                    {{-- 标签 --}}
                    @if($post->tag)
                        <span class="inline-block text-xs px-1.5 py-0.5 rounded mr-1 font-semibold
                            {{ $post->tag === '置顶' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-600' }}">
                            {{ $post->tag }}
                        </span>
                    @endif
                    <span class="text-sm font-semibold text-gray-800 leading-snug">{{ $post->title }}</span>

                    @if($post->excerpt)
                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $post->excerpt }}</p>
                    @endif

                    <div class="text-xs text-gray-400 mt-1">
                        {{ $post->published_at?->format('Y-m-d') ?? $post->created_at->format('Y-m-d') }}
                    </div>
                </div>

                {{-- 右侧封面图 --}}
                @if($post->cover_image)
                    <div class="w-16 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                        <img src="{{ Storage::disk('public')->url($post->cover_image) }}"
                             alt="{{ $post->title }}"
                             class="w-full h-full object-cover" loading="lazy">
                    </div>
                @endif
            </a>
        @empty
            <div class="py-10 text-center text-gray-400 text-sm">暂无帖子</div>
        @endforelse
    </div>
</div>
