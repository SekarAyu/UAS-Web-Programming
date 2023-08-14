<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Barang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Harga Beli
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Harga Jual
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Stok Terjual
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Pendapatan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Keuntungan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stok_laku=[];
                                    $untung=[];
                                @endphp
                                @foreach ($barang as $item)
                                @php
                                $total_penjualan = $item->harga_jual * $item->jumlah_transaksi;
                                $keuntungan = ($item->harga_jual - $item->harga_beli)* $item->jumlah_transaksi;
                                $stok_laku[$item->nama_barang]= $item->jumlah_transaksi;
                                $untung[$item->nama_barang]=$keuntungan;
                                @endphp
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item->nama_barang}}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$item->harga_beli}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$item->harga_jual}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$item->jumlah_transaksi}}
                                    </td>
                                    <td class="px-6 py-4">
                                        RP. {{$total_penjualan}}
                                    </td>
                                    <td class="px-6 py-4">
                                        RP. {{$keuntungan}}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-10">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="relative overflow-x-auto flex">
                                    <div class="mx-auto w-3/5 overflow-hidden w-3/6">
                                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                            {{ __('Stok Terjual') }}
                                        </h2>
                                        <canvas id="doughnut-chart"></canvas>
                                    </div>
                                    <div class="mx-auto w-3/5 overflow-hidden w-3/6">
                                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                            {{ __('Keuntungan') }}
                                        </h2>
                                        <canvas id="chart-keuntungan"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="
    ./tw.js
    "></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
        const stok_laku =    {!! json_encode($stok_laku)!!}
            // Chart
            const dataDoughnut = {
                type: 'doughnut',
                data: {
                    labels: Object.keys(stok_laku),
                    datasets: [{
                        label: 'Traffic',
                        data: Object.values(stok_laku).map((i) => Number(i)),
                        backgroundColor: [
                            ...Object.values(stok_laku).map(() =>`rgb(${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}`),
                        ],
                    }, ],
                },
            };

            new te.Chart(document.getElementById('doughnut-chart'), dataDoughnut);
            const untung =    {!! json_encode($untung)!!}
                // Chart
                const dataKeuntungan = {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(untung),
                        datasets: [{
                            label: 'Traffic',
                            data: Object.values(untung).map((i) => Number(i)),
                            backgroundColor: [
                                ...Object.values(untung).map(() =>`rgb(${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}, ${Math.floor(Math.random()*256)}`),
                            ],
                        }, ],
                    },
                };
    
                new te.Chart(document.getElementById('chart-keuntungan'), dataKeuntungan);
        });

    </script>
</x-app-layout>
