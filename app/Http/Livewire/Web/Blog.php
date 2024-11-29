<?php

namespace App\Http\Livewire\Web;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.web.blog', [
            'posts' => Post::orderBy('publication_date', 'DESC')
                ->orderBY('created_at', 'DESC')
                ->where('published', true)
                ->paginate(8)
        ]);
    }
}
