<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBaseNewsArticle;
use App\Http\Requests\StoreKnowledgeBaseNewsArticleRequest;
use App\Http\Requests\UpdateKnowledgeBaseNewsArticleRequest;
use App\Models\KnowledgeBaseNewsArticleAttachment;
use App\Models\Translation;
use App\Services\StringToSlugConverter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KnowledgeBaseNewsArticleAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.knowledge-base.news.index', [
            'articles' => KnowledgeBaseNewsArticle::orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.knowledge-base.news.create', [
            'available_locales' => config('app.available_locales')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKnowledgeBaseNewsArticleRequest $request, StringToSlugConverter $converter)
    {
        try
        {
            DB::beginTransaction();

            $attributes = [
                'title' => $request->title['nl'],
                'slug' => $converter->getSlugFromString($request->title['nl']),
                'published' => $request->status === 'published' ? true : false,
                'publication_date' => $request->status === 'published' ? Carbon::now()->format('Y-m-d'): null
            ];

            if($request->file('featured_image'))
            {
                $attributes['featured_img_original_file_name'] = $request->file('featured_image')->getClientOriginalName();
                $attributes['featured_img_storage_path'] = $request->file('featured_image')->store('knowledge-base-assets/images');
            }

            if($request->file('full_width_featured_image'))
            {
                $attributes['featured_img_fw_original_file_name'] = $request->file('full_width_featured_image')->getClientOriginalName();
                $attributes['featured_img_fw_storage_path'] = $request->file('full_width_featured_image')->store('knowledge-base-assets/images');
            }

            if($request->file('bottom_image'))
            {
                $attributes['bottom_img_original_file_name'] = $request->file('bottom_image')->getClientOriginalName();
                $attributes['bottom_img_storage_path'] = $request->file('bottom_image')->store('knowledge-base-assets/images');
            }

            if($request->file('bottom_video'))
            {
                $attributes['bottom_video_original_file_name'] = $request->file('bottom_video')->getClientOriginalName();
                $attributes['bottom_video_storage_path'] = $request->file('bottom_video')->store('knowledge-base-assets/videos');
            }

            if($request->file('bottom_video_poster'))
            {
                $attributes['bottom_video_poster_original_file_name'] = $request->file('bottom_video_poster')->getClientOriginalName();
                $attributes['bottom_video_poster_storage_path'] = $request->file('bottom_video_poster')->store('knowledge-base-assets/images');
            }

            $article = KnowledgeBaseNewsArticle::create($attributes);
            
            $this->createTranslations($article->id, 'title', $request->title);
            $this->createTranslations($article->id, 'content', $request->content);

            if($request->file('post_attachment'))
            {
                foreach($request->file('post_attachment') as $locale => $file)
                {
                    $attachment_original_file_name = $file->getClientOriginalName();
                    $attachment_storage_path = $file->store('knowledge-base-assets/downloads');

                    KnowledgeBaseNewsArticleAttachment::create([
                        'knowledge_base_news_article_id' => $article->id,
                        'locale' => $locale,
                        'original_file_name' => $attachment_original_file_name,
                        'storage_path' => $attachment_storage_path
                    ]);
                }
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error('Failed to create knowledgeBaseNewsArticle. '.$e->getMessage());

            DB::rollBack();

            return back()->withInput();
        }

        return Redirect::route('knowledgebase-news.edit', ['knowledgebase_news' => $article]);
    }

    private function createTranslations($articleId, $field, $data)
    {
        foreach($data as $locale => $value)
        {
            if( $value !== null)
            {
                Translation::create([
                    'translatable_type' => KnowledgeBaseNewsArticle::class,
                    'translatable_id' => $articleId,
                    'locale' => $locale,
                    'field' => $field,
                    'translation' => $value
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowledgeBaseNewsArticle $knowledgebase_news)
    {
        $locale = app()->getLocale();

        $attachment = $knowledgebase_news->attachment($locale);

        return view('admin.knowledge-base.news.show', [
            'user' => Auth::user(),
            'locale' => $locale,
            'article' => $knowledgebase_news,
            'feature_image_small_url' => Storage::url($knowledgebase_news->featured_img_storage_path),
            'feature_image_large_url' => Storage::url($knowledgebase_news->featured_img_fw_storage_path),
            'publicationDate' => strtoupper(\Illuminate\Support\Carbon::make($knowledgebase_news->publication_date)->translatedFormat('d F Y')),
            'title' => $knowledgebase_news->title($locale),
            'content' => $knowledgebase_news->content($locale),
            'bottom_img_storage_path' => $knowledgebase_news->bottom_img_storage_path ? Storage::url($knowledgebase_news->bottom_img_storage_path) : '',
            'bottom_video_storage_path' => $knowledgebase_news->bottom_video_storage_path ? Storage::url($knowledgebase_news->bottom_video_storage_path) : '',
            'attachment_url' => $attachment ? Storage::url($attachment->storage_path) : '',
            'attachment_name'=> $attachment ? $attachment->original_file_name : ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowledgeBaseNewsArticle $knowledgebase_news)
    {
        return view('admin.knowledge-base.news.edit', [
            'available_locales' => config('app.available_locales'),
            'article' => $knowledgebase_news
        ]);
    }

    private function updateTranslations($articleId, $field, $data)
    {
        foreach($data as $locale => $value)
        {
            if( $value !== null)
            {
                Translation::updateOrCreate([
                    'translatable_type' => KnowledgeBaseNewsArticle::class,
                    'translatable_id' => $articleId,
                    'locale' => $locale,
                    'field' => $field
                ],
                [
                    'translation' => $value
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowledgeBaseNewsArticleRequest $request, KnowledgeBaseNewsArticle $knowledgebase_news, StringToSlugConverter $converter)
    {
        try
        {
            DB::beginTransaction();

            // Update the post
            $knowledgebase_news->title = $request->title['nl'];
            $knowledgebase_news->slug = $converter->getSlugFromString($request->title['nl']);

            if($request->status !== 'published')
            {
                $knowledgebase_news->publication_date = null;
            }
            elseif( ($request->status === 'published') &&
                    ($knowledgebase_news->published === false) )
            {
                $knowledgebase_news->publication_date = Carbon::now()->format('Y-m-d');
            }

            $knowledgebase_news->published = $request->status === 'published' ? true : false;

            if($request->file('featured_image'))
            {
                $knowledgebase_news->featured_img_original_file_name = $request->file('featured_image')->getClientOriginalName();
                $knowledgebase_news->featured_img_storage_path = $request->file('featured_image')->store('knowledge-base-assets/images');
            }
            elseif(empty($request->current_featured_image))
            {
                $knowledgebase_news->featured_img_original_file_name = '';
                $knowledgebase_news->featured_img_storage_path = '';
            }

            if($request->file('full_width_featured_image'))
            {
                $knowledgebase_news->featured_img_fw_original_file_name = $request->file('full_width_featured_image')->getClientOriginalName();
                $knowledgebase_news->featured_img_fw_storage_path = $request->file('full_width_featured_image')->store('knowledge-base-assets/images');
            }
            elseif(empty($request->current_full_width_featured_image))
            {
                $knowledgebase_news->featured_img_fw_original_file_name = '';
                $knowledgebase_news->featured_img_fw_storage_path = '';
            }

            if($request->file('bottom_image'))
            {
                $knowledgebase_news->bottom_img_original_file_name = $request->file('bottom_image')->getClientOriginalName();
                $knowledgebase_news->bottom_img_storage_path = $request->file('bottom_image')->store('knowledge-base-assets/images');
            }
            elseif(empty($request->current_bottom_image))
            {
                $knowledgebase_news->bottom_img_original_file_name = '';
                $knowledgebase_news->bottom_img_storage_path = '';
            }

            if($request->file('bottom_video'))
            {
                $knowledgebase_news->bottom_video_original_file_name = $request->file('bottom_video')->getClientOriginalName();
                $knowledgebase_news->bottom_video_storage_path = $request->file('bottom_video')->store('knowledge-base-assets/videos');
            }
            elseif(empty($request->current_bottom_video))
            {
                $knowledgebase_news->bottom_video_original_file_name = '';
                $knowledgebase_news->bottom_video_storage_path = '';
            }

            if($request->file('bottom_video_poster'))
            {
                $knowledgebase_news->bottom_video_poster_original_file_name = $request->file('bottom_video_poster')->getClientOriginalName();
                $knowledgebase_news->bottom_video_poster_storage_path = $request->file('bottom_video_poster')->store('knowledge-base-assets/images');
            }
            elseif(empty($request->current_bottom_video_poster))
            {
                $knowledgebase_news->bottom_video_poster_original_file_name = '';
                $knowledgebase_news->bottom_video_poster_storage_path = '';
            }

           $knowledgebase_news->save();

           // Update translations (create if not exists)
           $this->updateTranslations($knowledgebase_news->id, 'title', $request->title);
           $this->updateTranslations($knowledgebase_news->id, 'content', $request->content);

           // Update attachments (create if not exists)
           foreach($request->current_post_attachment as $locale => $value)
           {
               // A new file was uploaded
               if(isset($request->file('post_attachment')[$locale]))
               {
                   $file = $request->file('post_attachment')[$locale];

                   $attachment_original_file_name = $file->getClientOriginalName();
                   $attachment_storage_path = $file->store('knowledge-base-assets/downloads');

                   KnowledgeBaseNewsArticleAttachment::updateOrCreate([
                       'knowledge_base_news_article_id' => $knowledgebase_news->id,
                       'locale' => $locale
                   ],
                   [
                       'original_file_name' => $attachment_original_file_name,
                       'storage_path' => $attachment_storage_path
                   ]);
               }
               elseif(empty($value)) // the attachment is removed
               {
                   // Delete attachment
                   KnowledgeBaseNewsArticleAttachment::where('knowledge_base_news_article_id', $knowledgebase_news->id)
                       ->where('locale', $locale)
                       ->delete();
               }
               // The attachment is unchanged
           }   

            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error('Failed to update knowledgeBaseNewsArticle. '.$e->getMessage());

            DB::rollBack();

            return back()->withInput();
        }

        if($request->action_save_and_preview)
        {
            return Redirect::route('knowledgebase-news.show', ['knowledgebase_news' => $knowledgebase_news]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnowledgeBaseNewsArticle $knowledgebase_news)
    {
        $knowledgebase_news->translations()->delete();
        $knowledgebase_news->attachments()->delete();
        $knowledgebase_news->delete();

        return Redirect::route('knowledgebase-news.index');
    }
}
