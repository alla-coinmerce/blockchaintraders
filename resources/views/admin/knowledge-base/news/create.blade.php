<x-admin.layout class="posts">
    
    <h1>Create Knowledge Base News Article</h1>

    <section>

        <form method="POST" action="{{ route('knowledgebase-news.store') }}" enctype="multipart/form-data">
            @csrf

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
                            value="{{ old('title.'.$available_locale) }}" 
                            class="@error('title.'.$available_locale) is-invalid @enderror">

                        @error('title.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        <label for="content[{{ $available_locale }}]">Content:</label>
                        <textarea 
                            rows="20"
                            id="content[{{ $available_locale }}]" 
                            name="content[{{ $available_locale }}]" 
                            class="@error('content.'.$available_locale) is-invalid @enderror">{{ old('content.'.$available_locale) }}</textarea>

                        @error('content.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>

                    <p>
                        Attachment: <span id="current_post_attachment[{{ $available_locale }}]" >No attachment</span>

                        <label for="post_attachment[{{ $available_locale }}]" class="button">Select file</label>
                        <input 
                            type="file" 
                            id="post_attachment[{{ $available_locale }}]" 
                            name="post_attachment[{{ $available_locale }}]" 
                            class="@error('post_attachment.'.$available_locale) is-invalid @enderror"
                            onchange="update('post_attachment[{{ $available_locale }}]')"
                            style="display: none;">

                        <button type="button" onclick="resetElement('post_attachment[{{ $available_locale }}]')">Remove</button>
        
                        @error('post_attachment.'.$available_locale)
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </p>
                </div>
            @endforeach

            <x-admin.image-upload name="featured_image" label="Featured image (used in blog grid and on mobile)" maxWidth="400px" />

            <x-admin.image-upload name="full_width_featured_image" label="Full width featured image (used on desktop)" maxWidth="100%" />

            <x-admin.image-upload name="bottom_image" label="Bottom image" maxWidth="100%" />

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
            
                @error('bottom_video')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            
                <button type="button" onclick="resetVideo()">Remove</button>
            
                <div class="previewbox" style="max-width:100%;">
                    <video controls id="video_preview" style="display:none;">
                        <source src="#" id="video_preview_source">
                        Your browser does not support HTML5 video.
                    </video>
                    <p id="no_bottom_video_preview" class="preview_placeholder">Preview</p>
                </div>
            </div>

            <x-admin.image-upload name="bottom_video_poster" label="Video preview image" maxWidth="100%" />
            
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
                    $('#video_preview_source').attr("src", "#");
            
                    $('#video_preview').hide();

                    $('#no_bottom_video_preview').show();
                }
            </script>

            <p>Status:</p>
            <input type="radio" id="draft" name="status" value="draft" @checked(old('status', 'draft') === 'draft')>
            <label for="draft">Draft</label><br>
            <input type="radio" id="published" name="status" value="published" @checked(old('status') === 'published')>
            <label for="published">Published</label><br>

            @error('status')
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror

            <input type="submit" value="Create">
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
            document.getElementById('current_' + id).textContent = file.name;
        }

        function resetElement(id)
        {
            document.getElementById(id).value = "";
            document.getElementById('current_' + id).textContent = "";
        }

        function updatePreview(element, id)
        {
            const [file] = $(element).prop('files');
            if (file)
            {
                $('#' + id).show();

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
                tablinks[i].className = tablinks[i].className.replace("active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

    <x-admin.ckeditor-script :available_locales="$available_locales"/>
</x-admin.layout>