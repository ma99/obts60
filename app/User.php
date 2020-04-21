<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    //protected $sms;
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'creator_id'); 
    }

    protected function create(array $data)
    {
      // return User::updateOrCreate(
      //     ['phone' => $data['phone']],
      //     [
      //       'name' => $data['name'],
      //       'email' => $data['email'],
      //       'password' => $data['password'] // $attributes['password'] = Hash::make(Str::random(8)); 
      //     ]
      // );

      return User::create(
          [
            'phone' => $data['phone'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], 
          ]
      );
    }

    public function getPhoneForPasswordReset()
    {
        return $this->phone;
    }

    // public function remove(array $data)
    // {        
    //     unset($data['name']);
    //     unset($data['phone']);
    //     unset($data['password']);        
    //     if (isset($data['email'])) { unset($data['email']); }
    //     return $data;
    // }

    public function roles()
    {
        return $this->belongsToMany(Role::class); 
    }

    public function assign($role)
    {
        //return $this->roles()->attach(Role::whereName($role)->first());
        return $this->roles()->attach($role);
    }

    public function isAdmin()
    {
        return $this->hasRole('super_admin') || $this->hasRole('admin');
    }
    
    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
        return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
      }

      return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();      
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
    }

    /** phone verfication */

    public function hasVerifiedPhone()
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the phone verification notification.
     *
     * @return void
     */
    public function sendPhoneVerificationNotification()
    {
        $this->notify(new Notifications\VerifyPhone);
    }

    /**
     * Get the Phone address that should be used for verification.
     *
     * @return string
     */
    public function getPhoneForVerification()
    {
        return $this->phone;
    }

    public function clearPreviousVerification()
    {
      if ($this->hasVerifiedPhone()) {
        return $this->forceFill([
            'phone_verified_at' => null,
        ])->save();
      }
    }

    public function smsToVerify()
    {

        $config = config('settings.phone');
        //$code = random_int(1000, 9999); // 4 digits
        $code = random_int(100000, 999999); // 6 digits
        
        $this->forceFill([
            'verification_code' => $code
        ])->save();

        
        $data = [
            'to_numbers' => $this->phone,
            'from_number' => $config['number'],
            'message' => 'Your Verfication Code:'.$code,
        ];
        //$sms->send($data);
        //app('App\Repositories\Sms\SmsInterface')->send($data); //wk

        //sendSms($data);
    }

     public function verificationCodeExpired($updatedAt)
    {
        $config = config('settings.phone');
        return Carbon::parse($updatedAt)->addSeconds($config['expire'])->isPast();
    }
}