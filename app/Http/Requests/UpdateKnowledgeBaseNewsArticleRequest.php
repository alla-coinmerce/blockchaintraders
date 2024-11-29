<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKnowledgeBaseNewsArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.nl' => [
                'required',
                Rule::unique('knowledge_base_news_articles', 'title')->ignore($this->knowledgebase_news)
            ],
            'title.*' => 'string|max:255|nullable',

            'content' => 'required|array',
            'content.nl' => 'required',
            'content.*' => 'string|nullable',

            'status'=> 'required|in:draft,published',
            'featured_image' => 'mimes:jpg,jpeg,png,bmp|file|mimetypes:image/bmp,image/jpeg,image/jpg,image/x-png,image/png|nullable',
            'full_width_featured_image' => 'mimes:jpg,jpeg,png,bmp|file|mimetypes:image/bmp,image/jpeg,image/jpg,image/x-png,image/png|nullable',
            'bottom_image' => 'mimes:jpg,jpeg,png,bmp|file|mimetypes:image/bmp,image/jpeg,image/jpg,image/x-png,image/png|nullable',
            'bottom_video' => 'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|nullable',
            'bottom_video_poster' => 'mimes:jpg,jpeg,png,bmp|file|mimetypes:image/bmp,image/jpeg,image/jpg,image/x-png,image/png|nullable',

            'post_attachment' =>'array',
            'post_attachment.*' =>'mimes:pdf|file|mimetypes:application/pdf',
        ];
    }
}
