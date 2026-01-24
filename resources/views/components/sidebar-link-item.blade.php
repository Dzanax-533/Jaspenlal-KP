@props(['href' => '#', 'icon' => '✨'])

@php
    // Logika untuk menentukan apakah menu ini sedang aktif atau tidak
    $active = ($href !== '#' && (request()->fullUrlIs($href) || request()->url() == $href));

    $classes = ($active)
                ? 'flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-sm transition-all bg-indigo-600 text-white shadow-lg shadow-indigo-100'
                : 'flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-sm transition-all text-slate-500 hover:bg-slate-50 hover:text-indigo-600 group';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <span class="flex items-center justify-center w-6 h-6 text-lg transition-transform group-hover:scale-110">
        {{ $icon }}
    </span>

    <span class="truncate tracking-tight">
        {{ $slot }}
    </span>

    @if($active)
        <div class="ml-auto w-1.5 h-1.5 bg-white rounded-full shadow-sm"></div>
    @endif
</a>
