<div>
    <div x-data="{ open: false, selected: '' }" class="relative">
        <label>
            <input
                wire:model.debounce.500ms.live="search"
                x-ref="input"
                x-model="selected"
                @click="open = true"
                class="form-input mt-1 block w-full rounded max-h-60 overflow-auto"
                placeholder="Search by name or id..."
            >
        </label>
        <div
            x-show="open"
            class="absolute z-10 mt-2 w-full bg-white rounded-md shadow-lg max-h-60 overflow-auto"
        >
            <ul class="space-y-1">
                @foreach($professors as $p)
                    <li
                        x-data="{
                            professor: {{$p}}
                        }"
                        @click="$dispatch('selectProfessor', professor); selected = '{{ $p->firstName . ' ' . $p->lastName }}'; open = false"
                        class="px-3 py-2 hover:bg-gray-200 cursor-pointer"
                    >
                        <div>
                            {{ $p->firstName . ' ' . $p->lastName }}
                            <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded text-sm"> {{ $p->numRatings }} Ratings</span>
                            <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded text-sm ml-2">{{ $p->schoolName }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
