<?php

namespace App\Models;

use App\Models\RegistrationPackage;


use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{

    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'username',
        'email',
        'username',
        'password',

        'is_admin',
        'industry_id',

        'company_name',
        'company_address',
        'company_phone',
        'company_fax',


        'city',
        'country',
        'state',
        'zip',

        'interests_id',
        'additional_details',

        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_zip',

        'package_id',
        'payment_option',
        'bank_name',
        'bank_city_name',
        'micr_number',
        'cheque_number',
        'cheque_date',
        'cheque_type',
        'status',
        'account_type',
        'masking_allowed',
        'stripe_id',
        'pm_type',
        'pm_last_four'
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
    ];


    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

            'cheque_date' => 'date',

            'masking_allowed' => 'boolean',

            'trial_ends_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function package()
    {
        return $this->belongsTo(RegistrationPackage::class, 'package_id');
    }

    public function userPackage()
    {
        return $this->hasOne(UserPackage::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function campaigns()
    {
        return $this->hasMany(MailCampaign::class);
    }

    public function contactGroups()
    {
        return $this->hasMany(ContactGroup::class);
    }

    public function contacts()
    {
        return $this->hasMany(ContactList::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isCustomer(): bool
    {
        return !$this->is_admin;
    }

    public function isActive(): bool
    {
        return $this->status === 'Active';
    }

    public function isDeactive(): bool
    {
        return $this->status === 'Deactive';
    }

    /*
    |--------------------------------------------------------------------------
    | Stripe Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Returns true if user has an active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscribed('default');
    }

    /**
     * Returns current subscription.
     */
    public function currentSubscription()
    {
        return $this->subscription('default');
    }

    /**
     * Returns Stripe customer.
     */
    public function stripeCustomer()
    {
        return $this->asStripeCustomer();
    }

    /**
     * User currently on trial?
     */
    public function onTrialPeriod(): bool
    {
        return $this->onTrial();
    }
}

