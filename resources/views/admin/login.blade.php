@extends('layouts.app')
@section('title','Admin Login')
@section('content')
<div class="mx-auto max-w-md px-4 py-16"><form method="POST" action="{{ route('admin.login.submit') }}" class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">@csrf<h1 class="text-2xl font-black">Admin sign in</h1><p class="mt-2 text-sm text-zinc-500">Authorized staff only.</p><label class="mt-5 block text-sm font-semibold">Email</label><input name="email" type="email" required class="mt-2 w-full rounded-xl border border-zinc-300 bg-transparent px-4 py-3 dark:border-zinc-700"><label class="mt-4 block text-sm font-semibold">Password</label><input name="password" type="password" required class="mt-2 w-full rounded-xl border border-zinc-300 bg-transparent px-4 py-3 dark:border-zinc-700"><button class="mt-5 w-full rounded-xl bg-amber-400 px-4 py-3 font-bold text-zinc-950">Sign in</button></form></div>
@endsection
