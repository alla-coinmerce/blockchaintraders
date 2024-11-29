<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'De :attribute moet geaccepteerd worden.',
    'accepted_if' => 'Het :attribute moet worden geaccepteerd wanneer :other is:value.',
    'active_url' => 'Het :attribute is geen geldige URL.',
    'after' => 'Het :attribute moet een datum na :date zijn.',
    'after_or_equal' => 'Het :attribute moet een datum na of gelijk aan :date zijn.',
    'alpha' => 'Het :attribute mag alleen letters bevatten.',
    'alpha_dash' => 'Het :attribute mag alleen letters, cijfers, streepjes en underscores bevatten.',
    'alpha_num' => 'Het :attribute mag alleen letters en cijfers bevatten.',
    'array' => 'Het :attribute moet een array zijn.',
    'ascii' => 'Het :attribute mag alleen alfanumerieke tekens en symbolen van één byte bevatten.',
    'before' => 'Het :attribute moet een datum vóór :date zijn.',
    'before_or_equal' => 'Het :attribute moet een datum zijn vóór of gelijk aan :date.',
    'tussen' => [
        'array' => 'Het :attribute moet tussen :min en :max items bevatten.',
        'file' => 'Het :attribute moet tussen :min en :max kilobytes liggen.',
        'numeric' => 'Het :attribute moet tussen :min en :max liggen.',
        'string' => 'Het :attribute moet tussen de tekens :min en :max staan.',
    ],
    'boolean' => 'Het veld :attribute moet waar of onwaar zijn.',
    'confirmed' => 'De :attribute bevestiging komt niet overeen.',
    'current_password' => 'Het wachtwoord is incorrect.',
    'date' => 'Het :attribute is geen geldige datum.',
    'date_equals' => 'Het :attribute moet een datum zijn die gelijk is aan :date.',
    'date_format' => 'Het :attribute komt niet overeen met het formaat :format.',
    'decimal' => 'Het :attribute moet :decimal decimalen bevatten.',
    'declined' => 'Het :attribute moet geweigerd worden.',
    'declined_if' => 'Het :attribute moet geweigerd worden wanneer :other :value is.',
    'different' => 'Het :attribute en :other moeten verschillend zijn.',
    'digits' => 'Het :attribute moet :digits digits zijn.',
    'digits_between' => 'Het :attribute moet tussen de cijfers :min en :max staan.',
    'dimensions' => 'Het :attribute heeft ongeldige afbeeldingsafmetingen.',
    'distinct' => 'Het veld :attribute heeft een dubbele waarde.',
    'doesnt_end_with' => 'Het :attribute mag niet eindigen op een van de volgende: :values.',
    'doesnt_start_with' => 'Het :attribute mag niet beginnen met een van de volgende: :values.',
    'email' => 'Het :attribute moet een geldig e-mailadres zijn.',
    'ends_with' => 'Het :attribute moet eindigen op een van de volgende: :values.',
    'enum' => 'Het geselecteerde :attribute is ongeldig.',
    'exists' => 'Het geselecteerde :attribute is ongeldig.',
    'file' => 'Het :attribute moet een bestand zijn.',
    'filled' => 'Het veld :attribute moet een waarde hebben.',
    'gt' => [
        'array' => 'Het :attribute moet meer dan :value items bevatten.',
        'file' => 'Het :attribute moet groter zijn dan :value kilobytes.',
        'numeric' => 'Het :attribute moet groter zijn dan :value.',
        'string' => 'Het :attribute moet groter zijn dan :value tekens.',
    ],
    'gte' => [
        'array' => 'Het :attribute moet :value items of meer hebben.',
        'file' => 'Het :attribute moet groter zijn dan of gelijk zijn aan :value kilobytes.',
        'numeric' => 'Het :attribute moet groter zijn dan of gelijk zijn aan :value.',
        'string' => 'Het :attribute moet groter zijn dan of gelijk zijn aan :value-tekens.',
    ],
    'image' => 'Het :attribute moet een afbeelding zijn.',
    'in' => 'Het geselecteerde :attribute is ongeldig.',
    'in_array' => 'Het veld :attribute bestaat niet in :other.',
    'integer' => 'Het :attribute moet een geheel getal zijn.',
    'ip' => 'Het :attribute moet een geldig IP-adres zijn.',
    'ipv4' => 'Het :attribute moet een geldig IPv4-adres zijn.',
    'ipv6' => 'Het :attribute moet een geldig IPv6-adres zijn.',
    'json' => 'Het :attribute moet een geldige JSON-tekenreeks zijn.',
    'lowercase' => 'Het :attribute moet kleine letters zijn.',
    'lt' => [
        'array' => 'Het :attribute moet minder dan :value items bevatten.',
        'file' => 'Het :attribute moet kleiner zijn dan :value kilobytes.',
        'numeric' => 'Het :attribute moet kleiner zijn dan :value.',
        'string' => 'Het :attribute moet kleiner zijn dan :value tekens.',
    ],
    'lte' => [
        'array' => 'Het :attribute mag niet meer dan :value items bevatten.',
        'file' => 'Het :attribute moet kleiner zijn dan of gelijk zijn aan :value kilobytes.',
        'numeric' => 'Het :attribute moet kleiner zijn dan of gelijk zijn aan :value.',
        'string' => 'Het :attribute moet kleiner zijn dan of gelijk zijn aan :value-tekens.',
    ],
    'mac_address' => 'Het :attribute moet een geldig MAC-adres zijn.',
    'max' => [
        'array' => 'Het :attribute mag niet meer dan :max items bevatten.',
        'file' => 'Het :attribute mag niet groter zijn dan :max kilobytes.',
        'numeric' => 'Het :attribute mag niet groter zijn dan :max.',
        'string' => 'Het :attribute mag niet groter zijn dan :max karakters.',
    ],
    'max_digits' => 'Het :attribute mag niet meer dan :max cijfers bevatten.',
    'mimes' => 'Het :attribute moet een bestand zijn van het type: :values.',
    'mimetypes' => 'Het :attribute moet een bestand zijn van het type: :values.',
    'min' => [
        'array' => 'Het :attribute moet minstens :min items bevatten.',
        'file' => 'Het :attribute moet minstens :min kilobytes zijn.',
        'numeric' => 'Het :attribute moet minimaal :min zijn.',
        'string' => 'Het :attribute moet minstens :min tekens bevatten.',
    ],
    'min_digits' => 'Het :attribute moet minstens :min cijfers bevatten.',
    'missing' => 'Het veld :attribute moet ontbreken.',
    'missing_if' => 'Het veld :attribute moet ontbreken wanneer :other gelijk is aan :value.',
    'missing_unless' => 'Het veld :attribute moet ontbreken, tenzij :other :value is.',
    'missing_with' => 'Het veld :attribute moet ontbreken wanneer :values aanwezig is.',
    'missing_with_all' => 'Het veld :attribute moet ontbreken wanneer :values aanwezig zijn.',
    'multiple_of' => 'Het :attribute moet een veelvoud zijn van :value.',
    'not_in' => 'Het geselecteerde :attribute is ongeldig.',
    'not_regex' => 'De indeling :attribute is ongeldig.',
    'numeric' => 'Het :attribute moet een getal zijn.',
    'password' => [
        'letters' => 'Het :attribute moet minstens één letter bevatten.',
        'mixed' => 'Het :attribute moet minstens één hoofdletter en één kleine letter bevatten.',
        'numbers' => 'Het :attribute moet minstens één getal bevatten.',
        'symbols' => 'Het :attribute moet minstens één symbool bevatten.',
        'uncompromised' => 'Het gegeven :attribute is verschenen in een datalek. Kies een ander :attribute.',
    ],
    'present' => 'Het veld :attribute moet aanwezig zijn.',
    'prohibited' => 'Het veld :attribute is niet toegestaan.',
    'prohibited_if' => 'Het veld :attribute is niet toegestaan ​​wanneer :other :value is.',
    'prohibited_unless' => 'Het :attribute veld is verboden tenzij :other in :values ​​staat.',
    'prohibits' => 'Het :attribute veld verbiedt :other om aanwezig te zijn.',
    'regex' => 'De indeling :attribute is ongeldig.',
    'required' => ':attribute is verplicht.',
    'required_array_keys' => 'Het :attribute veld moet waarden bevatten voor: :values.',
    'required_if' => 'Het veld :attribute is vereist wanneer :other :value is.',
    'required_if_accepted' => 'Het veld :attribute is vereist wanneer :other is geaccepteerd.',
    'required_unless' => 'Het :attribute veld is verplicht tenzij :other in :values staat.',
    'required_with' => 'Het veld :attribute is verplicht wanneer :values aanwezig is.',
    'required_with_all' => 'Het veld :attribute is vereist wanneer :values aanwezig zijn.',
    'required_without' => 'Het veld :attribute is verplicht wanneer :values niet aanwezig is.',
    'required_without_all' => 'Het veld :attribute is vereist wanneer geen van de :waarden aanwezig is.',
    'same' => 'De :attribute en :other moeten overeenkomen.',
    'size' => [
        'array' => 'Het :attribute moet :size-items bevatten.',
        'file' => 'Het :attribute moet :size kilobytes zijn.',
        'numeric' => 'Het :attribute moet :size zijn.',
        'string' => 'Het :attribute moet :size tekens zijn.',
    ],
    'starts_with' => 'Het :attribute moet beginnen met een van de volgende: :values.',
    'string' => 'Het :attribute moet een string zijn.',
    'timezone' => 'Het :attribute moet een geldige tijdzone zijn.',
    'unique' => 'Het :attribute is al in gebruik.',
    'uploaded' => 'Het :attribute kon niet worden geüpload.',
    'uppercase' => 'Het :attribute moet een hoofdletter zijn.',
    'url' => 'Het :attribute moet een geldige URL zijn.',
    'ulid' => 'Het :attribute moet een geldige ULID zijn.',
    'uuid' => 'Het :attribute moet een geldige UUID zijn.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'coupon' => [
            'in' => 'De code is ongeldig',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'firstname' => 'voornaam',
        'lastname' => 'achternaam',
        'email' => 'e-mailadres',
        'phone' => 'telefoonnummer',
        'company_name' => 'bedrijfsnaam',
        'address' => 'adres',
        'zipcode' => 'postcode',
        'city' => 'plaats',
        'country_code' => 'land',
        'nationality_code' => 'nationaliteit',
        'birthdate' => 'geboortedatum',
        'birth_country_code' => 'geboorteland',
        'identification' => 'identiteit',
        'bank_statement' => 'bankafschrift',
        'coc_extract' => 'KvK uittreksel',
        'ubo_structure' => 'UBO strucuur',
        'participation_date' => 'participatiedatum',
        'participation_moment' => 'participatiemoment',
        'desired_amount' => 'gewenst bedrag',
        'living_in_netherlands' => 'woonachtig in Nederland',
        'source_of_income' => 'bron van inkomsten',
        'taxable_countries' => 'belastingplichtige landen',
        'bsn' => 'BSN',
        'bank_account_number' => 'bankrekeningnummer',
        'correctly_filled' => 'naar waarheid ingevuld',
        'confirmation' => 'bevestiging van deelname',
        'subscription_firstname' => 'voornaam',
        'subscription_lastname' => 'achternaam',
        'subscription_email' => 'e-mailadres',
        'subscription_subscription_type' => 'soort abonnement',
        'subscription_coupon' => 'coupon'
    ],

];
