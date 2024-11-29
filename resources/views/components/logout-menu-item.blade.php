@props(['menuName' => 'Uitloggen'])

<a class="logout" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    {{ $menuName }} <i class="fa-solid fa-arrow-right-from-bracket"></i>
</a>