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
                        <div class="border-b sm:border-b-0 sm:border-r border-gray-200 p-4 flex flex-col justify-between">
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
                        <div class="border-b sm:border-b-0 sm:border-r border-gray-200 p-4 flex flex-col justify-between">
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
    </div>
</x-app-layout>
