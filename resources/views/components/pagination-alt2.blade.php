<div>
    @if ($paginator->hasPages())
        <nav class="pagination">
           
            <p class="text-sm text-gray-700 leading-5">
                {{-- Previous Page Link --}}
                @unless ($paginator->onFirstPage())
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="page-link-scroll-to-top">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @endif

                <span>{!! __('Showing') !!}</span>
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                <span>{!! __('to') !!}</span>
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $paginator->total() }}</span>
                <span>{!! __('results') !!}</span>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="page-link-scroll-to-top">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif

            </p>

        </nav>

        <script>
            $(document).on('click', '.page-link-scroll-to-top', function (e) {
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            });
        </script>
    @endif
</div>