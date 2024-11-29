<x-web.layout id="registerpage">

    @push('meta')
        <meta name="keywords" content="crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund">
        <meta name="description" content="AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>

    <x-slot:heading>
        <h1>{{ __('Register').' '.$fund->name }}</h1>
    </x-slot>

    <section>
        <form id="registrationForm" method="POST" action="{{ route('register', ['fund' => $fund]) }}" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <p class="alert alert-danger">{{  __("Please correct the following errors:") }}</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="alert alert-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <h2>{{ __('Type of Registration') }}</h2>

                <p>
                    <input type="radio" id="private" name="registration_type" value="private"
                        @checked(old('registration_type', 'private') === 'private') class="@error('registration_type') is-invalid @enderror">
                    <label for="private">{{ __('Private') }}</label>
                    <input type="radio" id="entity" name="registration_type" value="entity"
                        @checked(old('registration_type') === 'entity') class="@error('registration_type') is-invalid @enderror">
                    <label for="entity">{{ __('Entity') }}</label>

                    @error('registration_type')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>
            </div>

            <div>
                <h2>{{ __('General data') }}</h2>

                <p class="entity_only hide">
                    <label for="company_name">{{ __('Entity name') }}</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                        class="@error('company_name') is-invalid @enderror">

                    @error('company_name')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="firstname">{{ __('First name') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}"
                        class="@error('firstname') is-invalid @enderror">

                    @error('firstname')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="lastname">{{ __('Last name') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}"
                        class="@error('lastname') is-invalid @enderror">

                    @error('lastname')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label class="private_only" for="address">{{ __('Address') }}</label>
                    <label class="entity_only hide" for="address">{{ __('Business address entity') }}</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                        class="@error('address') is-invalid @enderror">

                    @error('address')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="zipcode">{{ __('Postal code') }}<span class="entity_only hide"> {{ __("entity") }}</span></label>
                    <input type="text" name="zipcode" value="{{ old('zipcode') }}"
                        class="@error('zipcode') is-invalid @enderror">

                    @error('zipcode')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label class="private_only" for="city">{{ __('Residence') }}</label>
                    <label class="entity_only hide" for="city">{{ __('City entity') }}</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="@error('city') is-invalid @enderror">

                    @error('city')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                @php($countries = Symfony\Component\Intl\Countries::getNames())

                <p class="half_width_on_desktop">
                    <label for="country_code">{{ __('Country') }}<span class="entity_only hide"> {{ __("entity") }}</span></label>
                    <select id="country_code" name="country_code"
                        class="@error('country_code') is-invalid @else is-valid @enderror">

                        @foreach ($countries as $alpha2Code => $countryName)
                            <option value="{{ $alpha2Code }}" @selected(old('country_code') === $alpha2Code)>
                                {{ $countryName }}
                            </option>
                        @endforeach

                    </select>

                    @error('country_code')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="nationality_code">{{ __('Nationality') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <select id="nationality_code" name="nationality_code"
                        class="@error('nationality_code') is-invalid @else is-valid @enderror">

                        @foreach ($countries as $alpha2Code => $countryName)
                            <option value="{{ $alpha2Code }}" @selected(old('nationality_code') === $alpha2Code)>
                                {{ $countryName }}
                            </option>
                        @endforeach

                    </select>

                    @error('nationality_code')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="phone">{{ __('Phone number') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="@error('phone') is-invalid @enderror">

                    @error('phone')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="email">{{ __('E-mail') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <input type="text" name="email" value="{{ old('email') }}"
                        class="@error('email') is-invalid @enderror">

                    @error('email')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="birthdate">{{ __('Date of birth') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                        class="@error('birthdate') is-invalid @enderror">

                    @error('birthdate')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="birth_country_code">{{ __('Country of birth') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <select id="birth_country_code" name="birth_country_code"
                        class="@error('birth_country_code') is-invalid @else is-valid @enderror">

                        @foreach ($countries as $alpha2Code => $countryName)
                            <option value="{{ $alpha2Code }}" @selected(old('birth_country_code') === $alpha2Code)>
                                {{ $countryName }}
                            </option>
                        @endforeach

                    </select>

                    @error('birth_country_code')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

            </div>

            <div>
                <h2 class="private_only">{{ __('Identity') }}</h2>
                <h2 class="entity_only hide">{{ __('Identity') }} {{ __("owner") }}</h2>

                <p>{{ __('Copy of a valid proof of identity (passport, (European) driving license or Dutch identity card).') }}
                </p>

                <p>
                    <label for="identification">{{ __('Identification') }}</label>
                    <input name="identification" type="file"
                        class="@error('identification') is-invalid @enderror">

                    @error('identification')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
                </p>

                <h2 class="private_only hide">{{ __('Bank statement') }}</h2>

                <p class="private_only hide">{{ __('Copy of a bank statement or bill from an energy or utility company to verify the address.') }}</p>

                <p class="private_only hide">
                    <label for="bank_statement">{{ __('Bank statement') }}</label>
                    <input name="bank_statement" type="file"
                        class="@error('bank_statement') is-invalid @enderror">

                    @error('bank_statement')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
                </p>

                <h2 class="entity_only hide">{{ __('Chamber of Commerce extract') }} {{ __("entity") }}</h2>

                <p class="entity_only hide">{{ __('Copy of a recent Chamber of Commerce extract.') }}</p>

                <p class="entity_only hide">
                    <label for="coc_extract">{{ __('Chamber of Commerce extract') }}</label>
                    <input name="coc_extract" type="file"
                        class="@error('coc_extract') is-invalid @enderror">

                    @error('coc_extract')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

            </div>

            <div>
                <h2>{{ __('Desired participation date') }}</h2>

                <p class="half_width_on_desktop">
                    <label style="width: 100%;" for="participation_date">{{ __('Date') }}</label>

                    <span style="width: 100%;">
                        <input style="width: 40%;" type="date" name="participation_date" value="{{ old('participation_date') }}"
                            class="@error('participation_date') is-invalid @enderror">

                        <select style="width: 58%;" name="participation_moment" class="@error('participation_moment') is-invalid @enderror">
                            <option value="" disabled selected>-- {{ __("Please select a moment") }} --</option>
                            <option value="morning" @selected(old('participation_moment') === "morning")>{{ __("Morning") }}</option>
                            <option value="afternoon" @selected(old('participation_moment') === "afternoon")>{{ __("Afternoon") }}</option>
                        </select>
                    </span>

                    @error('participation_date')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror

                    @error('participation_moment')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="desired_amount">{{ __("Amount in Euros from 100,000 to 5,000,000+") }}</label>
                    <input type="text" name="desired_amount" value="{{ old('desired_amount') }}"
                        class="@error('desired_amount') is-invalid @enderror">

                    @error('desired_amount')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p>
                    <label class="private_only">{{ __('Living in the Netherlands') }}</label>
                    <label class="entity_only hide">{{ __('Located in Netherlands') }}</label>
                    <input type="radio" id="yes" name="living_in_netherlands" value="yes"
                        @checked(old('living_in_netherlands', 'yes') === 'yes')
                        class="@error('living_in_netherlands') is-invalid @enderror">
                    <label for="yes">{{ __('Yes') }}</label>
                    <input type="radio" id="no" name="living_in_netherlands" value="no"
                        @checked(old('living_in_netherlands') === 'no')
                        class="@error('living_in_netherlands') is-invalid @enderror">
                    <label for="no">{{ __('No') }}</label>

                    @error('living_in_netherlands')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="private_only half_width_on_desktop">
                    <label for="source_of_income">{{ __('Source of income') }}</label>
                    <input type="text" name="source_of_income" value="{{ old('source_of_income') }}"
                        class="@error('source_of_income') is-invalid @enderror">

                    @error('source_of_income')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="taxable_countries">{{ __('Tax liability in the following countries') }}<span class="entity_only hide"> ({{ __("entity") }})</span></label>
                    <input type="text" name="taxable_countries" value="{{ old('taxable_countries') }}"
                        class="@error('taxable_countries') is-invalid @enderror">

                    @error('taxable_countries')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="bsn">{{ __('Citizen Service Number') }}<span class="entity_only hide"> {{ __("owner") }}</span></label>
                    <input type="text" name="bsn" value="{{ old('bsn') }}"
                        class="@error('bsn') is-invalid @enderror">

                    @error('bsn')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="entity_only hide half_width_on_desktop">
                    <label for="coc_number">{{ __('CoC number') }}</label>
                    <input type="text" name="coc_number" value="{{ old('coc_number') }}"
                        class="@error('coc_number') is-invalid @enderror">

                    @error('coc_number')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p class="half_width_on_desktop">
                    <label for="bank_account_number">{{ __('Bank account number') }}<span class="entity_only hide"> {{ __("entity") }}</span></label>
                    <input type="text" name="bank_account_number"
                        value="{{ old('bank_account_number') }}"
                        class="@error('bank_account_number') is-invalid @enderror">

                    @error('bank_account_number')
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
                </p>

            </div>

            <div>
                <h2>{{ __('Correct information statement') }}</h2>

                <p>
                    <input type="checkbox" name="correctly_filled" value="yes" @checked(old('correctly_filled'))
                        class="@error('correctly_filled') is-invalid @enderror">
                    <label for="correctly_filled">{{ __('Completed truthfully') }}</label>

                    @error('correctly_filled')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p>
                    {{ __('I declare that all information provided to the Administrator of :fundname via this application form is true, accurate and complete to the best of my knowledge. I hereby undertake to promptly inform and provide the Administrator with any changed information within 30 days of any such change occurring which results in the information previously received becoming inaccurate or incomplete. Where a legal obligation exists, I hereby declare that the Administrator has my permission to share the information with the tax authorities and/or the relevant tax authorities.', ['fundname' => $fund->name]) }}
                </p>

                <h2>{{ __('Confirmation of participation') }}</h2>

                <p>
                    <input type="checkbox" name="confirmation" value="yes" @checked(old('confirmation'))
                        class="@error('confirmation') is-invalid @enderror">
                    <label for="confirmation">{{ __('Confirmation of participation') }}</label>

                    @error('confirmation')
                        <span class="alert alert-danger">{{ $message }}</span>
                    @enderror
                </p>

                <p>
                    {{ __("I hereby confirm that I wish to participate in :fundname for the above amount. I have read all the information on this registration form. By signing this application form, I declare that I am aware of and agree with the contents of the Fund's Information Memorandum and the Essential Information document. The documents are available from the Manager of the Fund, being BlockchainTraders B.V., Groenmarktkade 12HB, 1016 TA, Amsterdam.", ['fundname' => $fund->name]) }}
                </p>

            </div>

            <x-honeypot />

            <input type="submit" value="{{  __("Send") }}">

        </form>
    </section>

    <script>
       
        $(document).ready(updateShowHideEntityPrivateFields);

        $('input[type=radio][name=registration_type]').change(updateShowHideEntityPrivateFields);

        function updateShowHideEntityPrivateFields()
        {
            console.log($('input[type=radio][name=registration_type]:checked').val());

            if($('input[type=radio][name=registration_type]:checked').val() == 'entity')
            {
                $('.private_only').addClass("hide");
                $('.entity_only').removeClass("hide");
            }
            else
            {
                $('.private_only').removeClass("hide");
                $('.entity_only').addClass("hide");
            }
        }

        $("#registrationForm").on( "submit", function() {
            $('input[type=submit]', this).attr('disabled', 'disabled');
        });
    </script>

</x-web.layout>
