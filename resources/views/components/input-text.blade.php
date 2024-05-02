<label for="{{ $attributes['name'] }}">{{ $attributes['label'] }}</label>
<input type="text" {{ $attributes->merge(['class' => 'form-control']) }} id="{{ $attributes['name'] }}" />

@error($attributes['name'])
    <span class="text-danger">{{ $message }}</span>
@enderror