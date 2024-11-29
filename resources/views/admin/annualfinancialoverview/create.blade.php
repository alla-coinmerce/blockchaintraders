<x-admin.layout>
    
    <h1>New Annual Financial Overview</h1>

    <section>

        <form method="POST" action="{{ route('users.annualFinancialOverviews.store', ['user' => $user]) }}" enctype="multipart/form-data">
            @csrf

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>

            <p>
                <label for="file">File: <span aria-label="required">*</span></label>
                <input name="file" type="file" class="@error('file') is-invalid @enderror">

                @error('file')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="notify">{{ __('Notify') }}</label>

                <input type="checkbox" name="notify" value="1" @checked(old('notify', true)) class="@error('notify') is-invalid @enderror">
                <label class="checkbox_label">{{ __('Send :name a notification', ['name' => $user->firstname]) }}</label>

                @error('notify')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>