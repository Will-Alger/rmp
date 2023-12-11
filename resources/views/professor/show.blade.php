<x-app-layout>
    <div class="container mx-auto m-4 w-full lg:w-3/4 max-w-5xl">
        <div class="shadow rounded-lg overflow-hidden bg-background-primary shadow-2xl mt-10">
            <!-- Profile Header -->
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-2xl leading-6 font-bold text-white">
                    {{ $professor->firstName }} {{ $professor->lastName }}
                </h2>
                <p class="mt-1 text-base text-gray-500">
                    {{ $professor->schoolName }} | Department: {{ $professor->department }}
                </p>
            </div>

            @php
                 $metrics = [
                    [
                        'title' => 'Average Rating',
                        'value' => $professor->avgQualityRating(),
                        'max' => 5,
                        'background' => 'bg-accent-primary'
                    ],
                    [
                        'title' => 'Average Difficulty',
                        'value' => $professor->avgDifficultyRating(),
                        'max' => 5,
                        'background' => 'bg-electric-violet'
                    ],
                    [
                        'title' => 'Would Take Again',
                        'value' => $professor->avgWouldTakeAgain(),
                        'max' => 100,
                        'background' => 'bg-accent-secondary'
                    ]
                ];
            @endphp

            <div class="border-t border-background-secondary">
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($metrics as $metric)
                            <div class="border-b sm:border-b-0 sm:border-r border-background-secondary p-4 flex flex-col justify-between">
                                <dt class="text-sm font-medium text-gray-500">
                                    {{ $metric['title'] }}
                                </dt>
                                <dd class="mt-1">
                                    <div class="bg-background-secondary rounded h-6 w-full overflow-hidden">
                                        <div class="{{ $metric['background'] }} rounded h-6 flex justify-center items-center"
                                             style="width: {{ $metric['value'] / $metric['max'] * 100 }}%;">
                                            <span class="text-xs font-medium text-white">
                                                {{ $metric['value'] }}{{ $metric['max'] === 5 ? ' / 5' : '%' }}
                                            </span>
                                        </div>
                                    </div>
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>

            {{-- Professor chart --}}


            <div class="flex flex-wrap p-4 rounded">
                <div class="{{$departmentTrend ? 'md:w-1/2 lg:w-1/2' : 'md:w-full lg:w-full'}} sm:w-full p-4 secondary rounded">
                    <h3 class="text-xl text-center font-medium title-font mb-4 text-white">Professor Rating History</h3>
                    <div class="h-[45vh]">
                        {!! $chart->container() !!}
                    </div>
                    {!! $chart->script() !!}
                </div>
                @if ($departmentTrend)
                    <div class="md:w-1/2 lg:w-1/2 sm:w-full p-4 secondary rounded">
                        <h3 class="text-xl text-center font-medium title-font mb-4 text-white">{{$professor->department}} Department Trend</h3>
                        <div class="h-[45vh]">
                            {!! $departmentTrend->container() !!}
                        </div>
                        {!! $departmentTrend->script() !!}
                    </div>
                @else
                    <div class="chart-container" style="position: relative; height:10vh; width:80vw">
                        <div class="flex justify-center items-center h-full">
                            <span class="text-lg font-medium text-gray-500">
                                Sorry, not enough data to display department trend.
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8">
            <h3 class="text-xl leading-6 font-bold text-white">
                Reviews
            </h3>
            @forelse ($reviews as $review)
                <div class="bg-background-primary shadow-2xl rounded-lg overflow-hidden my-10">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">

                            <h4 class="text-lg font-bold text-gray-800">
                                @if ($review->class)
                                Class: {{ $review->class }}
                                @endif
                            </h4>

                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($review->date)->format('Y-m-d') }}
                        </p>
                    </div>

                    {{-- Quality Ratings --}}
                    <div class="px-4 sm:px-6">
                        <div class="flex items-end space-x-4 my-2">
                            <!-- Quality Rating Bar -->
                            <div class="text-center">
                                <div class="bg-background-secondary w-8 h-16 rounded relative">
                                    <div class="bg-accent-primary w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->qualityRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->qualityRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-500 mt-1">Quality</div>
                            </div>

                            <!-- Clarity Rating Bar -->
                            <div class="text-center">
                                <div class="bg-background-secondary w-8 h-16 rounded relative">
                                    <div class="bg-accent-primary w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->clarityRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->clarityRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-500 mt-1">Clarity</div>
                            </div>

                            <!-- Difficulty Rating Bar -->
                            <div class="text-center">
                                <div class="bg-background-secondary w-8 h-16 rounded relative">
                                    <div class="bg-accent-primary w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->difficultyRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->difficultyRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-500 mt-1">Difficulty</div>
                            </div>

                            <!-- Helpful Rating Bar -->
                            <div class="text-center">
                                <div class="bg-background-secondary w-8 h-16 rounded relative">
                                    <div class="bg-accent-primary w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->helpfulRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->helpfulRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-500 mt-1">Helpfulness</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-300 mb-3 p-4">{{ $review->comment }}</p>
                        @if (!empty($review->ratingTags))
                            <div class="flex flex-wrap gap-2 mb-2">
                                @foreach(explode('--', $review->ratingTags) as $tag)
                                    <span
                                        class="bg-background-secondary shadow-l text-electric-violet text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-4">
                            <div>
                                <span
                                    class="text-sm font-medium text-gray-500">For Credit: {{ $review->isForCredit ? 'Yes' : 'No' }}</span>
                                <span
                                    class="text-sm font-medium text-gray-500 ml-4">Would Take Again: {{ $review->wouldTakeAgain ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="mr-2">👍 {{ $review->thumbsUpTotal }}</span>
                                <span>👎 {{ $review->thumbsDownTotal }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-700">No reviews available.</p>
            @endforelse
            {{ $reviews->links() }}
        </div>


    </div>
</x-app-layout>
