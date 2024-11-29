<x-admin.layout>
    <h1>Update Participation Investment</h1>

    <section>
        <form method="POST" action="{{ route('funds.participationinvestments.update', ['fund' => $fund, 'participationinvestment' => $participationInvestment]) }}">
            @csrf

            @method('PUT')

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>

            <p>
                <label for="qty">Quantity: <span aria-label="required">*</span></label>
                <input type="number" step="0.0001" inputmode="decimal" name="qty" value="{{ old('qty', $participationInvestment->qty) }}" class="@error('qty') is-invalid @enderror">

                @error('qty')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="tag">Tag</label>
                <input list="tags" type="text" name="tag" value="{{ old('tag', $participationInvestment->tag->name) }}" class="@error('tag') is-invalid @enderror">
                <datalist id="tags">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->name }}">
                    @endforeach
                </datalist>

                @error('tag')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>
    </section>

</x-admin.layout>