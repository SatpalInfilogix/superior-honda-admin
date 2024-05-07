<div @class([
    'alert',
    'alert-danger' => !empty($type) && $type == 'error',
    'alert-success' => empty($type) || $type == 'success',
])>
    {{ $message }}
</div>
