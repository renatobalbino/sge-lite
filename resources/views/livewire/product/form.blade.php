<x-ui.page>
    <x-slot:header>
        <x-ui.page-header
            title="Cadastrar Produto"

        >
            <x-slot:actions>
                <x-ui.button variant="secondary" icon="arrow-left" href="{{ url()->previous() }}">Cancelar</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>
    </x-slot:header>

    <x-slot:body>
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="col-span-2">
                    <x-ui.input label="Título" wire:model="name" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-1">
                    <x-ui.input type="number" label="Preço Base (R$)" step="0.01" wire:model="price" />
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-3">
                    <x-ui.input :type="'textarea'" label="Descrição" wire:model="description" rows="4" />
                </div>
            </div>

            <div class="flex col-span-2 flex items-center mt-6" x-data>
                <input type="checkbox" wire:model.live="hasVariants" id="has_variants" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="has_variants" class="ml-2 block text-sm text-gray-900">
                    Este produto possui variações (Cor, Tamanho)?
                </label>
            </div>

            @if($hasVariants)
                <div class="mt-3 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <button type="button" wire:click="addVariant" class="text-sm bg-indigo-50 text-indigo-700 px-3 py-1 rounded hover:bg-indigo-100 transition">
                            + Adicionar Variação
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach($variants as $index => $variant)
                            <div class="flex gap-4 items-center bg-gray-50 p-3 rounded border border-gray-200" wire:key="variant-{{ $index }}">
                                <div class="flex-1">
                                    <x-ui.input label="Variação (Ex: G / Azul)" wire:model="variants.{{ $index }}.name" />
                                    @error('variants.'.$index.'.name') <span class="text-red-500 text-xs">Obrigatório</span> @enderror
                                </div>

                                <div class="w-32">
                                    <x-ui.input :type="'number'" step="0.01" label="Preço (Opcional)" placeholder="Manter preço base" wire:model="variants.{{ $index }}.price" />
                                </div>

                                <div class="w-24">
                                    <x-ui.input :type="'number'" wire:model="variants.{{ $index }}.stock_quantity" label="Estoque" placeholder="Manter preço base" />
                                    @error('variants.'.$index.'.stock_quantity') <span class="text-red-500 text-xs">Obrigatório</span> @enderror
                                </div>

                                <div class="mt-6">
                                    <button type="button" wire:click="removeVariant({{ $index }})" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <hr class="my-6 border-gray-200">

            <h3 class="mb-4 text-lg font-medium text-gray-900">Imagens do produto</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-gray-700">Imagem de Capa (Principal)</label>

                    @if ($coverImage || $existingCoverImage)
                        <div class="relative group rounded-lg border border-gray-200 overflow-hidden shadow-sm w-full h-64 bg-gray-50">

                            <img src="{{ $coverImage ? $coverImage->temporaryUrl() : Storage::url($existingCoverImage) }}"
                                 class="w-full h-full object-contain">

                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button type="button" wire:click="removeCover" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium shadow-lg flex items-center gap-2 transform hover:scale-105 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Remover Capa
                                </button>
                            </div>

                            <div wire:loading.flex wire:target="removeCover" class="absolute inset-0 bg-white/80 items-center justify-center">
                                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </div>

                    @else
                        <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clique para enviar</span> a capa</p>
                                <p class="text-xs text-gray-500">PNG, JPG ou WEBP (Max 2MB)</p>
                            </div>
                            <input type="file" wire:model="coverImage" class="hidden" accept="image/*">

                            <div wire:loading.flex wire:target="coverImage" class="absolute inset-0 bg-white/90 items-center justify-center z-10">
                                <div class="text-indigo-600 font-semibold animate-pulse">Carregando...</div>
                            </div>
                        </label>
                    @endif
                    @error('coverImage') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-bold text-gray-700">Galeria de Fotos</label>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                    {{ count($existingGallery) + count($galleryImages) }} imagens
                </span>
                    </div>

                    <div class="grid grid-cols-3 gap-3">

                        <label class="aspect-square border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition text-gray-400 hover:text-indigo-600 relative">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-xs mt-1 font-medium">Adicionar</span>

                            <input type="file" wire:model="galleryImages" multiple class="hidden" accept="image/*">

                            <div wire:loading.flex wire:target="galleryImages" class="absolute inset-0 bg-white items-center justify-center opacity-90 rounded-lg">
                                <svg class="animate-spin h-6 w-6 text-indigo-600" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </label>

                        @foreach($existingGallery as $img)
                            <div class="relative group aspect-square rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm">
                                <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">

                                <button type="button"
                                        wire:confirm="Tem certeza que deseja apagar esta foto permanentemente?"
                                        wire:click="removeGalleryImage({{ $img->id }})"
                                        class="absolute top-1 right-1 bg-white text-red-600 p-1.5 rounded-full shadow-sm hover:bg-red-50 opacity-0 group-hover:opacity-100 transition focus:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <span class="absolute bottom-1 left-1 bg-gray-900/50 text-white text-[10px] px-1.5 py-0.5 rounded backdrop-blur-sm">Salvo</span>
                            </div>
                        @endforeach

                        @foreach($galleryImages as $index => $tempImg)
                            <div class="relative group aspect-square rounded-lg overflow-hidden border border-indigo-200 bg-indigo-50 shadow-sm" wire:key="temp-gallery-{{ $index }}">
                                <img src="{{ $tempImg->temporaryUrl() }}" class="w-full h-full object-cover opacity-90">

                                <button type="button"
                                        wire:click="removeTempGalleryImage({{ $index }})"
                                        class="absolute top-1 right-1 bg-white text-red-600 p-1.5 rounded-full shadow-sm hover:bg-red-50 opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                <span class="absolute bottom-1 left-1 bg-indigo-600 text-white text-[10px] px-1.5 py-0.5 rounded shadow">Novo</span>
                            </div>
                        @endforeach
                    </div>

                    @error('galleryImages.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('galleryImages') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <x-divider />

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors disabled:opacity-50">
                    <span wire:loading.remove>Salvar Produto</span>
                    <span wire:loading>Salvando...</span>
                </button>
            </div>
        </form>
    </x-slot:body>
</x-ui.page>
