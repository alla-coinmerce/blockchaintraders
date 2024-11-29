<?php

namespace App\Console\Commands;

use App\Enums\Role;
use App\Models\PendingRegistration;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use App\Notifications\RegistrationConfirmationNotification;
use App\Services\PdfMaker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Intl\Countries;

class SendRegistrationNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-registration-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for new registrations, notify admins and send confirmation notification to the new user.';

    /**
     * Execute the console command.
     */
    public function handle(PdfMaker $pdfMaker)
    {
        try
        {
            $pendingRegistrations = PendingRegistration::all();

            foreach($pendingRegistrations as $pendingRegistration)
            {
                $user = $pendingRegistration->user;

                Log::debug('Handling pending registration for user '.$user->id);

                Log::debug('living_in_netherlands '.$user->living_in_netherlands);

                $pdf = $pdfMaker->registrationConfirmationForm(
                    $pendingRegistration->fund_name,
                    $user->registration_type === 'private' ? 'Prive' : 'Entiteit',
                    $user->firstname.' '.$user->lastname,
                    $user->company_name,
                    $user->address,
                    $user->zipcode,
                    $user->city,
                    Countries::getName($user->country_code, 'nl'),
                    Countries::getName($user->nationality_code, 'nl'),
                    $user->phone,
                    $user->email,
                    $this->formatDate($user->birthdate),
                    Countries::getName($user->birth_country_code, 'nl'),
                    $this->formatDate($pendingRegistration->desired_participation_date),
                    $pendingRegistration->desired_amount,
                    $user->living_in_netherlands == true ? 'Ja' : 'Nee',
                    $user->source_of_income,
                    $user->taxable_countries,
                    $user->bsn
                );

                $admins = User::where('role', Role::ADMIN->value)
                    ->get();

                foreach($admins as $admin)
                {
                    $admin->notify(new NewRegistrationNotification($pendingRegistration, $pdf));
                }

                $user->notify(new RegistrationConfirmationNotification($pdf));

                Log::debug('Notifications send');

                $pendingRegistration->delete();
            }
        }
        catch(\Exception $e)
        {
            Log::error('Failed to send registration notifications.'.$e->getMessage());
        }
    }

    private function formatDate($postedDate)
    {
        $date = date_create($postedDate);

        if($date)
        {
            return date_format($date, 'd-m-Y');
        }
        else
        {
            Log::error("Unable to format date ".$postedDate);

            return "0000-00-00";
        }
    }
}
