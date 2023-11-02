<x-app-layout>
    <div class="container mx-auto p-4 w-3/4">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Profile Header -->
            <div class="bg-white px-4 py-5 sm:px-6">
                <h2 class="text-xl leading-6 font-bold">
                    {{ $professor->firstName }} {{ $professor->lastName }}
                </h2>
                <h4 class="text-sm leading-6 font-medium text-gray-500">
                    {{ $professor->schoolName }}
                    <p class="mt-1 text-sm">{{ 'Department: ' . $professor->department }}</p>
                </h4>
            </div>

            <!-- Profile Body -->
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <!-- Average Rating -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                            <dt class="text-sm font-medium text-gray-500">
                                Average Rating
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                                <div class="w-1/4 bg-gray-200 rounded">
                                    <div class="bg-electric-violet text-xs font-medium text-blue-100 text-center p-1 leading-none rounded"
                                         style="width: {{ $professor->avgRating / 5 * 100 }}%; height: 20px;"></div>
                                </div>
                                <div class="text-sm font-medium text-gray-600 mt-2">
                                    {{ number_format($professor->avgRating, 1) }} / 5
                                </div>
                            </dd>

                            <dt class="text-sm font-medium text-gray-500">
                                Average Difficulty
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                                <div class="w-1/4 bg-gray-200 rounded">
                                    <div class="bg-electric-violet text-xs font-medium text-blue-100 text-center p-1 leading-none rounded"
                                         style="width: {{ $professor->avgDifficulty / 5 * 100 }}%; height: 20px;"></div>
                                </div>
                                <div class="text-sm font-medium text-gray-600 mt-2">
                                    {{ number_format($professor->avgDifficulty, 1) }} / 5
                                </div>
                            </dd>

                            <dt class="text-sm font-medium text-gray-500">
                                Would Take Again
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                                <div class="w-1/4 bg-gray-200 rounded">
                                    <div class="bg-electric-violet text-xs font-medium text-blue-100 text-center p-1 leading-none rounded"
                                         style="width: {{ $professor->wouldTakeAgainPercent }}%; height: 20px;"></div>
                                </div>
                                <div class="text-sm font-medium text-gray-600 mt-2">
                                    {{ number_format($professor->wouldTakeAgainPercent, 0) }}%
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
