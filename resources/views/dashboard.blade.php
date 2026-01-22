<x-layouts::sge>
    <x-ui.page>
        <x-slot:header>
            <x-ui.page-header
                title="Dashboard"
            >
                <x-slot:actions>

                </x-slot:actions>
            </x-ui.page-header>
        </x-slot:header>

        <x-slot:body>
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    </div>
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    </div>
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                        <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    </div>
                </div>
                <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                </div>
            </div>
        </x-slot:body>
    </x-ui.page>
</x-layouts::sge>
