<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 p-4">

    <div class="max-w-sm" style="position: sticky; top: 0; width: 30%;">
        <label class="block mb-4">
            <input wire:model.live="search" type="search" placeholder="Search schools..."
                   class="mt-1 block w-full rounded-md bg-white shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
        </label>
    </div>

    <div class="h-full max-w-sm" style="width: 30%;">
        <div class="bg-white shadow rounded w-full max-w-sm overflow-y-auto" style="max-height: 300px;">
            <ul class="p-4">
                @foreach($schools as $s)
                    <li class="border-b py-2">{{ $s->name . ' ' . $s->numRatings }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
