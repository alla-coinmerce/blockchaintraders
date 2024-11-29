<x-admin.layout>
    
    <h1>Edit Tag</h1>

    <section>

        <form method="POST" action="{{ route('tags.update', ['tag' => $tag]) }}">
            @csrf
            @method('PUT')

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>
        
            <p>
                <label for="name">Tag: <span aria-label="required">*</span></label>
                <input type="text" name="name"  value="{{ old('name', $tag->name) }}" class="@error('name') is-invalid @enderror">

                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>