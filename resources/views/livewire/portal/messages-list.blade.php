<div>

    <p class="filters">
        <label for="start_date">From</label>
        <input wire:model="start_date" wire:change="change" type="date">

        <label for="end_date">To</label>
        <input wire:model="end_date" wire:change="change" type="date">

        <x-select-results-per-page />
    </p>
    
    <table>
        <thead>
            <tr>
                <th class="align-left"><i class="fa fa-envelope fa-fw"></i></th>
                <th class="align-left">From</th>
                <th class="align-left">Subject</th>
                <th class="align-left"><i class="fa fa-calendar fa-fw"></i></th>
                <th class="align-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($messages as $message)
                <tr>
                    <td class="align-left">
                        <div class="tooltip">
                            <a href="{{ route('messages.update', ['message' => $message]) }}" onclick="update_message('{{ route('messages.update', ['message' => $message]) }}')">
                                <i @class([
                                    'fa',
                                    'fa-envelope' => !$message->read,
                                    'fa-envelope-open' => $message->read,
                                    'fa-fw'
                                ])></i>
                            </a>
                            <span class="tooltiptext">Read / Unread</span>
                        </div>
                    </td>
                    <td class="align-left">
                        <div class="tooltip">
                            <a href="{{ route('messages.show', ['message' => $message]) }}">{{ $message->name }}</a>
                            <span class="tooltiptext">{{ $message->email }}</span>
                        </div>
                    </td>
                    <td class="align-left"><a href="{{ route('messages.show', ['message' => $message]) }}">{{ $message->subject }}</a></td>
                    <td class="align-left"><a href="{{ route('messages.show', ['message' => $message]) }}">{{ $message->created_at }}</a></td>
                    <td class="align-right">
                        <div class="tooltip">
                            <a href="{{ route('messages.show', ['message' => $message]) }}"><i class="fa fa-user fa-eye"></i></a>
                            <span class="tooltiptext">view</span>
                        </div>
                        <div class="tooltip">
                            <a href="{{ route('messages.destroy', ['message' => $message]) }}" onclick="delete_message('{{ route('messages.destroy', ['message' => $message]) }}', '{{ $message->name }}')"
                                ><i class="fa fa-user fa-trash"></i>
                            </a>
                            <span class="tooltiptext">delete</span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $messages->links('components.pagination') }}

    <form id="update_message_form" action="" method="POST">
        @csrf
        @method('PUT')
    </form>
    
    <script>
        function update_message( action )
        {
            event.preventDefault();
    
            $('#update_message_form').attr('action', action).submit();
        }
    </script>
    
    <form id="delete_message_form" action="" method="POST">
        @csrf
        @method('DELETE')
    </form>
    
    <script>
        function delete_message( action, name )
        {
            event.preventDefault();
    
            if (confirm("Delete message: '" + name + "'.") == true)
            {
                $('#delete_message_form').attr('action', action).submit();
            } 
        }
    </script>
</div>
