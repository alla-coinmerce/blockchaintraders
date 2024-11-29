<div>
    <div>
        <input type="file" wire:model="image" id="{{ $fileUploadId }}">
        <div wire:loading wire:target="image">Uploading...</div>
        @error('image') <span class="error">{{ $message }}</span> @enderror
    </div>

    <table>
        <thead>
            <tr>
                <th class="align-left">Preview</th>
                <th class="align-left">File name</th>
                <th class="align-left">Route</th>
                <th class="align-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $asset)
                <tr>
                    <td>
                        <a href="{{ route('admin.kb.asset.image', ['filename' => basename($asset->storage_path)]) }}">
                            <img src="{{ route('admin.kb.asset.image', ['filename' => basename($asset->storage_path)]) }}" alt="preview" width="100">
                        </a>
                    </td>
                    <td>{{ $asset->original_file_name }}</td>
                    <td>route('kb.asset.image', ['filename' => '{{ basename($asset->storage_path) }}'])</td>
                    <td>
                        <div class="tooltip">
                            <a onclick="delete_image('{{ $asset->id }}', '{{ $asset->original_file_name }}')"
                                ><i class="fa fa-trash fa-fw"></i>
                            </a>
                            <span class="tooltiptext">delete</span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $assets->links('components.pagination-alt') }}

    <script>
        function delete_image( assetId, name )
        {
            event.preventDefault();

            if (confirm("Delete image: '" + name + "'.") == true)
            {
                @this.delete(assetId);
            } 
        }
    </script>
</div>
