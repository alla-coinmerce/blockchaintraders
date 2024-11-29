@props([
    'url'
])

<div class="downloadItem">
    <div class="downloadItemTitleContainer">
        <img src="/assets/images/portal/knowledge_base/article/icon-document.svg" alt="icon">

        <h2>{{  $slot }}</h2>
    </div>

    <a href="{{ $url }}">Download <i class="fa fa-arrow-down fa-fw"></i></a>
</div>