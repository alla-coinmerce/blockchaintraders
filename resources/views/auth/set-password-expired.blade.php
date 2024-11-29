<x-guest.layout>

    <h1>Link verlopen</h1>

    <p>De link is verlopen. U kunt een nieuwe link aanvragen via onderstaande knop.</p>

    <x-status-message/>

    <form method="POST" action="{{ $newSetPasswordLinkRoute }}">
        @csrf

        <input type="hidden" name="hash" value="{{ $hash }}">

        <input type="submit" value="Verstuur nieuwe link">
    </form>

</x-guest.layout>