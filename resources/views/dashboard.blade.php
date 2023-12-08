<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap -m-4">

                        @foreach ($charts as $schoolName => $chart)
                            <div class="p-4 lg:w-1/3 md:w-1/2 sm:w-full">
                                <div class="h-[30vh] p-4 bg-white rounded shadow">
                                    <h3 class="text-lg font-medium title-font mb-4">{{ $schoolName }}</h3>
                                    {!! $chart->container() !!}
                                </div>
                                {!! $chart->script() !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
