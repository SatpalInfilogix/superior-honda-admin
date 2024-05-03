@php
    $label = $attributes['label'];
    $checked = $attributes['checked'];
    $errorClass = '';
@endphp

@unset($attributes['label'])
@unset($attributes['checked'])

@if($errors->has($attributes['name']))
    @php
        $errorClass = 'form-control-danger'
    @endphp
@endif

<div class="border-checkbox-section">
    <div class="border-checkbox-group border-checkbox-group-primary">
        <input class="border-checkbox" type="checkbox" id="{{ $attributes['name'] }}"
            {{ $attributes->merge(['class' => 'form-control '.$errorClass]) }} 
            {{ $checked ? 'checked': '' }}
        >

        <label class="border-checkbox-label" for="{{ $attributes['name'] }}">{{ $label }}</label>
    </div>
</div>
