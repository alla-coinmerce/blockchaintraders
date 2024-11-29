<?php

namespace App\Http\Livewire\Portal;

use App\Models\KnowledgeBaseNewsArticle;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class KnowledgeBaseArchive extends Component
{
    use WithPagination;

    public string $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = !empty($this->search) ? '%'.$this->search.'%' : '';

        $articles = KnowledgeBaseNewsArticle::orderBy('publication_date', 'DESC')
            ->orderBY('created_at', 'DESC')
            ->where('published', true)
            ->when(!empty($search), function(Builder $query) use ($search) {
                $query->whereHas('translations', function (Builder $query) use ($search) {
                    $query->where('translations.translation', 'like', $search)
                        ->where('locale', app()->getLocale());
                });
            })
            ->paginate(10);

        return view('livewire.portal.knowledge-base-archive', [
            'articles' => $articles
        ]);
    }
}
