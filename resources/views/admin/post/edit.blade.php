<x-admin.layout class="posts">
    
    <h1>Edit Post</h1>

    <section>

        <p>Created at: {{ $post->created_at }}</p>
        <p>Status: {{  $post->published ? 'published' : 'draft' }}</p>
        @if ($post->published)
            <p>Publication date: {{ $post->publication_date }}</p>
        @endif

        <form method="POST" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

             <!-- Tab links -->
             <div class="tab">
                @foreach($available_locales as $locale_name => $available_locale)
                    <button @class([
                        'tablink',
                        'active' => $loop->first
                    ]) onclick="openTab(event, '{{ $locale_name }}')">{{ $locale_name }}</button>
                @endforeach
            </div>

            <!-- Tab content -->
            @foreach($available_locales as $locale_name => $available_locale)
                <div id="{{ $locale_name }}" class="tabcontent" @if(!$loop->first)style="display: none;"@endif>
                    <p>
                        <label for="title[{{ $available_locale }}]">Title:</label>
                        <input 
                            type="text" 
                            id="title[{{ $available_locale }}]" 
                            name="title[{{ $available_locale }}]" 
                            value="{{ old('title.'.$available_locale, $post->title($available_locale)) }}" 
                            class="@error('title.'.$available_locale) is-invalid @enderror">

                        @error('title.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        <label for="metaTitle[{{ $available_locale }}]">Meta title:</label>
                        <input 
                            type="text" 
                            id="metaTitle[{{ $available_locale }}]" 
                            name="metaTitle[{{ $available_locale }}]" 
                            value="{{ old('metaTitle.'.$available_locale, $post->metaTitle($available_locale)) }}" 
                            class="@error('metaTitle.'.$available_locale) is-invalid @enderror">

                        @error('metaTitle.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        <label for="keywords[{{ $available_locale }}]">Meta keywords:</label>
                        <input 
                            type="text" 
                            id="keywords[{{ $available_locale }}]" 
                            name="keywords[{{ $available_locale }}]" 
                            value="{{ old('keywords.'.$available_locale, $post->keywords($available_locale)) }}" 
                            class="@error('keywords.'.$available_locale) is-invalid @enderror">

                        @error('keywords.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        <label for="description[{{ $available_locale }}]">Meta description:</label>
                        <input 
                            type="text" 
                            id="description[{{ $available_locale }}]" 
                            name="description[{{ $available_locale }}]" 
                            value="{{ old('description.'.$available_locale, $post->description($available_locale)) }}" 
                            class="@error('description.'.$available_locale) is-invalid @enderror">

                        @error('description.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        <label for="content[{{ $available_locale }}]">Content:</label>
                        <textarea 
                            rows="20"
                            id="content[{{ $available_locale }}]" 
                            name="content[{{ $available_locale }}]" 
                            class="@error('content.'.$available_locale) is-invalid @enderror">{{ old('content.'.$available_locale, $post->content($available_locale)) }}</textarea>

                        @error('content.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        Attachment: <span id="current_post_attachment[{{ $available_locale }}]" >{{  $post->attachment($available_locale) ? $post->attachment($available_locale)->original_file_name : 'No attachment' }}</span>

                        <label for="post_attachment[{{ $available_locale }}]" class="button">Select file</label>
                        <input 
                            type="file" 
                            id="post_attachment[{{ $available_locale }}]" 
                            name="post_attachment[{{ $available_locale }}]" 
                            class="@error('post_attachment.'.$available_locale) is-invalid @enderror"
                            onchange="update('post_attachment[{{ $available_locale }}]')"
                            style="display: none;">
                        <input 
                            type="hidden" 
                            name="current_post_attachment[{{ $available_locale }}]" 
                            id="input_current_post_attachment[{{ $available_locale }}]" 
                            value="{{ $post->attachment($available_locale) ? $post->attachment($available_locale)->original_file_name : '' }}"
                            readonly>
                        

                        <button type="button" onclick="resetElement('post_attachment[{{ $available_locale }}]')">Remove</button>
        
                        @error('post_attachment.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>
                </div>
            @endforeach

            <x-admin.image-upload-edit 
                name="featured_image" 
                label="Featured image (used in blog grid and on mobile)" 
                value="{{ $post->featured_img_storage_path ? \Illuminate\Support\Facades\Storage::url($post->featured_img_storage_path) : ''}}"
                url="{{ $post->featured_img_storage_path ? \Illuminate\Support\Facades\Storage::url($post->featured_img_storage_path) : ''}}"
                maxWidth="400px" />

            <x-admin.image-upload-edit 
                name="full_width_featured_image" 
                label="Full width featured image (used on desktop)" 
                value="{{ $post->featured_img_fw_storage_path ? \Illuminate\Support\Facades\Storage::url($post->featured_img_fw_storage_path) : ''}}"
                url="{{ $post->featured_img_fw_storage_path ? \Illuminate\Support\Facades\Storage::url($post->featured_img_fw_storage_path) : ''}}"
                maxWidth="100%" />

            <x-admin.image-upload-edit 
                name="bottom_image" 
                label="Bottom image" 
                value="{{ $post->bottom_img_storage_path ? \Illuminate\Support\Facades\Storage::url($post->bottom_img_storage_path) : ''}}"
                url="{{ $post->bottom_img_storage_path ? \Illuminate\Support\Facades\Storage::url($post->bottom_img_storage_path) : ''}}"
                maxWidth="100%" />

            <div class="upload_with_preview">
                Video:
                <label for="bottom_video" class="button">Select file</label>
                <input 
                    type="file" 
                    name="bottom_video" 
                    id="bottom_video" 
                    class="@error('bottom_video') is-invalid @enderror"
                    onchange="updateVideoPreview(this)"
                    style="display: none;">
                <input 
                    type="hidden" 
                    name="current_bottom_video" 
                    id="current_bottom_video" 
                    value="{{ $post->bottom_video_storage_path }}">
            
                @error('bottom_video')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            
                <button type="button" onclick="resetVideo()">remove</button>
            
                <div class="previewbox" style="max-width:100%;">
                    <video controls id="video_preview" style="{{  $post->bottom_video_storage_path ? '' : 'display:none;' }}">
                        <source 
                            src="{{ $post->bottom_video_storage_path ? \Illuminate\Support\Facades\Storage::url($post->bottom_video_storage_path) : '' }}" 
                            id="video_preview_source">
                        Your browser does not support HTML5 video.
                    </video>
                    <p id="no_bottom_video_preview" class="preview_placeholder" @if(!empty($post->bottom_video_storage_path)) style="display: none;" @endif>Preview</p>
                </div>
            </div>
            
            <script>
                function updateVideoPreview(element)
                {
                    const [file] = $(element).prop('files');
                    if (file)
                    {
                        $('#video_preview').show();

                        $('#video_preview_source').attr("src", URL.createObjectURL(file));

                        $('#video_preview')[0].load();

                        $('#no_bottom_video_preview').hide();
                    }
                }

                function resetVideo()
                {
                    $('#current_bottom_video').val("");

                    $('#video_preview_source').attr("src", "#");
            
                    $('#video_preview').hide();

                    $('#no_bottom_video_preview').show();
                }
            </script>

            <p>Status:</p>
            <input type="radio" id="draft" name="status" value="draft" @checked(old('status', $post->published ?  'published' : 'draft') === 'draft')>
            <label for="draft">Draft</label><br>
            <input type="radio" id="published" name="status" value="published" @checked(old('status', $post->published ?  'published' : 'draft') === 'published')>
            <label for="published">Published</label><br>

            @error('status')
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror

            <input type="submit" name="action_save" value="Save">
            <input type="submit" name="action_save_and_preview" value="Save and Preview">
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
    </section>

    <script>
        function update(id)
        {
            fileInputElement = document.getElementById(id);
            file = fileInputElement.files[0];
            document.getElementById('input_current_' + id).value = file.name;
            document.getElementById('current_' + id).textContent = file.name;
        }

        function resetElement(id)
        {
            document.getElementById(id).value = "";
            document.getElementById('input_current_' + id).value = "";
            document.getElementById('current_' + id).textContent = "";
        }
   
        function updatePreview(element, id)
        {
            const [file] = $(element).prop('files');
            if (file)
            {
                $('#' + id).show();
                
                $('#current_' + $(element).attr('id')).val(file.name);

                $('#' + id).attr("src", URL.createObjectURL(file));

                $('#no_' + id).hide();
            }
        }

        function openTab(evt, cityName)
        {
            evt.preventDefault();

            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <x-admin.ckeditor-script :available_locales="$available_locales"/>
</x-admin.layout>