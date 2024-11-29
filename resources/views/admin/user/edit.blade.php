<x-admin.layout>
    
    <h1>Edit User{!! $user->demo_account ? ' <span class="demo">- DEMO ACCOUNT</span>' : '' !!}</h1>

    <section>

        <form method="POST" action="{{ route('users.update', ['user' => $user]) }}">
            @csrf
            @method('PUT')

            <p>Required fields are followed by <span aria-label="required">*</span>.</p>

            <p>
                <label for="demo_account">Demo account: </label>
                <input type="checkbox" id="demo_account" name="demo_account" value="1" @checked(old('demo_account', $user->demo_account)) class="@error('demo_account') is-invalid @enderror">

                @error('demo_account')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="role">Role: <span aria-label="required">*</span></label>
                <select name="role" class="@error('role') is-invalid @enderror">
                    @foreach(\App\Enums\Role::cases() as $role)
                        <option value="{{ $role->value }}" @selected(old('role', $user->role) == $role->value)>
                            {{ $role->label() }}
                        </option>
                    @endforeach
                </select>

                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>  
                <label for="registration_type">Type: <span aria-label="required">*</span></label>
                    
                <input type="radio" id="private" name="registration_type" value="private" @checked(old('registration_type', $user->registration_type) === 'private') class="@error('registration_type') is-invalid @enderror">
                <label for="private">Private</label>
                <input type="radio" id="entity" name="registration_type" value="entity" @checked(old('registration_type', $user->registration_type) === 'entity') class="@error('registration_type') is-invalid @enderror">
                <label for="entity">Entity</label>

                @error('registration_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="company_name">Company name: </label>
                <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" class="@error('company_name') is-invalid @enderror">

                @error('company_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>
        
            <p>
                <label for="firstname">First name: <span aria-label="required">*</span></label>
                <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" class="@error('firstname') is-invalid @enderror">

                @error('firstname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="lastname">Last name: <span aria-label="required">*</span></label>
                <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="@error('lastname') is-invalid @enderror">

                @error('lastname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="email">Email: <span aria-label="required">*</span></label>
                <input type="text" name="email" value="{{ old('email', $user->email) }}" class="@error('email') is-invalid @enderror">

                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="address">Address: </label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="@error('address') is-invalid @enderror">

                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="zipcode">Zipcode: </label>
                <input type="text" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}" class="@error('zipcode') is-invalid @enderror">

                @error('zipcode')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="city">City: </label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}" class="@error('city') is-invalid @enderror">

                @error('city')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            @php( $countries = Symfony\Component\Intl\Countries::getNames() )

            <p>
                <label for="country_code">Country: </label>
                <select id="country_code" name="country_code"
                    class="@error('country_code') is-invalid @else is-valid @enderror">

                    @foreach ($countries as $alpha2Code => $countryName)
                        <option value="{{ $alpha2Code }}" @selected(old('country_code', $user->country_code) === $alpha2Code)>
                            {{ $countryName }}
                        </option>
                    @endforeach

                </select>

                @error('country_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="nationality_code">Nationality: </label>
                <select id="nationality_code" name="nationality_code"
                    class="@error('nationality_code') is-invalid @else is-valid @enderror">

                    @foreach ($countries as $alpha2Code => $countryName)
                        <option value="{{ $alpha2Code }}" @selected(old('nationality_code', $user->nationality_code) === $alpha2Code)>
                            {{ $countryName }}
                        </option>
                    @endforeach

                </select>

                @error('nationality_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="phone">Phonenumber: </label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="@error('phone') is-invalid @enderror">

                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="birthdate">Date of birth: </label>
                <input type="date" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" class="@error('birthdate') is-invalid @enderror">

                @error('birthdate')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="birth_country_code">Country of birth: </span></label>
                <select id="birth_country_code" name="birth_country_code"
                    class="@error('birth_country_code') is-invalid @else is-valid @enderror">

                    @foreach ($countries as $alpha2Code => $countryName)
                        <option value="{{ $alpha2Code }}" @selected(old('birth_country_code', $user->birth_country_code) === $alpha2Code)>
                            {{ $countryName }}
                        </option>
                    @endforeach

                </select>

                @error('birth_country_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>
            
            <p>
                <label for="living_in_netherlands">Living in the Netherlands</label>

                @php($living_in_netherlands = $user->living_in_netherlands === true ? 'yes' : 'no')
                
                <input type="radio" id="yes" name="living_in_netherlands" value="yes" @checked(old('living_in_netherlands', $living_in_netherlands) === 'yes') class="@error('living_in_netherlands') is-invalid @enderror">
                <label for="yes">Yes</label>
                <input type="radio" id="no" name="living_in_netherlands" value="no" @checked(old('living_in_netherlands', $living_in_netherlands) === 'no') class="@error('living_in_netherlands') is-invalid @enderror">
                <label for="no">No</label>

                @error('living_in_netherlands')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="source_of_income">Source of income: </label>
                <input type="text" name="source_of_income" value="{{ old('source_of_income', $user->source_of_income) }}" class="@error('source_of_income') is-invalid @enderror">

                @error('source_of_income')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="taxable_countries">Taxable in the following countries: </label>
                <input type="text" name="taxable_countries" value="{{ old('taxable_countries', $user->taxable_countries) }}" class="@error('taxable_countries') is-invalid @enderror">

                @error('taxable_countries')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="bsn">Citizen Service Number: </label>
                <input type="text" name="bsn" value="{{ old('bsn', $user->bsn) }}" class="@error('bsn') is-invalid @enderror">

                @error('bsn')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="bank_account_number">Bank account number: </label>
                <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $user->bank_account_number) }}" class="@error('bank_account_number') is-invalid @enderror">

                @error('bank_account_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="coc_number">CoC number: </label>
                <input type="text" name="coc_number" value="{{ old('coc_number', $user->coc_number) }}" class="@error('coc_number') is-invalid @enderror">

                @error('coc_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <p>
                <label for="notes">Notes</label>
                <textarea name="notes"  class="@error('notes') is-invalid @enderror">{{ old('notes', $user->notes) }}</textarea>

                @error('notes')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </p>

            <input type="submit" value="Submit">
        </form>

    </section>

</x-admin.layout>