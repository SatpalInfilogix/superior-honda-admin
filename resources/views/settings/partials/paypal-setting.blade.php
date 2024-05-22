<div class="tab-pane" id="paypal_setting" role="tabpanel">
    <form action="{{ route('settings.general-setting') }}"
        method="POST">
        @csrf
        <div class="form-group">
            <x-input-text name="api_key" label="API Key"
                value="{{ old('api_key', App\Helpers\SettingHelper::setting('api_key')) }}"></x-input-text>
        </div>
        <div class="form-group">
            <x-input-text name="secret_key" label="Secret Key"
                value="{{ old('secret_key', App\Helpers\SettingHelper::setting('secret_key')) }}"></x-input-text>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>