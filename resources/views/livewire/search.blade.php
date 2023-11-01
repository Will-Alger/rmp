<div>
    <div x-data="{ open: false, selected: '' }" class="relative">
        <label>
            <input
                    wire:model.debounce.500ms.live="search"
                    x-ref="input"
                    x-model="selected"
                    @click="open = true"
                    class=" w-full form-input mt-1 block rounded max-h-60 overflow-auto"
                    placeholder="Search by name or id..."
            >
        </label>
        <div class="">
            @component('components.display-search', ['searchType' => $searchType, 'results' => $results])
            @endcomponent
        </div>
    </div>
</div>
