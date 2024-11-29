<x-admin.layout>
    
    <h1>Users</h1>

    <section>

        <a class="button" href="{{ route('users.create') }}">New User</a>

        <table>
            <thead>
                <tr>
                    <th class="align-left">Name</th>
                    <th class="align-left">Email</th>
                    <th class="align-left">Role</th>
                    <th class="align-left">2FA</th>
                    <th class="align-left">Last login</th>
                    <th class="align-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ $user->firstname }}  {{ $user->lastname }}
                            {!! $user->active ? '' : ' <span class="new">NEW</span>' !!}
                            {!! $user->demo_account ? ' <span class="demo">- DEMO</span>' : '' !!}
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ \App\Enums\Role::from($user->role)->label() }}</td>
                        <td>
                            <i @class([
                                    'fa',
                                    'fa-check' => $user->hasTwoFactorEnabled(),
                                    'fa-fw'
                                ])>
                            </i>
                        </td>
                        <td>{{ $user->last_login }}</td>
                        <td class="align-right">
                            @if($user->active && $user->welcome_valid_until !== null)
                                <div class="tooltip">
                                    <a href="{{ route('users.resendWelcomeNotification', ['user' => $user]) }}" onclick="resend_welcome_notification('{{ route('users.resendWelcomeNotification', ['user' => $user]) }}')">
                                        <span class="fa-stack" style="vertical-align: middle; font-size: 0.8em;">
                                            <i class="fa fa-rotate-right fa-stack-2x fa-fw"></i>
                                            <i class="fa fa-envelope fa-stack-1x fa-fw"></i>
                                        </span>
                                    </a>
                                    <span class="tooltiptext">resend welcome email</span>
                                </div>
                            @endif
                            @if(!$user->active)
                                <div class="tooltip">
                                    <a href="{{ route('users.activate', ['user' => $user]) }}" onclick="activate_user('{{ route('users.activate', ['user' => $user]) }}')">
                                        <span class="fa-stack" style="vertical-align: middle; font-size: 0.8em;">
                                            <i class="fa-regular fa-circle fa-stack-2x fa-fw"></i>
                                            <i class="fa-solid fa-check fa-stack-1x fa-fw"></i>
                                        </span>
                                    </a>
                                    <span class="tooltiptext">activate</span>
                                </div>
                            @endif
                            <div class="tooltip">
                                <a href="{{ route('users.show', ['user' => $user]) }}"><i class="fa fa-eye fa-fw"></i></a>
                                <span class="tooltiptext">view</span>
                            </div>
                            <div class="tooltip">
                                <a href="{{ route('users.edit', ['user' => $user]) }}"><i class="fa fa-pen fa-fw"></i></a>
                                <span class="tooltiptext">edit</span>
                            </div>
                            <div class="tooltip">
                                <a href="{{ route('users.destroy', ['user' => $user]) }}" onclick="delete_user('{{ route('users.destroy', ['user' => $user]) }}', '{{ $user->firstname }}  {{ $user->lastname }}')"
                                    ><i class="fa fa-trash fa-fw"></i>
                                </a>
                                <span class="tooltiptext">delete</span>
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

                if (confirm("Delete user: '" + name + "' and all it's data.") == true)
                {
                    $('#delete_user_form').attr('action', action).submit();
                } 
            }
        </script>

    </section>

</x-admin.layout>