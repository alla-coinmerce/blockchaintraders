<x-admin.layout>
    <h2>Deribit connection</h2>

    <section>
        <form method="POST" action="{{ route('deribit.store') }}">
            @csrf

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>

            <p>
                <label for="fund_id">Fund: <span aria-label="required">*</span></label>
                <select id="fund_id" name="fund_id" class="@error('fund_id') is-invalid @enderror">
                    <option value="" disabled selected>-- Select a fund --</option>
                    @foreach($funds as $fund)
                        <option value="{{ $fund->id }}" @selected(old('fund_id') === $fund->id)>
                            {{ $fund->name }}
                        </option>
                    @endforeach
                </select>
    
                @error('fund_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>
    </section>
</x-admin.layout>