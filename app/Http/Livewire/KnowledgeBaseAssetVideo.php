<?php

namespace App\Http\Livewire;

use App\Enums\KnowledgeBaseAssetType;
use App\Models\KnowledgeBaseAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class KnowledgeBaseAssetVideo extends Component
{
    use WithFileUploads, WithPagination;

    public $fileUploadId = 1;
    public $video;

    public function updatedVideo()
    {
        $this->validate([
            'video' => File::types(['mp4', 'mov'])
                ->max(2000 * 1024),
        ]);

        $original_file_name = $this->video->getClientOriginalName();
        $storage_path = $this->video->store('knowledge-base-assets/videos');

        KnowledgeBaseAsset::create([
            'type' => KnowledgeBaseAssetType::VIDEO,
            'original_file_name' => $original_file_name,
            'storage_path' => $storage_path
        ]);

        $this->fileUploadId++;
    }

    public function delete($id)
    {
        $asset = KnowledgeBaseAsset::find($id);

        if($asset)
        {
            // Delete the file
            Storage::delete($asset->storage_path);

            // Delete the model
            $asset->delete();
        }
    }

    public function render()
    {
        $assets = KnowledgeBaseAsset::orderBy('id', 'desc')
            ->where('type', KnowledgeBaseAssetType::VIDEO)
            ->paginate(5, ['*'], 'videosPage');

        return view('livewire.knowledge-base-asset-video', [
            'assets' => $assets
        ]);
    }
}

