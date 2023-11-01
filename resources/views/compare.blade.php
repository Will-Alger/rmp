<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hover:text-red-800">
            {{ __('RateMyProfessor 2.0') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center w-full">
        <div class="mt-20 w-1/3">
            @livewire('search', ['searchType' => 'professor'])
        </div>
    </div>
</x-app-layout>

<script>
    // document.addEventListener('selectProfessor', (event) => {
    //     let professor = event.detail;
    //     document.getElementById('selectedProfessor').innerHTML =
    //         `<div class="mt-5 p-6 w-full mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
    //         <div>
    //             <div class="text-xl font-medium text-black">Professor: ${professor.firstName} ${professor.lastName}</div>
    //             <p class="text-gray-500">School: ${professor.schoolName}</p>
    //             <p class="text-gray-500">Department: ${professor.department}</p>
    //             <p class="text-gray-500">Ratings: ${professor.numRatings}</p>
    //             <p class="text-gray-500">Average Rating: ${professor.avgRating}</p>
    //             <p class="text-gray-500">Would Take Again: ${professor.wouldTakeAgainPercent}%</p>
    //         </div>
    //     </div>`;
    // });
</script>
