<div class="row">
  @foreach($types as $type)
    <div class="col">
      <label class="inline-radio">
        <input
          type="radio"
          name="car_type_id"
          value="{{ $type->id }}"
          @checked($attributes->get('value') == $type->id)
        />
        {{ $type->name }}
      </label>
    </div>
    {{-- Afficher sur  4 col et sur 2 rows --}}
    @if($loop->iteration % 4 == 0 && !$loop->last)
</div>
<div class="row">
    @endif
  @endforeach
</div>
