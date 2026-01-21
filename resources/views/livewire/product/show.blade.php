<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Detalhes do Produto</h2>
        <a href="{{ route('admin.products.create', $product) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Editar Produto</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-1 space-y-6">

            <div
                x-data="{
                    images: @js($this->allImages),
                    activeImage: null,
                    isModalOpen: false,
                    currentIndex: 0,

                    init() {
                        // Define a primeira imagem como ativa ao carregar
                        if (this.images.length > 0) {
                            this.activeImage = this.images[0];
                        }
                    },

                    // Abre o modal na imagem que está sendo vista
                    openModal() {
                        if (this.images.length > 0) {
                            this.isModalOpen = true;
                            // Sincroniza o índice do modal com a imagem atual
                            this.currentIndex = this.images.indexOf(this.activeImage);
                        }
                    },

                    // Navegação do Carrossel
                    next() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                        this.activeImage = this.images[this.currentIndex]; // Opcional: atualiza a página de fundo também
                    },
                    prev() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                        this.activeImage = this.images[this.currentIndex];
                    }
                }"
                @keydown.escape.window="isModalOpen = false"
                @keydown.right.window="if(isModalOpen) next()"
                @keydown.left.window="if(isModalOpen) prev()"

                class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden"
            >

                <div class="h-80 w-full bg-gray-100 relative group flex items-center justify-center overflow-hidden cursor-zoom-in"
                     @click="openModal()"
                >
                    <template x-if="activeImage">
                        <img :src="activeImage" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                    </template>

                    <template x-if="!activeImage">
                        <div class="flex flex-col items-center text-gray-400">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Sem imagem</span>
                        </div>
                    </template>

                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center">
                        <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 drop-shadow-lg transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>

                <div class="px-6 pt-4 pb-2 flex gap-2 overflow-x-auto scrollbar-hide" x-show="images.length > 1">
                    <template x-for="(img, index) in images" :key="index">
                        <button
                            @click.stop="activeImage = img; currentIndex = index"
                            class="shrink-0 w-16 h-16 rounded border-2 overflow-hidden transition"
                            :class="activeImage === img ? 'border-indigo-600 ring-1 ring-indigo-600' : 'border-transparent hover:border-gray-300'"
                        >
                            <img :src="img" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
                    <p class="text-2xl font-semibold text-indigo-600 mt-2">{{ $product->formatted_price }}</p>
                </div>

                <div
                    x-show="isModalOpen"
                    style="display: none;"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
                >
                    <button @click="isModalOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-300 z-50 p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <button @click="prev()" class="absolute left-4 text-white hover:text-gray-300 z-50 p-2 bg-black/50 rounded-full hover:bg-black/80 transition" x-show="images.length > 1">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>

                    <div class="relative w-full h-full max-w-5xl max-h-screen p-4 flex flex-col items-center justify-center" @click.outside="isModalOpen = false">

                        <img :src="images[currentIndex]"
                             class="max-w-full max-h-[85vh] object-contain shadow-2xl rounded-sm select-none"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-50 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                        >

                        <div class="mt-4 text-white text-sm font-medium bg-black/50 px-3 py-1 rounded-full">
                            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                        </div>
                    </div>

                    <button @click="next()" class="absolute right-4 text-white hover:text-gray-300 z-50 p-2 bg-black/50 rounded-full hover:bg-black/80 transition" x-show="images.length > 1">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

            </div>

        </div>

        <div class="col-span-1 lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Vendas Totais</div>
                    <div class="text-2xl font-bold text-gray-900 mt-1">R$ 1.250,00</div>
                    <div class="text-xs text-green-600 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        +12% este mês
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Unidades Vendidas</div>
                    <div class="text-2xl font-bold text-gray-900 mt-1">48</div>
                </div>
{{--                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">--}}
{{--                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Conversão (Cliques)</div>--}}
{{--                    <div class="text-2xl font-bold text-gray-900 mt-1">3.2%</div>--}}
{{--                </div>--}}
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h4 class="font-bold text-gray-800 mb-6">Performance de Vendas (Últimos 30 dias)</h4>

                <div wire:ignore
                     x-data="productSalesChart(@js($chartData))"
                     class="w-full h-80"
                >
                    <div x-ref="chart" class="w-full h-full"></div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 uppercase">Últimos Pedidos com este item</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">Pedido #1045</td>
                        <td class="px-6 py-4 text-sm text-gray-600">João Silva</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Há 2 horas</td>
                        <td class="px-6 py-4 text-sm text-right font-medium text-green-600">Concluído</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">Pedido #1042</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Maria Souza</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Ontem</td>
                        <td class="px-6 py-4 text-sm text-right font-medium text-gray-500">Pendente</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productSalesChart', (data) => ({
                chart: null,

                init() {
                    // Garante que o elemento existe antes de renderizar
                    if (!this.$refs.chart) return;

                    let options = {
                        series: [{
                            name: 'Receita (R$)',
                            data: data.revenue // Dados vindos do PHP
                        }],
                        chart: {
                            type: 'area',
                            height: 320,
                            fontFamily: 'inherit',
                            toolbar: { show: false },
                            animations: { enabled: true }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            categories: data.dates, // Datas vindas do PHP
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (value) {
                                    return "R$ " + value.toFixed(0);
                                }
                            }
                        },
                        colors: ['#4f46e5'], // Indigo 600
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: { enabled: false },
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function (val) {
                                    return "R$ " + val.toFixed(2);
                                }
                            }
                        }
                    };

                    this.chart = new ApexCharts(this.$refs.chart, options);
                    this.chart.render();
                }
            }));
        });
    </script>
@endpush
