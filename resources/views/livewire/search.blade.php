<div>
    <div x-data="{ open: false, selected: '' }" class="relative">
        <label>
            <span class="text-lg font-semibold text-gray-300 shadow-lg"><p class="drop-shadow">Searching for {{$searchType}}s</p></span>
            <input
                    wire:model.debounce.500ms.live="search"
                    x-ref="input"
                    x-model="selected"
                    @click="open = true"
                    class=" w-full form-input mt-1 block rounded max-h-60 overflow-auto shadow-lg"
                    placeholder="{{ 'Search by ' . $searchType . ' name'}}"
            >
        </label>
{{--
        <div>
            <label class="inline-flex items-center mr-3 text-gray-300">
                <input type="radio" class="form-radio" name="searchType" value="professor" wire:model.live="searchType">
                <span class="ml-2">Professor</span>
            </label>

            <label class="inline-flex items-center text-gray-300">
                <input type="radio" class="form-radio" name="searchType" value="school" wire:model.live="searchType">
                <span class="ml-2">School</span>
            </label>
        </div> --}}

        {{-- Display the search results --}}
        <div
                x-show="open"
                class="w-full absolute z-10 mt-2 bg-white rounded-md shadow-lg max-h-60 overflow-auto"
        >
            <ul class="w-full space-y-1">
                @foreach($results as $item)
                    <li
                            x-data="{item: {{$item}}}"
                            wire:click="handleSelection(item.id)"
                            @click="
                                open = false;
                                selected = '{{ $searchType === 'professor' ? $item->firstName . ' ' . $item->lastName : $item->name }}';

                             "
                            class="w-full px-3 py-2 hover:bg-gray-200 cursor-pointer"
                    >
                        <div class="flex items-center">
                            <div>{{ $searchType === 'professor' ? $item->firstName . ' ' . $item->lastName : $item->name }}</div>
                            <div class="flex-grow"></div>
                            <div>
                                @if ($searchType === 'professor')
                                    <span class="inline-block bg-accent-primary text-white px-2 py-1 rounded text-sm ml-2">{{ $item->schoolName }}</span>
                                @else
                                    <span class="inline-block bg-accent-primary text-white px-2 py-1 rounded text-sm"> {{ $item->numRatings }} Ratings</span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
