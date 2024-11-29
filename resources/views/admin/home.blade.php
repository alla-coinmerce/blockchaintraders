<x-admin.layout>
    
    <h1>Dashboard</h1>

    <section>
        <h2>Funds</h2>
        
        <x-admin.funds-list/>
    </section>

    <x-admin.deribit-section />
    
    <section>
        <h2>Portal dashboard funds</h2>

        <form method="POST" action="{{ route('updateDashboardFunds') }}">
            @csrf
            @method('PUT')

            <p>
                <label for="dashboard_fund_1">Dashboard fund left: </label>
                <select id="dashboard_fund_1" name="dashboard_fund_1" class="@error('dashboard_fund_1') is-invalid @else is-valid @enderror">

                    @foreach ($funds as $fund)
                        <option value="{{ $fund->id }}" @selected(old('dashboard_fund_1', $dashboard_fund_1) == $fund->id)>
                            {{ $fund->name }}
                        </option>
                    @endforeach

                </select>

                @error('dashboard_fund_1')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="dashboard_fund_1_participation_start_date">Particiaption start date:</label>
                <input type="date" name="dashboard_fund_1_participation_start_date" value="{{ old('dashboard_fund_1_participation_start_date', $dashboard_fund_1_participation_start_date) }}">
            </p>

            <p>
                <label for="dashboard_fund_2">Dashboard fund right: </label>
                <select id="dashboard_fund_2" name="dashboard_fund_2" class="@error('dashboard_fund_2') is-invalid @else is-valid @enderror">

                    @foreach ($funds as $fund)
                        <option value="{{ $fund->id }}" @selected(old('dashboard_fund_2', $dashboard_fund_2) == $fund->id)>
                            {{ $fund->name }}
                        </option>
                    @endforeach

                </select>

                @error('dashboard_fund_2')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="dashboard_fund_2_participation_start_date">Particiaption start date:</label>
                <input type="date" name="dashboard_fund_2_participation_start_date" value="{{ old('dashboard_fund_2_participation_start_date', $dashboard_fund_2_participation_start_date) }}">
            </p>

            <input type="submit" value="Submit">
        </form>
    </section>

</x-admin.layout>