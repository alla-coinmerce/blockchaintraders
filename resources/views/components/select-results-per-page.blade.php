<label for="paginate">Results per page:</label>

<select wire:model="paginate" wire:change="change">
  <option value='10'>10</option>
  <option value='25'>25</option>
  <option value='50'>50</option>
  <option value='100'>100</option>
</select>
