@if(isset($zones))
    <option value="">Choose state</option>

    @foreach($zones as $zone)
        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
    @endforeach
@endif
