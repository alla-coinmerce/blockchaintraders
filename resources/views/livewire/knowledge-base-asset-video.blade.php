<div>
    <div>
        <input type="file" wire:model="video" id="{{ $fileUploadId }}">
        <div wire:loading wire:target="video">Uploading...</div>
        @error('video') <span class="error">{{ $message }}</span> @enderror
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
                        <a href="{{ route('admin.kb.asset.video', ['filename' => basename($asset->storage_path)]) }}">
                            <video
                                width="100"
                                playsInline 
                                src="{{ route('admin.kb.asset.video', ['filename' => basename($asset->storage_path)]) }}" 
                                @if (pathinfo($asset->storage_path, PATHINFO_EXTENSION) === 'mov')
                                    type="video/quicktime" 
                                @else
                                    type="video/mp4" 
                                @endif
                                preload="auto" 
                            >
                                <source src="{{ route('admin.kb.asset.video', ['filename' => basename($asset->storage_path)]) }}" 
                                @if (pathinfo($asset->storage_path, PATHINFO_EXTENSION) === 'mov')
                                    type="video/quicktime" 
                                @else
                                    type="video/mp4" 
                                @endif>
                                Your browser does not support the video tag.
                            </video>
                        </a>
                    </td>
                    <td>{{ $asset->original_file_name }}</td>
                    <td>route('kb.asset.video', ['filename' => '{{ basename($asset->storage_path) }}'])</td>
                    <td>
                        <div class="tooltip">
                            <a onclick="delete_video('{{ $asset->id }}', '{{ $asset->original_file_name }}')"
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
        function delete_video( assetId, name )
        {
            event.preventDefault();

            if (confirm("Delete video: '" + name + "'.") == true)
            {
                @this.delete(assetId);
            } 
        }
    </script>
</div>
