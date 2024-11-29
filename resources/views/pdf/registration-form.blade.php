<!DOCTYPE html>
<html lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>BlockchainTraders Inschrijfbevestiging</title>

    <link rel="stylesheet" href="{{ public_path('assets/styles/pdf.css') }}" type="text/css"> 
</head>
<body>
    <header class="row">
        <h1 class="col-8">Inschrijving {{ $fund }} {{ $date }}</h1>

        <div class="col-4 logoContainer">
            <img width="180" src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/images/pdf/logo.png'))) }}" alt="Logo BlockchainTraders" />
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th colspan="2">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Soort Inschrijving</th>
                    <td>{{ $registrationType }}</td>
                </tr>

                @if (!empty($companyName))
                    <tr>
                        <th>Naam entiteit</th>
                        <td>{{ $companyName }}</td>
                    </tr>
                @endif

                <tr>
                    <th>Naam</th>
                    <td>{{ $name }}</td>
                </tr>

                <tr>
                    <th>Adres</th>
                    <td>{{ $address }}</td>
                </tr>

                <tr>
                    <th>Postcode</th>
                    <td>{{ $postalCode }}</td>
                </tr>

                <tr>
                    <th>Woonplaats</th>
                    <td>{{ $city }}</td>
                </tr>

                <tr>
                    <th>Land</th>
                    <td>{{ $country }}</td>
                </tr>

                <tr>
                    <th>Nationaliteit</th>
                    <td>{{ $nationality }}</td>
                </tr>

                <tr>
                    <th>Telefoon</th>
                    <td>{{ $phone }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $email }}</td>
                </tr>

                <tr>
                    <th>Geboortedatum</th>
                    <td>{{ $dateOfBirth }}</td>
                </tr>

                <tr>
                    <th>Geboorteland</th>
                    <td>{{ $countryOfBirth }}</td>
                </tr>

                <tr>
                    <th>Gewenste participatiedatum</th>
                    <td>{{ $desiredParticipationDate }}</td>
                </tr>

                <tr>
                    <th>Gewenste inschrijfbedrag</th>
                    <td>{{ $desiredParticiaptionAmount }}</td>
                </tr>

                <tr>
                    <th>Woonachtig in Nederland</th>
                    <td>{{ $livingInTheNetherlands }}</td>
                </tr>

                <tr>
                    <th>Bron van inkomsten</th>
                    <td>{{ $sourceOfIncome }}</td>
                </tr>

                <tr>
                    <th>Belastingplichtig in het
                        volgende land</th>
                    <td>{{ $taxableCountries }}</td>
                </tr>

                <tr>
                    <th>BSN</th>
                    <td>{{ $bsn }}</td>
                </tr>

                <tr>
                    <th>Naar waarheid ingevuld </th>
                    <td>Ik verklaar hierbij dat ik woonachtig ben in Nederland. Ik verklaar dat alle informatie die via dit
                        inschrijfformulier aan de Administrateur van {{ $fund }} wordt verstrekt, op waarheid
                        berust en naar mijn beste weten accuraat en volledig is. Ik zeg hierbij toe de Administrateur onmiddellijk te
                        informeren en te voorzien van gewijzigde informatie binnen 30 dagen nadat een dergelijke wijziging heeft
                        plaatsgevonden en die ertoe leidt dat de eerder ontvangen informatie inaccuraat of onvolledig wordt. Indien
                        er een wettelijke verplichting bestaat, verklaar ik hierbij dat de Administrateur mijn toestemming heeft om de
                        informatie te delen met de belastingdienst en/of de relevante fiscale autoriteiten. </td>
                </tr>

                <tr>
                    <th>Bevestiging deelname</th>
                    <td>Hiermee bevestig ik voor bovengenoemd bedrag te willen deelnemen in {{ $fund }}. Ik
                        heb alle informatie, op dit inschrijfformulier gelezen. Door ondertekening van dit inschrijfformulier verklaar ik
                        bekend te zijn en akkoord te gaan met de inhoud van het Informatie Memorandum en het Essentiële-informatiedocument van het Fonds. De genoemde documenten zijn verkrijgbaar bij de Beheerder van het Fonds, zijnde BlockchainTraders B.V.,
                        Groenmarktkade 12HB, 1016 TA, Amsterdam.</td>
                </tr>

                <tr>
                    <th>Bijlage: Identiteitsbewijs</th>
                    <td>Aangehecht</td>
                </tr>

                @if (empty($companyName))
                    <tr>
                        <th>Bijlage: Bank Statement</th>
                        <td>Aangehecht</td>
                    </tr>
                @else
                    <tr>
                        <th>Bijlage: KvK uittreksel</th>
                        <td>Aangehecht</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>
</body>
</html>