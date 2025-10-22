<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),

            'role' =>['required', Rule::in([student, teacher])],
            'profile_photo_path' => ['nullable', 'image','mimes:jpg,jpeg,png', 'max:1024'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $photopath = null;
        if (isset($input['profile_photo_path'])){
            $photopath = $inpute['profile_photo_path']->store('profile_photos','public');
        }

        $otp = rand(100000,999999);

        cache()->put('otp_' .$input['email'], $otp, now()->addMinutes(10));

        Mail::to($input['email'])->send(new OtpMail($otp));

      // Create user but mark email as not verified
    $user = User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'role' => $input['role'],
        'profile_photo_path' => $photoPath,
        'email_verified_at' => null,
    ]);

    return $user;
}

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
