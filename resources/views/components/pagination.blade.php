<div>
    @if ($paginator->hasPages())
        <nav class="pagination">
           
            <p class="text-sm text-gray-700 leading-5">
                {{-- Previous Page Link --}}
                @unless ($paginator->onFirstPage())
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                        {!! __('pagination.previous') !!}
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
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                        {!! __('pagination.next') !!}
                    </button>
                @endif

            </p>

        </nav>
    @endif
</div>