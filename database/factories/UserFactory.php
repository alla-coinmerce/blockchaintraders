<?php

namespace Database\Factories;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $is_admin = fake()->boolean(5);

        // $role_id = $is_admin ? Role::ADMIN->value : Role::PARTICPANT->value;

        $registration_type = fake()->randomElement(['private', 'entity']);

        $country_code = fake()->countryCode();

        $chance = fake()->boolean(25);

        return [
            'role' => Role::PARTICPANT->value,
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'welcome_valid_until' => null,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => fake()->boolean(90),
            'registration_type' => $registration_type,
            'company_name' => $registration_type === 'entity' ? fake()->company() : '',
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'zipcode' => fake()->postcode(),
            'city' => fake()->city(),
            'country_code' => $country_code,
            'nationality_code' => $country_code,
            'birthdate' => fake()->date(),
            'birth_country_code' => $country_code,
            'living_in_netherlands' => true,
            'source_of_income' => fake()->jobTitle(),
            'taxable_countries' => 'Nederland',
            'bsn' => fake()->idNumber(),
            'coc_number' => $registration_type === 'entity' ? fake()->idNumber() : '',
            'bank_account_number' => fake()->bankAccountNumber(),
            'notes' => $chance ? fake()->text(50) : '',
            'last_login' => fake()->dateTimeBetween('-3 weeks')
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
