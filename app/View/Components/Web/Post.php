<?php

namespace App\View\Components\Web;

use App\Models\Post as ModelsPost;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Post extends Component
{
    public $feature_image_small_url;
    public $feature_image_large_url;
    public $publicationDate;
    public $title;
    public $content;
    public $excerpt;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ModelsPost $post
    )
    {
        $locale = app()->getLocale();

        $this->post = $post;

        $this->feature_image_small_url = Storage::url($post->featured_img_storage_path);
        $this->feature_image_large_url = Storage::url($post->featured_img_fw_storage_path);

        $this->publicationDate = strtoupper(\Illuminate\Support\Carbon::make($post->publication_date)->translatedFormat('d F Y'));
        $this->title = $post->title($locale);
        $this->content = $post->content($locale);

        $this->excerpt = $this->makeExcerpt($this->content);
    }

    private function makeExcerpt($fulltext, $startPos=0, $maxLength=180)
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
        return view('components.web.post');
    }
}
