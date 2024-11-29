<x-admin.layout>
    
    <h1>Knowledge Base Subscribers</h1>

    <section>
        <table>
            <thead>
                <tr>
                    <th class="align-left">Name</th>
                    <th class="align-left">Email</th>
                    <th class="align-left">Subscription</th>
                    <th class="align-left">Last login</th>
                    <th class="align-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->subscription('knowlegde_base')->plan }} 
                            @if ( $user->subscription('knowlegde_base')->cancelled())
                                (cancelled)
                            @endif
                        </td>
                        <td>{{ $user->last_login }}</td>
                        <td class="align-right">
                            <div class="tooltip">
                                <a href="{{ route('users.show', ['user' => $user]) }}"><i class="fa fa-eye fa-fw"></i></a>
                                <span class="tooltiptext">view</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <form id="resend_welcome_notification_form" action="" method="POST">
            @csrf
            @method('PUT')
        </form>

        <script>
            function resend_welcome_notification( action )
            {
                event.preventDefault();

                $('#resend_welcome_notification_form').attr('action', action).submit();
            }
        </script>

        <form id="activate_user_form" action="" method="POST">
            @csrf
            @method('PUT')
        </form>

        <script>
            function activate_user( action )
            {
                event.preventDefault();

                $('#activate_user_form').attr('action', action).submit();
            }
        </script>

        <form id="delete_user_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function delete_user( action, name )
            {
                event.preventDefault();

                if (confirm("Delete user: '" + name + "' and all it's values.") == true)
                {
                    $('#delete_user_form').attr('action', action).submit();
                } 
            }
        </script>

    </section>

</x-admin.layout>