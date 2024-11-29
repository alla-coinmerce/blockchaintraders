<x-admin.layout>
    
    <h1>Edit Fund Value</h1>

    <section>

        <form method="POST" action="{{ route('funds.fundvalues.update', ['fund' => $fund, 'fundvalue' => $fundvalue]) }}">
            @csrf
            @method('PUT')

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>
        
            <p>
                <label for="date">Date: <span aria-label="required">*</span></label>
                <input type="date" name="date" value="{{ old('date', $fundvalue->date) }}" class="@error('date') is-invalid @enderror">

                @error('date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="value_eurocents">Value (€): <span aria-label="required">*</span></label>
                <input type="number" step="0.01" inputmode="decimal" name="value_eurocents" value="{{ old('value_eurocents', $fundvalue->value_eurocents / 100) }}" class="@error('value_eurocents') is-invalid @enderror">

                @error('value_eurocents')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="value_dollarcents">Value ($):</label>
                <input type="number" step="0.01" inputmode="decimal" name="value_dollarcents" value="{{ old('value_dollarcents', ($fundvalue->value_dollarcents !== null) ? $fundvalue->value_dollarcents / 100 : '') }}" class="@error('value_dollarcents') is-invalid @enderror">

                @error('value_dollarcents')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>