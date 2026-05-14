<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', '开奖信息展示') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', '马来西亚六合彩开奖信息，公正、透明、及时')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:'#dc2626','primary-dark':'#991b1b',orange:'#ea580c',gold:'#fbbf24',
                    },
                    maxWidth:{'mobile':'480px'}
                }
            }
        }
    </script>
    <style>
        :root {
            --red:    #dc2626;
            --red-dk: #991b1b;
            --red-xd: #7f1d1d;
            --orange: #ea580c;
            --gold:   #fbbf24;
            --bg:     #0d0000;
        }
        * { -webkit-tap-highlight-color:transparent; box-sizing:border-box; }
        body {
            background:#0d0000;
            font-family:-apple-system,BlinkMacSystemFont,'PingFang SC','Helvetica Neue',sans-serif;
        }
        .mobile-container {
            max-width:480px; margin:0 auto; min-height:100vh;
            background:linear-gradient(160deg,#130000 0%,#0a0000 40%,#150500 100%);
        }
        .safe-bottom { padding-bottom:env(safe-area-inset-bottom,0); }

        .prose img   { max-width:100%;height:auto;border-radius:8px; }
        .prose a     { color:var(--red);text-decoration:underline;word-break:break-all; }
        .prose table { width:100%;overflow-x:auto;display:block; }
        .prose p     { margin-bottom:.75rem;line-height:1.7; }
        .prose h2    { font-size:1.1rem;font-weight:700;margin:1rem 0 .5rem; }
        .prose h3    { font-size:1rem;font-weight:600;margin:.8rem 0 .4rem; }
        .prose ul    { padding-left:1.25rem;list-style:disc;margin-bottom:.75rem; }
        .prose ol    { padding-left:1.25rem;list-style:decimal;margin-bottom:.75rem; }
        .prose blockquote { border-left:3px solid var(--red);padding-left:.75rem;color:#6b7280;font-style:italic;margin:.75rem 0; }

        .ball    { width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;color:white;font-size:16px;flex-shrink:0;box-shadow:0 2px 4px rgba(0,0,0,.2); }
        .ball-sm { width:36px;height:36px;font-size:13px; }
        .countdown-digit { font-size:1.6rem;font-weight:800;color:#fff;min-width:2ch;display:inline-block;text-align:center;line-height:1; }

        #video-modal { display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.88);align-items:center;justify-content:center; }
        #video-modal.active { display:flex; }

        /* 底部导航 */
        .nav-item { display:flex;flex-direction:column;align-items:center;padding:8px 0 6px;flex:1;color:#9ca3af;transition:color .15s;position:relative; }
        .nav-item.active { color:var(--gold); }
        .nav-item.active::after { content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:32px;height:2px;background:linear-gradient(90deg,var(--orange),var(--red));border-radius:0 0 2px 2px; }
        .nav-item svg { transition:transform .15s; }
        .nav-item.active svg { transform:scale(1.08); }
        .nav-item span { font-size:10px;margin-top:2px;font-weight:500; }
        .nav-item.active span { font-weight:700; }

        /* 板块标题 */
        .section-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:10px; }
        .section-title-bar { display:flex;align-items:center;gap:8px; }
        .section-accent { width:4px;height:20px;background:linear-gradient(180deg,var(--gold),var(--red));border-radius:2px;flex-shrink:0; }
        .section-title-text { font-size:15px;font-weight:800;color:#fff; }
        .section-subtitle-text { font-size:11px;color:rgba(255,255,255,.45);margin-top:1px; }

        @keyframes draw-outer-glow {
            0%,100% { box-shadow:0 0 20px rgba(220,38,38,.5),0 0 60px rgba(234,88,12,.2); }
            50%      { box-shadow:0 0 35px rgba(220,38,38,.75),0 0 80px rgba(234,88,12,.35); }
        }
        @keyframes fire-flicker { 0%,100%{opacity:1;transform:scaleY(1);}50%{opacity:.8;transform:scaleY(1.08) rotate(2deg);} }
        @keyframes pulse-hot    { 0%,100%{box-shadow:0 0 0 0 rgba(220,38,38,.6);}50%{box-shadow:0 0 0 8px rgba(220,38,38,0);} }
    </style>
    @stack('head')
</head>
<body class="min-h-screen">
<div class="mobile-container min-h-screen">

    {{-- 顶部 Header --}}
    <header class="sticky top-0 z-50 px-4 py-2 flex items-center justify-between"
            style="background:linear-gradient(135deg,#1a0000 0%,#3d0000 50%,#1a0000 100%);
                   box-shadow:0 2px 12px rgba(220,38,38,.35),0 1px 0 rgba(220,38,38,.2);">
        <div class="flex items-center gap-2.5">
            <div style="width:40px;height:40px;border-radius:12px;flex-shrink:0;overflow:hidden;
                        background:linear-gradient(135deg,#2d0000,#5a0000);
                        border:1px solid rgba(220,38,38,.5);
                        box-shadow:0 2px 12px rgba(220,38,38,.45);">
                <img src="/images/logo.png" alt="Logo"
                     style="width:100%;height:100%;object-fit:contain;
                            filter:hue-rotate(240deg) saturate(1.6) brightness(1.15);"
                     onerror="this.style.display='none';this.parentElement.innerHTML='<svg style=\'width:22px;height:22px;margin:9px;\' fill=\'#dc2626\' viewBox=\'0 0 24 24\'><path d=\'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5\'/></svg>';">
            </div>
            <div>
                <div style="font-size:14px;font-weight:900;color:var(--gold);text-shadow:0 1px 6px rgba(251,191,36,.4);">
                    马来西亚六合彩
                </div>
                <div style="font-size:10px;color:rgba(251,191,36,.6);margin-top:1px;display:flex;align-items:center;gap:4px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:var(--gold);display:inline-block;animation:fire-flicker 1.5s ease-in-out infinite;"></span>
                    公正 · 透明 · 及时
                </div>
            </div>
        </div>
        <div>
            @hasSection('back-btn')
                <a href="{{ route('home') }}"
                   style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;
                          color:var(--gold);background:rgba(220,38,38,.15);
                          border:1px solid rgba(220,38,38,.3);padding:6px 12px;border-radius:20px;">
                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    返回首页
                </a>
            @else
                <button style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.06);
                               display:flex;align-items:center;justify-content:center;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="rgba(255,255,255,.6)" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>
            @endif
        </div>
    </header>

    <main class="pb-20">@yield('content')</main>

    {{-- 底部导航 --}}
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-mobile safe-bottom z-40"
         style="background:linear-gradient(180deg,#1a0000,#0d0000);
                border-top:1px solid rgba(220,38,38,.2);
                box-shadow:0 -4px 20px rgba(0,0,0,.5);">
        <div class="flex">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="w-6 h-6" viewBox="0 0 24 24"
                     fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>首页</span>
            </a>
            <a href="#draw-section" class="nav-item {{ request()->routeIs('draw*') ? 'active' : '' }}">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                </svg>
                <span>开奖</span>
            </a>
            <a href="#posts-section" class="nav-item {{ request()->routeIs('post*') ? 'active' : '' }}">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>资讯</span>
            </a>
            <a href="#" class="nav-item">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>我的</span>
            </a>
        </div>
    </nav>
</div>

<div id="video-modal" onclick="closeVideoModal(this,event)">
    <div class="relative w-full mx-4" style="max-width:460px">
        <button onclick="closeVideoModalBtn()"
                class="absolute -top-10 right-0 text-white text-3xl leading-none w-10 h-10 flex items-center justify-center">&times;</button>
        <video id="modal-video" controls playsinline class="w-full rounded-2xl bg-black"
               style="max-height:65vh;box-shadow:0 20px 60px rgba(0,0,0,.6);"></video>
    </div>
</div>
<script>
function openVideoModal(src){const m=document.getElementById('video-modal'),v=document.getElementById('modal-video');v.src=src;m.classList.add('active');v.play().catch(()=>{});}
function closeVideoModal(m,e){if(e.target===m)closeVideoModalBtn();}
function closeVideoModalBtn(){const m=document.getElementById('video-modal'),v=document.getElementById('modal-video');v.pause();v.src='';m.classList.remove('active');}
</script>
@stack('scripts')
</body>
</html>
