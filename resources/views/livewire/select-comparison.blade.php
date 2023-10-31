<div class="p-6">
    <label>
        <select wire:model.live="selected" class="form-select mt-1 block w-full rounded max-h-60 overflow-auto">
            <option>Professor</option>
            <option>School</option>
        </select>
    </label>

    @if($selected === 'Professor')
        <div class="mt-4">
            @livewire('search-professor', ['searchType' => 'professor'])
            <div id="selectedProfessor"></div>
        </div>

    @else ($selected === 'School')
        <div class="mt-4">
            @livewire('search-professor', ['searchType' => 'school'])
        </div>
    @endif
</div>

