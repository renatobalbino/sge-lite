<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Detalhes do Produto</h2>
        <a href="{{ route('admin.products.create', $product) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Editar Produto</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden"
                 x-data="{
            activeImage: '{{ $product->image_path ? Storage::url($product->image_path) : '' }}'
         }"
            >
                <div class="h-80 w-full bg-gray-100 relative group flex items-center justify-center overflow-hidden">

                    @if($product->image_path)
                        <img :src="activeImage" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="flex flex-col items-center text-gray-400">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Sem imagem</span>
                        </div>
                    @endif

                    <div class="absolute top-3 right-3">
                 <span class="px-2 py-1 text-xs font-bold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->is_active ? 'ATIVO' : 'PAUSADO' }}
                </span>
                    </div>
                </div>

                @if($product->image_path || $product->images->count() > 0)
                    <div class="px-6 pt-4 pb-2 flex gap-2 overflow-x-auto scrollbar-hide">

                        @if($product->image_path)
                            <button
                                @click="activeImage = '{{ Storage::url($product->image_path) }}'"
                                class="shrink-0 w-16 h-16 rounded border-2 overflow-hidden transition"
                                :class="activeImage === '{{ Storage::url($product->image_path) }}' ? 'border-indigo-600 ring-1 ring-indigo-600' : 'border-transparent hover:border-gray-300'"
                            >
                                <img src="{{ Storage::url($product->image_path) }}" class="w-full h-full object-cover">
                            </button>
                        @endif

                        @foreach($product->images as $img)
                            <button
                                @click="activeImage = '{{ Storage::url($img->image_path) }}'"
                                class="shrink-0 w-16 h-16 rounded border-2 overflow-hidden transition"
                                :class="activeImage === '{{ Storage::url($img->image_path) }}' ? 'border-indigo-600 ring-1 ring-indigo-600' : 'border-transparent hover:border-gray-300'"
                            >
                                <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach

                    </div>
                @endif

                <div class="p-6">
                    <h3 class="font-bold text-gray-900 leading-tight">{{ $product->name ?? 'Product not found' }}</h3>
                    <p class="font-semibold text-indigo-600 mt-2">{{ $product->formatted_price }}</p>

                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Descrição</h4>
                        <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            @if($product->has_variants)
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Estoque por Variação
                    </h4>
                    <div class="space-y-3">
                        @foreach($product->variants as $variant)
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2 last:border-0 hover:bg-gray-50 px-2 rounded transition">
                                <span class="text-sm font-medium text-gray-700">{{ $variant->name }}</span>
                                <div class="text-sm">
                                    @if($variant->stock_quantity > 10)
                                        <span class="text-green-600 font-bold bg-green-50 px-2 py-1 rounded-full text-xs">{{ $variant->stock_quantity }} unid.</span>
                                    @elseif($variant->stock_quantity > 0)
                                        <span class="text-orange-600 font-bold bg-orange-50 px-2 py-1 rounded-full text-xs">Restam {{ $variant->stock_quantity }}</span>
                                    @else
                                        <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded-full text-xs">Esgotado</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <div class="col-span-1 lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Conversão (Cliques)</div>
                    <div class="text-2xl font-bold text-gray-900 mt-1">3.2%</div>
                </div>
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
