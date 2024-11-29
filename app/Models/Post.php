<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',

        'published',
        'publication_date',

        'featured_img_original_file_name',
        'featured_img_storage_path',

        'featured_img_fw_original_file_name',
        'featured_img_fw_storage_path',

        'bottom_img_original_file_name',
        'bottom_img_storage_path',

        'bottom_video_original_file_name',
        'bottom_video_storage_path',

        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'attachments',
        'translations'
    ];

    /**
     * Get the attachments for the blog post.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(PostAttachment::class);
    }

    public function attachment(string $locale)
    {
        // dd($this->attachments);
        $attachment = $this->attachments()
            ->where('locale', $locale)
            ->first();

        // dd($attachment);

        return $attachment;
    }

    /**
     * Get all of translations for the blog post.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function keywords(string $locale)
    {
        return $this->translation($locale, 'keywords');
    }

    public function description(string $locale)
    {
        return $this->translation($locale, 'description');
    }

    public function metaTitle(string $locale)
    {
        return $this->translation($locale, 'metaTitle');
    }

    public function title(string $locale)
    {
        return $this->translation($locale, 'title');
    }

    public function content(string $locale)
    {
        return $this->translation($locale, 'content');
    }

    private function translation(string $locale, string $field)
    {
        // dd($this->translations);
        $translation = $this->translations()
            ->where('locale', $locale)
            ->where('field', $field)
            ->first();

        // dd($translation);

        return $translation ? $translation->translation : '';
    }
}
