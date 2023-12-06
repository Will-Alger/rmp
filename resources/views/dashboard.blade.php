<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="p-4 rounded shadow-lg flex">
                        <div class="w-1/2 h-[40vh] max-w-2xl p-4 bg-white rounded shadow">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                    {!! $chart->script() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
