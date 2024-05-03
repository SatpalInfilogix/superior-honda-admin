@isset($attributes['label'])
<label for="{{ $attributes['name'] }}">{{ $attributes['label'] }}</label>
@endisset

@unset($attributes['label'])

@php
    $errorClass = '';
@endphp

@if($errors->has($attributes['name']))
    @php
        $errorClass = 'form-control-danger'
    @endphp
@endif

<input type="text" id="{{ $attributes['name'] }}" autocomplete="false"
    {{ $attributes->merge(['class' => 'form-control '.$errorClass]) }} 
/>

@error($attributes['name'])
    <span class="text-danger f-12">{{ $message }}</span>
@enderror