<div class="tab-pane active" id="general_setting" role="tabpanel">
    <form action="{{ route('settings.general-setting') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-input-text name="buisness_name" label="Business Name"
                value="{{ old('buisness_name', App\Helpers\SettingHelper::setting('buisness_name')) }}"></x-input-text>
        </div>
        <div class="form-group">
            <x-input-text name="email" label="Email"
                value="{{ old('email', App\Helpers\SettingHelper::setting('email')) }}"></x-input-text>
        </div>
        <div class="form-group">
            <x-input-text name="contact" label="Contact"
                value="{{ old('contact', App\Helpers\SettingHelper::setting('contact')) }}"></x-input-text>
        </div>
        <div class="form-group">
            <label for="add-banner">Banner</label>
            <div class="custom-file">
                <input type="file" name="banner"
                    class="custom-file-input" id="add-banner">
                <label class="custom-file-label" for="add-banner">Choose
                    Banner</label>
                @if (App\Helpers\SettingHelper::setting('banner') != '')
                    <img src="{{ asset(App\Helpers\SettingHelper::setting('banner')) }}"
                        id="previewImg" class="img-preview"
                        width="50" height="50">
                @else
                    <img src="" id="previewImg" height="50"
                        width="50" name="image" hidden>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="add-logo">Logo</label>
            <div class="custom-file">
                <input type="file" name="logo"
                    class="custom-file-input" id="add-logo">
                <label class="custom-file-label" for="add-logo">Choose
                    Logo</label>
                @if (App\Helpers\SettingHelper::setting('logo'))
                    <img src="{{ asset(App\Helpers\SettingHelper::setting('logo')) }}"
                        id="preview-Img" class="img-preview"
                        width="50" height="50">
                @else
                    <img src="" id="preview-Img" height="50"
                        width="50" name="image" hidden>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="currency">Currency</label>
            <select class="form-control" id="currency" name="currency">
                <option value="INR" @selected(App\Helpers\SettingHelper::setting('currency') == 'INR')>INR
                </option>
                <option value="USD" @selected(App\Helpers\SettingHelper::setting('currency') == 'USD')>USD
                </option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary primary-btn">Save</button>
    </form>
</div>