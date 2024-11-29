<?php

namespace App\Http\Livewire;

use App\Enums\KnowledgeBaseAssetType;
use App\Models\KnowledgeBaseAsset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class KnowledgeBaseAssetDownload extends Component
{
    use WithFileUploads, WithPagination;

    public $fileUploadId = 1;
    public $download;

    public function updatedDownload()
    {
        $this->validate([
            'download' => File::types(['csv', 'doc', 'doxx', 'html', 'odg', 'odp', 'ods', 'odt', 'pdf', 'ppt', 'pptx', 'txt', 'xls', 'xlsx', 'xml'])
                ->max(100 * 1024),
        ]);

        $original_file_name = $this->download->getClientOriginalName();
        $storage_path = $this->download->store('knowledge-base-assets/downloads');

        KnowledgeBaseAsset::create([
            'type' => KnowledgeBaseAssetType::DOWNLOAD,
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
            ->where('type', KnowledgeBaseAssetType::DOWNLOAD)
            ->paginate(5, ['*'], 'downloadsPage');

        return view('livewire.knowledge-base-asset-download', [
            'assets' => $assets
        ]);
    }
}


