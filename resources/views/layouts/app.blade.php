<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', '开奖信息展示') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', '开奖信息展示，公正、透明、及时')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#16a34a',
                        'primary-dark': '#15803d',
                        'primary-light': '#dcfce7',
                    },
                    maxWidth: {
                        'mobile': '480px',
                    }
                }
            }
        }
    </script>
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { background-color: #f3f4f6; }
        .mobile-container { max-width: 480px; margin: 0 auto; }
        /* 安全区域适配 */
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0); }
        /* 富文本内容样式 */
        .prose img { max-width: 100%; height: auto; border-radius: 8px; }
        .prose a { color: #16a34a; text-decoration: underline; word-break: break-all; }
        .prose table { width: 100%; overflow-x: auto; display: block; }
        .prose p { margin-bottom: 0.75rem; line-height: 1.7; }
        .prose h2 { font-size: 1.1rem; font-weight: 700; margin: 1rem 0 0.5rem; }
        .prose h3 { font-size: 1rem; font-weight: 600; margin: 0.8rem 0 0.4rem; }
        .prose ul { padding-left: 1.25rem; list-style: disc; margin-bottom: 0.75rem; }
        .prose ol { padding-left: 1.25rem; list-style: decimal; margin-bottom: 0.75rem; }
        .prose blockquote { border-left: 3px solid #16a34a; padding-left: 0.75rem; color: #6b7280; font-style: italic; margin: 0.75rem 0; }
        /* 号码球 */
        .ball { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .ball-sm { width: 36px; height: 36px; font-size: 13px; }
        @media (max-width: 360px) { .ball { width: 38px; height: 38px; font-size: 14px; } }
        /* 倒计时 */
        .countdown-digit { font-size: 2rem; font-weight: 800; color: #15803d; min-width: 2.5ch; display: inline-block; text-align: center; line-height: 1; }
        /* 视频弹窗 */
        #video-modal { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.85); align-items: center; justify-content: center; }
        #video-modal.active { display: flex; }
    </style>
    @stack('head')
</head>
<body class="min-h-screen">
    <div class="mobile-container min-h-screen bg-gray-100">
        {{-- 顶部 Logo 导航 --}}
        <header class="bg-white px-4 py-2 flex items-center justify-between sticky top-0 z-50"
                style="box-shadow:0 1px 8px rgba(0,0,0,.08);">
            <div class="flex items-center gap-2">
                <img src="/images/logo.png" alt="ML6 Logo"
                     class="h-12 w-auto object-contain flex-shrink-0">
                <div>
                    <div class="font-bold text-sm leading-tight text-gray-800">马来西亚六合彩开奖信息</div>
                    <div class="text-xs text-green-600 mt-0.5">公正 · 透明 · 及时</div>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm">
                @hasSection('back-btn')
                    <a href="{{ route('home') }}" class="flex items-center gap-1 text-green-600 text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        返回首页
                    </a>
                @else
                    <button class="flex items-center gap-1 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="text-xs">消息</span>
                    </button>
                @endif
            </div>
        </header>

        {{-- 主内容区 --}}
        <main class="pb-20">
            @yield('content')
        </main>

        {{-- 底部导航栏 --}}
        <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-mobile bg-white border-t border-gray-200 safe-bottom z-40">
            <div class="flex">
                <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center py-2 {{ request()->routeIs('home') ? 'text-green-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-xs mt-0.5">首页</span>
                </a>
                <a href="#draw-section" class="flex-1 flex flex-col items-center py-2 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-xs mt-0.5">开奖</span>
                </a>
                <a href="#posts-section" class="flex-1 flex flex-col items-center py-2 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM9 14h6m-6-4h6m-6 4h6"/></svg>
                    <span class="text-xs mt-0.5">发现</span>
                </a>
                <a href="#" class="flex-1 flex flex-col items-center py-2 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-xs mt-0.5">我的</span>
                </a>
            </div>
        </nav>
    </div>

    {{-- 视频弹窗 --}}
    <div id="video-modal" onclick="closeVideoModal(this, event)">
        <div class="relative w-full mx-4" style="max-width:460px">
            <button onclick="closeVideoModalBtn()" class="absolute -top-10 right-0 text-white text-3xl leading-none">&times;</button>
            <video id="modal-video" controls playsinline class="w-full rounded-xl bg-black" style="max-height:60vh"></video>
        </div>
    </div>

    <script>
        function openVideoModal(src) {
            const modal = document.getElementById('video-modal');
            const video = document.getElementById('modal-video');
            video.src = src;
            modal.classList.add('active');
            video.play().catch(()=>{});
        }
        function closeVideoModal(modal, e) {
            if (e.target === modal) { closeVideoModalBtn(); }
        }
        function closeVideoModalBtn() {
            const modal = document.getElementById('video-modal');
            const video = document.getElementById('modal-video');
            video.pause();
            video.src = '';
            modal.classList.remove('active');
        }
    </script>

    @stack('scripts')
</body>
</html>
