<div>
    @if (!$coinId)
        <div class="coin_search">
            <p><input type="text" id="search" name="search" wire:model="search" placeholder="Start typing to search" autofocus></p>

            <ul class="searchresults">
                @foreach ($coins as $id => $name)
                    <li class="searchresult" wire:click="selectCoin('{{ $id }}', '{{ $name }}')">
                        {{ $name }}
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <form wire:submit.prevent="submit">
            <p>Required fields are followed by <span aria-label="required">*</span>.</p>

            <p><label for="qty">Coin:</label>{{ $coinName }}</p>

            <p><label for="value">Value:</label>{{ $formattedCoinValue }}</p>

            <p>
                <label for="qty">Qty: <span aria-label="required">*</span></label>
                <input type="number" step="0.000001" id="qty" name="qty" wire:model="qty"
                    class="@error('name') is-invalid @enderror">

                @error('qty')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <button type="button" wire:click="test" wire:loading.attr="disabled">Test</button>
            <button type="button" wire:click="testFresh" wire:loading.attr="disabled">Test (refresh coins cache)</button>
            <input type="submit" value="Add to list">

            <div wire:loading.delay>
                Processing...
            </div>
        </form>
    @endif

    @if ($testResultsAvailable)
        {!! $testResultHtml !!}
    @endif
</div>
