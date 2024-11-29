<div>
    <div>
        <input type="file" wire:model="download" id="{{ $fileUploadId }}">
        <div wire:loading wire:target="download">Uploading...</div>
        @error('download') <span class="error">{{ $message }}</span> @enderror
    </div>

    <table>
        <thead>
            <tr>
                <th class="align-left">File</th>
                <th class="align-left">Route</th>
                <th class="align-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $asset)
                <tr>
                    <td><a href="{{ route('admin.kb.asset.download', ['filename' => basename($asset->storage_path)]) }}" target="_blank" rel="noopener noreferrer">{{  $asset->original_file_name }}</a></td>
                    <td>route('kb.asset.download', ['filename' => '{{ basename($asset->storage_path) }}'])</td>
                    <td>
                        <div class="tooltip">
                            <a onclick="delete_download('{{ $asset->id }}', '{{ $asset->original_file_name }}')"
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
        function delete_download( assetId, name )
        {
            event.preventDefault();

            if (confirm("Delete file: '" + name + "'.") == true)
            {
                @this.delete(assetId);
            } 
        }
    </script>
</div>
