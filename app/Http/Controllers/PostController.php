<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\PostAttachment;
use App\Models\Translation;
use App\Services\StringToSlugConverter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function webIndex()
    {
        return view('web.blog');
    }

    /**
     * Display the specified resource.
     */
    public function webShow(Post $post)
    {
        if(!$post->published)
        {
            abort(404);
        }

        $locale = app()->getLocale();

        $attachment = $post->attachment($locale);

        return view('web.post', [
            'locale' => app()->getLocale(),
            'post' => $post,
            'feature_image_small_url' => Storage::url($post->featured_img_storage_path),
            'feature_image_large_url' => Storage::url($post->featured_img_fw_storage_path),
            'publicationDate' => strtoupper(\Illuminate\Support\Carbon::make($post->publication_date)->translatedFormat('d F Y')),
            'keywords' => $post->keywords($locale),
            'description' => $post->description($locale),
            'metaTitle' => $post->metaTitle($locale),
            'title' => $post->title($locale),
            'content' => $post->content($locale),
            'bottom_img_storage_path' => $post->bottom_img_storage_path ? Storage::url($post->bottom_img_storage_path) : '',
            'bottom_video_storage_path' => $post->bottom_video_storage_path ? Storage::url($post->bottom_video_storage_path) : '',
            'attachment_url' => $attachment ? Storage::url($attachment->storage_path) : '',
            'attachment_name'=> $attachment ? $attachment->original_file_name : ''
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.post.index', [
            'posts' => Post::orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.post.create', [
            'available_locales' => config('app.available_locales')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, StringToSlugConverter $converter)
    {
        // dd($request);

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
                $attributes['featured_img_storage_path'] = $request->file('featured_image')->storePublicly('public/posts/images');
            }

            if($request->file('full_width_featured_image'))
            {
                $attributes['featured_img_fw_original_file_name'] = $request->file('full_width_featured_image')->getClientOriginalName();
                $attributes['featured_img_fw_storage_path'] = $request->file('full_width_featured_image')->storePublicly('public/posts/images');
            }

            if($request->file('bottom_image'))
            {
                $attributes['bottom_img_original_file_name'] = $request->file('bottom_image')->getClientOriginalName();
                $attributes['bottom_img_storage_path'] = $request->file('bottom_image')->storePublicly('public/posts/images');
            }

            if($request->file('bottom_video'))
            {
                $attributes['bottom_video_original_file_name'] = $request->file('bottom_video')->getClientOriginalName();
                $attributes['bottom_video_storage_path'] = $request->file('bottom_video')->storePublicly('public/posts/videos');
            }

            $post = Post::create($attributes);
            
            $this->createTranslations($post->id, 'metaTitle', $request->metaTitle);
            $this->createTranslations($post->id, 'title', $request->title);
            $this->createTranslations($post->id, 'content', $request->content);
            $this->createTranslations($post->id, 'keywords', $request->keywords);
            $this->createTranslations($post->id, 'description', $request->description);

            if($request->file('post_attachment'))
            {
                foreach($request->file('post_attachment') as $locale => $file)
                {
                    $attachment_original_file_name = $file->getClientOriginalName();
                    $attachment_storage_path = $file->storePublicly('public/posts/downloads');

                    PostAttachment::create([
                        'post_id' => $post->id,
                        'locale' => $locale,
                        'original_file_name' => $attachment_original_file_name,
                        'storage_path' => $attachment_storage_path
                    ]);
                }
            }

            DB::commit();
        }
        catch( \Exception $e)
        {
            Log::error('Failed to create post. '.$e->getMessage());

            DB::rollBack();

            return back()->withInput();
        }

        return Redirect::route('posts.edit', ['post' => $post]);
    }

    private function createTranslations($postId, $field, $data)
    {
        foreach($data as $locale => $value)
        {
            if( $value !== null)
            {
                Translation::create([
                    'translatable_type' => Post::class,
                    'translatable_id' => $postId,
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
    public function show(Post $post)
    {
        $locale = app()->getLocale();

        $attachment = $post->attachment($locale);

        return view('admin.post.show', [
            'locale' => $locale,
            'post' => $post,
            'feature_image_small_url' => Storage::url($post->featured_img_storage_path),
            'feature_image_large_url' => Storage::url($post->featured_img_fw_storage_path),
            'publicationDate' => strtoupper(\Illuminate\Support\Carbon::make($post->publication_date)->translatedFormat('d F Y')),
            'keywords' => $post->keywords($locale),
            'description' => $post->description($locale),
            'metaTitle' => $post->metaTitle($locale),
            'title' => $post->title($locale),
            'content' => $post->content($locale),
            'bottom_img_storage_path' => $post->bottom_img_storage_path ? Storage::url($post->bottom_img_storage_path) : '',
            'bottom_video_storage_path' => $post->bottom_video_storage_path ? Storage::url($post->bottom_video_storage_path) : '',
            'attachment_url' => $attachment ? Storage::url($attachment->storage_path) : '',
            'attachment_name'=> $attachment ? $attachment->original_file_name : ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', [
            'available_locales' => config('app.available_locales'),
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post, StringToSlugConverter $converter)
    {
        // dd($request);

        try
        {
            DB::beginTransaction();

            // Update the post
            $post->title = $request->title['nl'];
            $post->slug = $converter->getSlugFromString($request->title['nl']);
            

            if($request->status !== 'published')
            {
                $post->publication_date = null;
            }
            elseif( ($request->status === 'published') &&
                    ($post->published === false) )
            {
                $post->publication_date = Carbon::now()->format('Y-m-d');
            }

            $post->published = $request->status === 'published' ? true : false;

            if($request->file('featured_image'))
            {
                $post->featured_img_original_file_name = $request->file('featured_image')->getClientOriginalName();
                $post->featured_img_storage_path = $request->file('featured_image')->storePublicly('public/posts/images');
            }
            elseif(empty($request->current_featured_image))
            {
                $post->featured_img_original_file_name = '';
                $post->featured_img_storage_path = '';
            }

            if($request->file('full_width_featured_image'))
            {
                $post->featured_img_fw_original_file_name = $request->file('full_width_featured_image')->getClientOriginalName();
                $post->featured_img_fw_storage_path = $request->file('full_width_featured_image')->storePublicly('public/posts/images');
            }
            elseif(empty($request->current_full_width_featured_image))
            {
                $post->featured_img_fw_original_file_name = '';
                $post->featured_img_fw_storage_path = '';
            }

            if($request->file('bottom_image'))
            {
                $post->bottom_img_original_file_name = $request->file('bottom_image')->getClientOriginalName();
                $post->bottom_img_storage_path = $request->file('bottom_image')->storePublicly('public/posts/images');
            }
            elseif(empty($request->current_bottom_image))
            {
                $post->bottom_img_original_file_name = '';
                $post->bottom_img_storage_path = '';
            }

            if($request->file('bottom_video'))
            {
                $post->bottom_video_original_file_name = $request->file('bottom_video')->getClientOriginalName();
                $post->bottom_video_storage_path = $request->file('bottom_video')->storePublicly('public/posts/videos');
            }
            elseif(empty($request->current_bottom_video))
            {
                $post->bottom_video_original_file_name = '';
                $post->bottom_video_storage_path = '';
            }

            $post->save();

            // Update translations (create if not exists)
            $this->updateTranslations($post->id, 'metaTitle', $request->metaTitle);
            $this->updateTranslations($post->id, 'title', $request->title);
            $this->updateTranslations($post->id, 'content', $request->content);
            $this->updateTranslations($post->id, 'keywords', $request->keywords);
            $this->updateTranslations($post->id, 'description', $request->description);

            // Update attachments (create if not exists)
            foreach($request->current_post_attachment as $locale => $value)
            {
                // A new file was uploaded
                if(isset($request->file('post_attachment')[$locale]))
                {
                    $file = $request->file('post_attachment')[$locale];

                    $attachment_original_file_name = $file->getClientOriginalName();
                    $attachment_storage_path = $file->storePublicly('public/posts/downloads');

                    PostAttachment::updateOrCreate([
                        'post_id' => $post->id,
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
                    PostAttachment::where('post_id', $post->id)
                        ->where('locale', $locale)
                        ->delete();
                }
                // The attachment is unchanged
            }     

            DB::commit();
        }
        catch( \Exception $e)
        {
            Log::error('Failed to update post. '.$e->getMessage());

            DB::rollBack();

            return back()->withInput();
        }

        if($request->action_save_and_preview)
        {
            return Redirect::route('posts.show', ['post' => $post]);
        }

        return back();
    }

    private function updateTranslations($postId, $field, $data)
    {
        foreach($data as $locale => $value)
        {
            if( $value !== null)
            {
                Translation::updateOrCreate([
                    'translatable_type' => Post::class,
                    'translatable_id' => $postId,
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
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->translations()->delete();
        $post->attachments()->delete();
        $post->delete();

        return Redirect::route('posts.index');
    }
}
