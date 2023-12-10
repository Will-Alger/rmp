<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-transparent">
                    <h2 class="text-2xl font-bold mb-4 text-white">Cumulative averages for top 6 rated schools in Kentucky in 2023</h2>
                    <div class="flex flex-wrap -m-4">
                            <div class="p-4 lg:w-full md:w-full sm:w-full">
                                <div class="h-[30vh] p-6 bg-background-primary rounded shadow">
                                    {{-- <h3 class="text-lg font-medium title-font mb-4 text-white">{{ $schoolName }}</h3> --}}
                                    {!! $schoolAverages->container() !!}
                                </div>
                                {!! $schoolAverages->script() !!}
                            </div>
                    </div>
                    <div class="mt-10">
                        <div class="flex flex-wrap -m-4">
                            <div class="p-4 lg:w-1/2 md:w-1/2 sm:w-full">
                                <div class="h-[30vh] p-4 bg-background-primary rounded shadow">
                                    {!! $computerScienceAverages->container() !!}
                                </div>
                                {!! $computerScienceAverages->script() !!}
                            </div>
                            <div class="p-4 lg:w-1/2 md:w-1/2 sm:w-full">
                                <div class="h-[30vh] p-4 bg-background-primary rounded shadow">
                                    {!! $englishAverages->container() !!}
                                </div>
                                {!! $englishAverages->script() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
