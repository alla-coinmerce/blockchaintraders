<x-admin.layout>
    
    <h1>Edit Fund</h1>

    <section>

        <form method="POST" action="{{ route('funds.update', ['fund' => $fund]) }}">
            @csrf
            @method('PUT')

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>
        
            <p>
                <label for="name">Fund name: <span aria-label="required">*</span></label>
                <input type="text" name="name"  value="{{ old('name', $fund->name) }}" class="@error('name') is-invalid @enderror">

                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="public">Public:</label>
                <input type="checkbox" name="public" value="1" @checked(old('public', $fund->public) == 1)
                    class="@error('public') is-invalid @enderror">
                <span>Makes public registration form available when checked.</span>

                @error('public')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="startDate">Start date:</label>
                @if ($fund->fundValues)
                    <select name="startDate" id="startDate">
                        @foreach ($fund->fundValues as $fundValue)
                            @if($loop->first && !$fund->startFundValue)
                                <option value="{{ $fundValue->id }}" @selected(true)>{{ $fundValue->date }}</option> 
                            @else
                                <option value="{{ $fundValue->id }}" @selected($fund->startFundValue && ($fundValue->id === $fund->startFundValue->id))>{{ $fundValue->date }}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    No dates available
                @endif

                @error('startDate')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="auto_update_enabled">Auto update:</label>
                <input type="checkbox" name="auto_update_enabled" value="1" @checked(old('auto_update_enabled', $fund->auto_update_enabled) == 1)
                    class="@error('auto_update_enabled') is-invalid @enderror">
                <span>Enables automatic updating of fund values when checked.</span>

                @error('auto_update_enabled')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="extrapolate_enabled">Extrapolate during weekend:</label>
                <input type="checkbox" name="extrapolate_enabled" value="1" @checked(old('extrapolate_enabled', $fund->extrapolate_enabled) == 1)
                    class="@error('extrapolate_enabled') is-invalid @enderror">
                <span>Enables automatic updating of fund values during the weekend using the extrapolation factor when checked.</span>

                @error('extrapolate_enabled')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="extrapolation_factor">Extrapolation factor:</label>
                <input type="number" min="0" step="0.000001" id="extrapolation_factor" name="extrapolation_factor" value="{{ old('extrapolation_factor', $fund->extrapolation_factor) }}"
                    class="@error('extrapolation_factor') is-invalid @enderror">

                @error('extrapolation_factor')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>