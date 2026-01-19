@props([
    'title' => null,
    'padding' => 'p-5 md:p-6',
])

<div {{ $attributes->merge(['class' => 'bg-white border border-zinc-200 rounded-xl shadow-sm flex flex-col']) }}>

    {{-- Cabeçalho Opcional --}}
    @if($title || isset($header))
        <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
            @if($title)
                <h3 class="font-semibold text-zinc-900">{{ $title }}</h3>
            @else
                {{ $header }}
            @endif
        </div>
    @endif

    {{-- Conteúdo Principal --}}
    <div class="{{ $padding }} flex-1">
        {{ $slot }}
    </div>

    {{-- Rodapé Opcional (Slots nomeados) --}}
    @if(isset($footer))
        <div class="px-6 py-4 bg-zinc-50 border-t border-zinc-100 rounded-b-xl flex justify-end gap-3 text-sm">
            {{ $footer }}
        </div>
    @endif
</div>
