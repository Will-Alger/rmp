<x-app-layout>
    <div class="container mx-auto p-4 w-full lg:w-3/4">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Profile Header -->
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <h2 class="text-2xl leading-6 font-bold text-gray-900">
                    {{ $professor->firstName }} {{ $professor->lastName }}
                </h2>
                <p class="mt-1 text-base text-gray-500">
                    {{ $professor->schoolName }} | Department: {{ $professor->department }}
                </p>
            </div>

            <!-- Profile Body -->
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Average Rating -->
                        <div
                            class="border-b sm:border-b-0 sm:border-r border-gray-200 p-4 flex flex-col justify-between">
                            <dt class="text-sm font-medium text-gray-500">
                                Average Rating
                            </dt>
                            <dd class="mt-1">
                                <div class="bg-gray-200 rounded h-6 w-full overflow-hidden">
                                    <div class="bg-electric-violet rounded h-6 flex justify-center items-center"
                                         style="width: {{ $professor->avgRating / 5 * 100 }}%;">
                                        <span class="text-xs font-medium text-white">
                                            {{ number_format($professor->avgRating, 1) }} / 5
                                        </span>
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <!-- Average Difficulty -->
                        <div
                            class="border-b sm:border-b-0 sm:border-r border-gray-200 p-4 flex flex-col justify-between">
                            <dt class="text-sm font-medium text-gray-500">
                                Average Difficulty
                            </dt>
                            <dd class="mt-1">
                                <div class="bg-gray-200 rounded h-6 w-full overflow-hidden">
                                    <div class="bg-electric-violet rounded h-6 flex justify-center items-center"
                                         style="width: {{ $professor->avgDifficulty / 5 * 100 }}%;">
                                        <span class="text-xs font-medium text-white">
                                            {{ number_format($professor->avgDifficulty, 1) }} / 5
                                        </span>
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <!-- Would Take Again -->
                        <div class="p-4 flex flex-col justify-between">
                            <dt class="text-sm font-medium text-gray-500">
                                Would Take Again
                            </dt>
                            <dd class="mt-1">
                                <div class="bg-gray-200 rounded h-6 w-full overflow-hidden">
                                    <div class="bg-electric-violet rounded h-6 flex justify-center items-center"
                                         style="width: {{ $professor->wouldTakeAgainPercent }}%;">
                                        <span class="text-xs font-medium text-white">
                                            {{ number_format($professor->wouldTakeAgainPercent, 0) }}%
                                        </span>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8">
            <h3 class="text-xl leading-6 font-bold text-gray-900">
                Reviews
            </h3>
            @forelse ($professor->reviews as $review)
                <div class="bg-white shadow rounded-lg overflow-hidden my-4">

                    <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                        <h4 class="text-lg font-bold text-gray-800">
                            Class: {{ $review->class }}
                        </h4>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($review->date)->format('Y-m-d') }}
                        </p>
                    </div>
                    
                    {{-- Quality Ratings --}}
                    <div class="px-4 sm:px-6">
                        <div class="flex items-end space-x-4 my-2">
                            <!-- Clarity Rating Bar -->
                            <div class="text-center">
                                <div class="bg-gray-200 w-8 h-16 rounded relative">
                                    <div class="bg-electric-violet w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->clarityRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->clarityRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-700 mt-1">Clarity</div>
                            </div>

                            <!-- Difficulty Rating Bar -->
                            <div class="text-center">
                                <div class="bg-gray-200 w-8 h-16 rounded relative">
                                    <div class="bg-electric-violet w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->difficultyRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->difficultyRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-700 mt-1">Difficulty</div>
                            </div>

                            <!-- Helpful Rating Bar -->
                            <div class="text-center">
                                <div class="bg-gray-200 w-8 h-16 rounded relative">
                                    <div class="bg-electric-violet w-full rounded absolute bottom-0"
                                         style="height: {{ ($review->helpfulRating / 5) * 100 }}%">
                                        <span class="text-white text-xs">{{ $review->helpfulRating }}</span>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-700 mt-1">Helpfulness</div>
                            </div>
                        </div>
                    </div>


                    <div class="border-t border-gray-200 p-4">
                        <p class="text-gray-700 mb-3 p-4">{{ $review->comment }}</p>
                        @if (!empty($review->ratingTags))
                            <div class="flex flex-wrap gap-2 mb-2">
                                @foreach(explode('--', $review->ratingTags) as $tag)
                                    <span
                                        class="bg-blue-100 text-electric-violet text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-4">
                            <div>
                                <span
                                    class="text-sm font-medium text-gray-700">For Credit: {{ $review->isForCredit ? 'Yes' : 'No' }}</span>
                                <span
                                    class="text-sm font-medium text-gray-700 ml-4">Would Take Again: {{ $review->wouldTakeAgain ? 'Yes' : 'No' }}</span>
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
        </div>


    </div>
</x-app-layout>
