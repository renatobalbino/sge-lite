@props([
    'title',
    'description' => null,
])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">

    {{-- Lado Esquerdo: Títulos --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900">
            {{ $title }}
        </h1>
        @if($description)
            <p class="mt-1 text-sm text-zinc-500">
                {{ $description }}
            </p>
        @endif
    </div>

    {{-- Lado Direito: Ações (Botões) --}}
    @if(isset($actions))
        <div class="flex items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
