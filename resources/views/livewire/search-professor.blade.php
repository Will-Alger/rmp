<div>

    <label>
        <input wire:model.live="search" type="search" placeholder="Search professors..."/>
    </label>


    <ul>

        @foreach($professors as $p)
            <li>{{ $p->firstName . ' ' . $p->lastName . ' || ' . $p->schoolName}}</li>
        @endforeach

    </ul>

</div>
