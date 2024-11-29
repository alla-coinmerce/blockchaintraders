<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeBaseNewsArticleAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'knowledge_base_news_article_id',
        'locale',
        'original_file_name',
        'storage_path'
    ];

    /**
     * Get the KnowledgeBaseArticle that owns the attachment
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(KnowledgeBaseNewsArticle::class);
    }
}
