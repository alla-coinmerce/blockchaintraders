<x-admin.layout>
    <h1>Create Participation for {{ $user->firstname }} {{ $user->lastname }}</h1>

    <section>
        <livewire:participation-create :user="$user" />
    </section>
</x-admin.layout>