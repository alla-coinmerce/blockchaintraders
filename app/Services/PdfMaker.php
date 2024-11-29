<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class PdfMaker
{
    /**
     * @return \Barryvdh\DomPDF\PDF
     */
    public function registrationConfirmationForm(
        $fund,
        $registrationType,
        $name,
        $companyName,
        $address,
        $postalCode,
        $city,
        $country,
        $nationality,
        $phone,
        $email,
        $dateOfBirth,
        $countryOfBirth,
        $desiredParticipationDate,
        $desiredParticiaptionAmount,
        $livingInTheNetherlands,
        $sourceOfIncome,
        $taxableCountries,
        $bsn
    )
    {
        return Pdf::loadView('pdf.registration-form', [
            'fund' => $fund,
            'date' => Carbon::today()->format('d-m-Y'),
            'registrationType' => $registrationType,
            'name' => $name,
            'companyName' => $companyName,
            'address' => $address,
            'postalCode' => $postalCode,
            'city' => $city,
            'country' => $country,
            'nationality' => $nationality,
            'phone' => $phone,
            'email' => $email,
            'dateOfBirth' => $dateOfBirth,
            'countryOfBirth' => $countryOfBirth,
            'desiredParticipationDate' => $desiredParticipationDate,
            'desiredParticiaptionAmount' =>  $desiredParticiaptionAmount,
            'livingInTheNetherlands' =>  $livingInTheNetherlands,
            'sourceOfIncome' => $sourceOfIncome,
            'taxableCountries' => $taxableCountries,
            'bsn' => $bsn
        ]);
    }
}