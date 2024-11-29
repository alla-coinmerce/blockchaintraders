<x-admin.layout>

    <h1>Create Fund</h1>

    <section>

        <form method="POST" action="{{ route('funds.store') }}">
            @csrf

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>

            <p>
                <label for="name">Fund name: <span aria-label="required">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="@error('name') is-invalid @enderror">

                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="public">Public:</label>
                <input type="checkbox" name="public" value="1" @checked(old('public') === "1")
                    class="@error('public') is-invalid @enderror">
                <span>(Makes public registration form available when checked)</span>

                @error('public')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>
