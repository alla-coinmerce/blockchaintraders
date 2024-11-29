<?php

namespace App\View\Components\Portal;

use App\Models\KnowledgeBaseNewsArticle;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class NewsArticle extends Component
{
    public $feature_image_small_url;
    public $feature_image_large_url;
    public $videoStoragePath;
    public $bottomVideoPosterStoragePath;
    public $publicationDate;
    public $title;
    public $content;
    public $excerpt;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public KnowledgeBaseNewsArticle $article,
        public int $excerptLength = 100,
        public bool $first= false
    )
    {
        $locale = app()->getLocale();

        $this->feature_image_small_url = $article->featured_img_storage_path ? Storage::url($article->featured_img_storage_path) : '';
        $this->feature_image_large_url = $article->featured_img_fw_storage_path ? Storage::url($article->featured_img_fw_storage_path) : '';
        $this->videoStoragePath = $article->bottom_video_storage_path ? Storage::url($article->bottom_video_storage_path) : '';
        $this->bottomVideoPosterStoragePath = $article->bottom_video_poster_storage_path ? Storage::url($article->bottom_video_poster_storage_path) : '';
        

        $this->publicationDate = strtoupper(\Illuminate\Support\Carbon::make($article->publication_date)->translatedFormat('d F Y'));
        $this->title = $article->title($locale);
        $this->content = $article->content($locale);

        $this->excerpt = $this->makeExcerpt($this->content, 0, $this->excerptLength);
    }

    private function makeExcerpt($fulltext, $startPos=0, $maxLength=100)
    {
        $fulltext = strip_tags($fulltext);

        if(strlen($fulltext) > $maxLength)
        {
            $excerpt   = substr($fulltext, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        }
        else
        {
            $excerpt = $fulltext;
        }
        
        return $excerpt;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.portal.news-article');
    }
}
