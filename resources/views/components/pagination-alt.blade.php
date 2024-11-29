<div>
    @if ($paginator->hasPages())
        <nav class="pagination">
           
            <p>
                {{-- Previous Page Link --}}
                @unless ($paginator->onFirstPage())
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                        <i class="fa-solid fa-angle-left"></i>
                    </button>
                @endif

                <span class="font-medium">{{ $paginator->currentPage() }}</span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $paginator->lastPage() }}</span>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                        <i class="fa-solid fa-angle-right"></i>
                    </button>
                @endif
            </p>
            
        </nav>
    @endif
</div>