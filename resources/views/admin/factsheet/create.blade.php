<x-admin.layout>
    
    <h1>New Factsheet</h1>

    <section>

        <form method="POST" action="{{ route('funds.factsheets.store', ['fund' => $fund]) }}" enctype="multipart/form-data">
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
                <label for="week">Week: <span aria-label="required">*</span></label>
                <select name="week" class="@error('week') is-invalid @enderror">
                    @for ($i = 1; $i < 54; $i++)
                        <option value="{{ $i }}" @selected(old('week', \Illuminate\Support\Carbon::now()->weekOfYear) == $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>

                @error('week')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="year">Year: <span aria-label="required">*</span></label>
                <select name="year"class="@error('year') is-invalid @enderror">
                    @for ($i = \Illuminate\Support\Carbon::now()->year; $i > 2000; $i--)
                        <option value="{{ $i }}" @selected(old('year', \Illuminate\Support\Carbon::now()->year) == $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>

                @error('year')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="notify">{{ __('Notify') }}</label>

                <input type="checkbox" name="notify" value="1" @checked(old('notify', true)) class="@error('notify') is-invalid @enderror">
                <label class="checkbox_label">{{ __('Send participants a notification') }}</label>

                @error('notify')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>