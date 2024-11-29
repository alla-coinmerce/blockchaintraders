<x-admin.layout>
    
    <h1>New Document</h1>

    <section>

        <form method="POST" action="{{ route('users.documents.store', ['user' => $user]) }}" enctype="multipart/form-data">
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
                <label for="display_name">Zichtbare naam: <span aria-label="required">*</span></label>
                <input name="display_name" type="text" class="@error('display_name') is-invalid @enderror">

                @error('display_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>