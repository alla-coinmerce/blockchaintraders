<x-layout {{ $attributes }} class="admin">

    @push('vite')
        @vite(['resources/js/admin.js'])
    @endpush

    @push('meta')
        <meta name="description" content="BlockchainTraders administrative area.">
    @endpush

    @push('scripts')
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    @endpush

    <x-slot:title>
        {{ $title ?? 'Admin BlockchainTraders' }}
    </x-slot>

    <header>
        <nav>
            <a href="/"><img src="/assets/images/Logo.svg" alt="Logo BlockchainTraders" width="56" height="46"></a>

            <div id="header-nav-right">
                <a href="{{ route('funds.index') }}"><i class="fa fa-user fa-chart-line"></i>&nbsp; Funds</a>
                <a href="{{ route('users.index') }}"><i class="fa fa-user fa-fw"></i>&nbsp; Users</a>
                <a href="{{ route('tags.index') }}"><i class="fa fa-tags fa-fw"></i>&nbsp; Tags</a>
                <a href="{{ route('posts.index') }}"><i class="fa-solid fa-blog fa-fw"></i>&nbsp; Posts</a>

                <div class="dropdown">
                    <div class="dropdown_button"><i class="fa-solid fa-newspaper fa-fw"></i>&nbsp; Knowledge Base <i class="fa-solid fa-chevron-down fa-xs"></i></div>
                    <div class="dropdown_content">
                        <a href="{{ route('knowledgebase-news.index') }}">News</a>
                        <a href="{{ route('knowledgebase.assets') }}">Assets</a>
                        <a href="{{ route('knowledgebase.subscribers') }}">Subscribers</a>
                    </div>
                </div>
                
                <a href="{{ route('messages.index') }}"><i @class([
                        'fa',
                        'fa-envelope' => $unreadMessages,
                        'fa-envelope-open' => !$unreadMessages,
                        'fa-fw'
                    ])></i>&nbsp; {{ $unreadMessages ? $unreadMessages.' ' : '' }}Messages
                </a>
                <x-logout-menu-item menuName="Logout"/>
                <x-logout-form/>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

</x-layout>