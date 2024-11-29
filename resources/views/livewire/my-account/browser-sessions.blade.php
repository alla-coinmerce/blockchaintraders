<section>
    <h2>Browser Sessies</h2>

    <p>Uw actieve sessies op andere browsers en apparaten.</p>

    <p>Indien nodig kunt u zich afmelden bij al uw andere browsersessies in al uw
        apparaten. Enkele van uw recente sessies staan ​​hieronder vermeld; deze lijst is echter mogelijk niet
        uitputtend. Als u denkt dat uw account is gecompromitteerd, moet u ook uw
        wachtwoord updaten.
    </p>

    @if(count($sessions) > 0)
        <table>
            @foreach ($sessions as $session)
                <tr>
                    <th>
                        <i class="fa fa-desktop fa-2xl"></i>
                    </th>
                    <td>
                        {!!  $session !!}
                    </td>
                </tr>
            @endforeach
            </table>
    @endif

    @if($askPassword)
        <form wire:submit.prevent="logoutAllSessions">
            <p>
                <label for="password">Wachtwoord</label>
                <input type="text" wire:model="password" class="@error('password') is-invalid @enderror">

                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>
            
            <button type="submit">Bevestigen</button>
        </form> 
    @else
        <button wire:click="logoutAllSessionsPassword">Uitloggen op alle andere apparaten</button>
    @endif

    
    
</section>