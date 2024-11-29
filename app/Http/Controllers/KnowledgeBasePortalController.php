<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBaseNewsArticle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class KnowledgeBasePortalController extends Controller
{
    public function index()
    {
        // Authorize
        /**@var \App\Models\User */
        $user = Auth::user();
        if(! ($user->isAdmin() || $user->isKnowledgeBaseSubscriber()))
        {
            abort(403);
        }

        // Show the archive
        return view('portal.knowledgebase.archive', [
            'user' => $user,
            'previousPage' => URL::previous('/')
        ]);
    }

    public function show(KnowledgeBaseNewsArticle $article)
    {
        // Authorize
        /**@var \App\Models\User */
        $user = Auth::user();
        if(! ($user->isAdmin() || $user->isKnowledgeBaseSubscriber()))
        {
            abort(403);
        }
        
        if(!$article->published)
        {
            abort(404);
        }

        // Show the News Article
        $locale = app()->getLocale();

        $attachment = $article->attachment($locale);

        return view('portal.knowledgebase.news-article', [
            'user' => $user,
            'locale' => app()->getLocale(),
            'article' => $article,
            'feature_image_small_url' => Storage::url($article->featured_img_storage_path),
            'feature_image_large_url' => Storage::url($article->featured_img_fw_storage_path),
            'publicationDate' => strtoupper(\Illuminate\Support\Carbon::make($article->publication_date)->translatedFormat('d F Y')),
            'title' => $article->title($locale),
            'content' => $article->content($locale),
            'bottom_img_storage_path' => $article->bottom_img_storage_path ? Storage::url($article->bottom_img_storage_path) : '',
            'bottom_video_storage_path' => $article->bottom_video_storage_path ? Storage::url($article->bottom_video_storage_path) : '',
            'bottom_video_poster_storage_path' => $article->bottom_video_poster_storage_path ? Storage::url($article->bottom_video_poster_storage_path) : '',
            'attachment_url' => $attachment ? Storage::url($attachment->storage_path) : '',
            'attachment_name'=> $attachment ? $attachment->original_file_name : ''
        ]);
    }
}