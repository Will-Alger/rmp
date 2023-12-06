<div class="p-6">
    <label>
        <select wire:model.live="selected" class="form-select mt-1 block w-full rounded max-h-60 overflow-auto">
            <option>Professor</option>
            <option>School</option>
        </select>
    </label>
    <div class="mt-4">
        @if($selected === 'Professor')
            <div id="selectedProfessor"></div>
        @endif
    </div>
</div>
