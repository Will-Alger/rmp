<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-transparent">
                    <h2 class="text-2xl font-bold mb-4 text-white">Cumulative averages for top 6 rated schools in Kentucky in 2023</h2>
                    <div class="flex flex-wrap -m-4">
                        @foreach ($universityAverageCharts as $schoolName => $universityChart)
                            <div class="p-4 lg:w-1/3 md:w-1/2 sm:w-full">
                                <div class="h-[30vh] p-6 bg-background-primary rounded shadow">
                                    <h3 class="text-lg font-medium title-font mb-4 text-white">{{ $schoolName }}</h3>
                                    {!! $universityChart->container() !!}
                                </div>
                                {!! $universityChart->script() !!}
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-20">
                        <h2 class="text-2xl font-bold mb-4 text-white">Averages for Computer Science Department</h2>
                        <div class="flex flex-wrap -m-4">
                            @foreach ($departmentAverageCharts as $departmentName => $departmentChart)
                                <div class="p-4 lg:w-1/3 md:w-1/2 sm:w-full">
                                    <div class="h-[30vh] p-4 bg-background-primary rounded shadow">
                                        <h3 class="text-lg font-medium title-font mb-4 text-white">{{ $departmentName }}</h3>
                                        {!! $departmentChart->container() !!}
                                    </div>
                                    {!! $departmentChart->script() !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
