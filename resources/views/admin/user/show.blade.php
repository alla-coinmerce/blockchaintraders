<x-admin.layout>
    
    <h1>{!! $user->active ? '' : '<span class="new">NEW </span>' !!}User{!! $user->demo_account ? ' <span class="demo">- DEMO ACCOUNT</span>' : '' !!}</h1>

    <section>

        <h2>Details</h2>

        <table>
            <tbody>
                <tr>
                    <th>Name:</th>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role:</th>
                    <td>{{ \App\Enums\Role::from($user->role)->label() }}</td>
                </tr>
                <tr>
                    <th>Type:</th>
                    <td>{{ ucfirst($user->registration_type) }}</td>
                </tr>
                <tr>
                    <th>Company name:</th>
                    <td>{{ $user->company_name }}</td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th>Zipcode:</th>
                    <td>{{ $user->zipcode }}</td>
                </tr>
                <tr>
                    <th>City:</th>
                    <td>{{ $user->city }}</td>
                </tr>
                <tr>
                    <th>Country:</th>
                    <td><x-country-from-code :alpha2Code="$user->country_code"/></td>
                </tr>
                <tr>
                    <th>Nationality:</th>
                    <td><x-country-from-code :alpha2Code="$user->nationality_code"/></td>
                </tr>
                <tr>
                    <th>Phone number:</th>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <th>Date of birth:</th>
                    <td>{{ $user->birthdate }}</td>
                </tr>
                <tr>
                    <th>Country of birth:</th>
                    <td><x-country-from-code :alpha2Code="$user->birth_country_code"/></td>
                </tr>
                <tr>
                    <th>Living in the Netherlands:</th>
                    <td>{{ $user->living_in_netherlands ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Source of income:</th>
                    <td>{{ $user->source_of_income }}</td>
                </tr>
                <tr>
                    <th>Taxable countries:</th>
                    <td>{{ $user->taxable_countries }}</td>
                </tr>
                <tr>
                    <th>Citizen Service Number:</th>
                    <td>{{ $user->bsn }}</td>
                </tr>
                <tr>
                    <th>Bank account number:</th>
                    <td>{{ $user->bank_account_number }}</td>
                </tr>
                <tr>
                    <th>CoC number:</th>
                    <td>{{ $user->coc_number }}</td>
                </tr>
                <tr>
                    <th>Demo account:</th>
                    <td>{!! $user->demo_account ? 'Yey' : 'No' !!}</td>
                </tr>
                <tr>
                    <th>Notes:</th>
                    <td style="white-space: pre-line">{{ $user->notes }}</td>
                </tr>
            </tbody>
        </table>

        <a class="button" href="{{ route('users.edit', ['user' => $user]) }}">Edit</a> 

        @if(!$user->active)
            <a class="button" href="{{ route('users.activate', ['user' => $user]) }}" onclick="activate_user('{{ route('users.activate', ['user' => $user]) }}')">ACTIVATE</a>
        @endif
               
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

    </section>

    <section>
        <h2>Documents</h2>

        <a class="button" href="{{ route('users.documents.create', ['user' => $user]) }}">New Document</a>

        <table>
            <thead>
                <tr>
                    <th class="align-left">Name</th>
                    <th class="align-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->documents as $document)
                    <tr>
                        <td class="align-left">
                            <a href="{{ route('document', ['document' => $document, 'display_name' => $document->display_name]) }}" target="_blank" rel="noopener noreferrer">
                                {{ $document->display_name }}
                            </a>
                        </td>
                        <td class="align-right">
                            <div class="tooltip">
                                <a href="{{ route('users.documents.destroy', ['user' => $user, 'document' => $document]) }}" onclick="delete_document('{{ route('users.documents.destroy', ['user' => $user, 'document' => $document]) }}', '{{ $document->name }}')"
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

        <form id="delete_document_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    
        <script>
            function delete_document( action, name )
            {
                event.preventDefault();
    
                if (confirm("Delete document: '" + name + "'") == true)
                {
                    $('#delete_document_form').attr('action', action).submit();
                } 
            }
        </script>
    </section>

    <section>
        <h2>Personal documents</h2>

        <a class="button" href="{{ route('users.annualFinancialOverviews.create', ['user' => $user]) }}">New Personal Document</a>

        <table>
            <thead>
                <tr>
                    <th class="align-left">Name</th>
                    <th class="align-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->annualfinancialoverviews as $annualfinancialoverview)
                    <tr>
                        <td class="align-left">
                            <a href="{{ route('annualFinancialOverview', ['annualFinancialOverview' => $annualfinancialoverview, 'name' => $annualfinancialoverview->original_file_name]) }}" target="_blank" rel="noopener noreferrer">
                                {{ $annualfinancialoverview->original_file_name }}
                            </a>
                        </td>
                        <td class="align-right">
                            <div class="tooltip">
                                <a href="{{ route('users.annualFinancialOverviews.destroy', ['user' => $user, 'annualFinancialOverview' => $annualfinancialoverview]) }}" onclick="delete_annualfinancialoverview('{{ route('users.annualFinancialOverviews.destroy', ['user' => $user, 'annualFinancialOverview' => $annualfinancialoverview]) }}', '{{ $annualfinancialoverview->year }}')"
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

        <form id="delete_annualfinancialoverview_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    
        <script>
            function delete_annualfinancialoverview( action, name )
            {
                event.preventDefault();
    
                if (confirm("Delete annual financial overview for: '" + name + "'") == true)
                {
                    $('#delete_annualfinancialoverview_form').attr('action', action).submit();
                } 
            }
        </script>
    </section>

    <section>
        <h2>Knowledge Base Subscription</h2>

        @if ($subscription)
            <p>
                Subscription: {{ $subscription->plan }}
                @if ( $subscription->cancelled())
                    (cancelled)
                @endif
            </p>
            
            @if ( !$subscription->cancelled())
                <p>Renews on: {{ $subscription->cycle_ends_at->format('d-m-Y') }}</p>
                <button onclick="cancelSubscription()">Cancel subscription</button>
            @endif

            @push('foot')
                <form id="delete_form" action="{{ route('knowledgebase.subscription.cancel', ['user' => $user]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>

                <script>
                    function cancelSubscription()
                    {
                        event.preventDefault();

                        if(confirm('Cancel subscription') == true)
                        {
                            $('#delete_form').submit();
                        } 
                    }
                </script>
            @endpush
        @else
            <p>No subscription</p>
        @endif

        @foreach($user->orders as $order)
            @if ($loop->first)
                <h3>Invoices</h3>
                <ul class="list-unstyled">
            @endif
                <li>
                    <a href="/user/{{ $user->id }}/download-invoice/{{ $order->id }}">
                        {{ $order->invoice()->id() }} -  {{ $order->invoice()->date() }}
                    </a>
                </li>
            @if ($loop->last)
                </ul>
            @endif
        @endforeach   
    </section>

    <section id="participations">
        <h2>Participations</h2>

        <a class="button" href="{{ route('users.participations.create', ['user' => $user]) }}">New Participation</a>
        
        @forelse($user->funds as $fund)
            <div>
                <h3>{{ $fund->name }}</h3>
               
                <table>
                    <thead>
                        <tr>
                            <th class="align-left">Purchase Date</th>
                            <th class="align-left">Tag</th>
                            <th class="align-right">Qty</th>
                            <th class="align-right">Purchase value</th>
                            <th class="align-right">Current value</th>
                            <th class="align-right">Total value</th>
                            <th class="align-right">Achieved return</th>
                            <th class="align-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fund->participations as $participation)
                                <tr>
                                    <td class="align-left">{{ $participation->purchase_date }}</td>
                                    <td class="align-left">{{ $participation->tag->name }}</td>
                                    <td class="align-right">{{ $participation->qty }}</td>
                                    <td class="align-right">{{ $participation->display_value_euros_purchase_date }}</td>
                                    <td class="align-right">{{ $fund->currentFundValue->display_value_euros }}</td>
                                    <td class="align-right">{{ $participation->display_value_euros_current_date_total }}</td>
                                    <td @class([
                                        'align-right',
                                        'negative' => $participation->achieved_return < 0,
                                        'positive' => $participation->achieved_return >= 0
                                    ])>
                                        {{ $participation->achieved_return }}%
                                    </td>
                                    <td class="align-right">
                                        <div class="tooltip">
                                            <a href="{{ route('users.participations.edit', ['user' => $user, 'participation' => $participation]) }}"><i class="fa fa-user fa-pen"></i></a>
                                            <span class="tooltiptext">edit</span>
                                        </div>
                                        <div class="tooltip">
                                            <a href="{{ route('users.participations.destroy', ['user' => $user, 'participation' => $participation]) }}" onclick="delete_participation('{{ route('users.participations.destroy', ['user' => $user, 'participation' => $participation]) }}', '{{ $participation->purchase_date }}')"
                                                ><i class="fa fa-user fa-trash"></i>
                                            </a>
                                            <span class="tooltiptext">delete</span>
                                        </div>
                                    </td>
                                </tr>
                        @empty
                            <tr>
                                <td colspan="7">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <th class="align-right">Totals</th>
                        <td></td>
                        <td class="align-right">{{ $fund->participations_qty }}</td>
                        <td></td>
                        <td></td>
                        <td class="align-right">{{ $fund->participations_total_value }}</td>
                        <td @class([
                            'align-right',
                            'negative' => $fund->participations_total_achieved_return < 0,
                            'positive' => $fund->participations_total_achieved_return >= 0
                        ])>
                            {{ $fund->participations_total_achieved_return }}%
                        </td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
        @empty
            <tr>
                <td colspan="7">No records found.</td>
            </tr>
        @endforelse

        <form id="delete_participation_form" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    
        <script>
            function delete_participation( action, name )
            {
                event.preventDefault();
    
                if (confirm("Delete participation of: '" + name + "'") == true)
                {
                    $('#delete_participation_form').attr('action', action).submit();
                } 
            }
        </script>

    </section>

</x-admin.layout>