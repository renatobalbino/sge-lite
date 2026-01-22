<div class="p-4">
    @if(isset($header))
        {{ $header }}
    @endif

    @if(isset($body))
        <div class="mt-4 p-4 bg-white border border-gray-200 rounded-lg shadow">
            {{ $body }}
        </div>
    @endif
</div>
