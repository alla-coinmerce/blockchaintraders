<?php

namespace App\Http\Livewire;

use App\Enums\KnowledgeBaseAssetType;
use App\Models\KnowledgeBaseAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class KnowledgeBaseAssetImage extends Component
{
    use WithFileUploads, WithPagination;

    public $fileUploadId = 1;
    public $image;

    public function updatedImage()
    {
        $this->validate([
            'image' => File::image()
                ->max(10 * 1024),
        ]);

        $original_file_name = $this->image->getClientOriginalName();
        $storage_path = $this->image->store('knowledge-base-assets/images');

        KnowledgeBaseAsset::create([
            'type' => KnowledgeBaseAssetType::IMAGE,
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
            ->where('type', KnowledgeBaseAssetType::IMAGE)
            ->paginate(5, ['*'], 'imagesPage');

        return view('livewire.knowledge-base-asset-image', [
            'assets' => $assets
        ]);
    }
}
