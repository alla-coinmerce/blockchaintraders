<div>
    <form wire:submit.prevent="submit">
        <p>Required fields are followed by <span aria-label="required">*</span>.</p>

        
            <p>
                <label for="selectedFundId">Fund: <span aria-label="required">*</span></label>
                <select name="selectedFundId" wire:model="selectedFundId" wire:change="selectedFundChanged" class="@error('selectedFundId') is-invalid @enderror">
                    <option value="" disabled selected>-- Select a fund --</option>
                    @foreach($selectableFunds as $selectableFund)
                        <option value="{{ $selectableFund->id }}">
                            {{ $selectableFund->name }}
                        </option>
                    @endforeach
                </select>

                @error('selectedFundId')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="purchaseMoment">Purchase moment: <span aria-label="required">*</span></label>
                <select name="purchaseMoment" wire:model="purchaseMoment" class="@error('purchaseMoment') is-invalid @enderror">
                    <option value="" disabled selected>-- Select a purchase moment --</option>
                    @foreach($availablePurchaseMoments as $fundValue)
                        <option value="{{ $fundValue->id }}">
                            {{ $fundValue->date }} - {{ $fundValue->timeEuropeAmsterdam }} ({{ $fundValue->DisplayValueEuros }})
                        </option>
                    @endforeach
                </select>

                @error('purchaseMoment')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="qty">Quantity: <span aria-label="required">*</span></label>
                <input type="number" step="0.0001" inputmode="decimal" name="qty" wire:model="qty" class="@error('qty') is-invalid @enderror">

                @error('qty')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>
        

        <p>
            <label for="tag">Tag:</label>
            <input list="tags" type="text" name="tag" wire:model="tag" class="@error('tag') is-invalid @enderror">
            <datalist id="tags">
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}">
                @endforeach
            </datalist>

            @error('tag')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </p>

        <input type="submit" value="Add to list">
    </form>
</div>
