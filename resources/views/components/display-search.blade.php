<div
        x-show="open"
        class="w-full absolute z-10 mt-2 bg-white rounded-md shadow-lg max-h-60 overflow-auto"
>
    <ul class="w-full space-y-1">
        @foreach($results as $item)
            <li
                    x-data="{item: {{$item}}}"
                    @click="$dispatch('select', item); selected = '{{ $searchType === 'professor' ? $item->firstName . ' ' . $item->lastName : $item->schoolName }}'; open = false"
                    class="w-full px-3 py-2 hover:bg-gray-200 cursor-pointer"
            >
                <div class="flex items-center">
                    <div>{{ $searchType === 'professor' ? $item->firstName . ' ' . $item->lastName : $item->schoolName }}</div>
                    <div class="flex-grow"></div>
                    <div>
                        <span class="inline-block bg-electric-violet text-white px-2 py-1 rounded text-sm"> {{ $item->numRatings }} Ratings</span>
                        @if ($searchType === 'professor')
                            <span class="inline-block bg-electric-violet text-white px-2 py-1 rounded text-sm ml-2">{{ $item->schoolName }}</span>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
