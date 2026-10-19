<!doctype html>
<html lang="en" x-data="{ dark: localStorage.getItem('donne-theme') === 'dark', menu:false }" x-bind:class="dark ? 'dark' : ''">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Donne TOPUP — Roblox Store')</title>
<script>tailwind={config:{darkMode:'class',theme:{extend:{colors:{gold:{400:'#026b2a',500:'#006923',600:'#07ff45'}}}}}}</script>
<script src="https://cdn.tailwindcss.com"></script><script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>body{font-family:Inter,ui-sans-serif,system-ui,-apple-system,sans-serif}.dark body{background:#09090b;color:#f4f4f5}.package-card{transition:transform .18s,border-color .18s,box-shadow .18s}.package-card:hover{transform:translateY(-2px)}[x-cloak]{display:none!important}</style>
@stack('head')
</head>
<body class="min-h-screen bg-stone-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
<header class="sticky top-0 z-40 border-b border-zinc-200/80 bg-white/90 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/90">
 <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
  <a href="{{ route('store') }}" class="flex items-center gap-3"><span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-400 text-xl font-black text-zinc-950">D</span><span><b class="block tracking-tight">Zoro <span class="text-amber-500">TOPUP</span></b><small class="hidden text-[10px] font-semibold tracking-[.18em] text-zinc-500 sm:block">PREMIUM GAME STORE</small></span></a>
  <nav class="hidden items-center gap-6 text-sm font-medium md:flex"><a class="hover:text-amber-500" href="{{ route('store') }}">Home</a><a class="hover:text-amber-500" href="#packages">Robux</a><a class="hover:text-amber-500" href="#how-it-works">How it works</a></nav>
  <div class="flex items-center gap-2"><button @click="dark=!dark;localStorage.setItem('donne-theme',dark?'dark':'light')" class="rounded-xl border border-zinc-200 p-2 dark:border-zinc-700" aria-label="Toggle theme"><span x-text="dark?'☀️':'🌙'"></span></button><button @click="menu=!menu" class="rounded-xl border border-zinc-200 p-2 md:hidden" aria-label="Open menu">☰</button><a href="#packages" class="hidden rounded-xl bg-amber-400 px-4 py-2 text-sm font-bold text-zinc-950 hover:bg-amber-300 sm:inline-flex">Top Up Now</a></div>
 </div>
 <div x-show="menu" x-cloak class="border-t border-zinc-200 px-4 py-3 md:hidden"><a href="#packages" class="block py-2">Robux Packages</a><a href="#how-it-works" class="block py-2">How it works</a></div>
</header>
<main>@if(session('success'))<div class="mx-auto mt-4 max-w-6xl px-4"><div class="rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">{{ session('success') }}</div></div>@endif
@if($errors->any())<div class="mx-auto mt-4 max-w-6xl px-4"><div class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div></div>@endif
@yield('content')</main>
<footer class="mt-16 border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950"><div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-8 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between"><p>© {{ date('Y') }} Zoro-TOPUP. Independent top-up store.</p><p>Never share your Roblox password.</p></div></footer>
<a href="https://t.me/+-dLW3L_dG_kwYTZl/" target="_blank" rel="noopener" class="fixed bottom-5 left-4 z-30 grid h-12 w-12 place-items-center rounded-full bg-amber-400 text-xl shadow-lg" aria-label="Support information">💬</a>
<button type="button" onclick="alert('Rewards will be available soon.')" class="fixed bottom-5 right-4 z-30 grid h-12 w-12 place-items-center rounded-full border border-amber-300 bg-white text-xl shadow-lg dark:bg-zinc-800" aria-label="Rewards">🎁</button>
</body></html>
