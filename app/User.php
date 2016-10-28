<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
use Sofa\Eloquence\Eloquence;
use File;

class User extends Authenticatable
{

    // Search all column using Sofa Eloque
    use Eloquence;
    protected $searchableColumns = [
        'first_name'   => 20,
        'last_name'    => 20,
        'email'        => 15,
        'phone_number' => 15,
        'status'       => 10,
        'roles.name'   => 10,
        'address'      => 15,
        'city'         => 15,
        'province'     => 15,
        'postalcode'   => 10,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','address','city','province','postalcode','phone_number','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* ==========================================|| SET ATTRIBUTE ||==========================================*/
    /**
     * Always Hash Password when save to database
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
    /**
     * Always capitalize the first name when we save it to the database
     */
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Always capitalize the last name when we save it to the database
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /**
     * Always capitalize the the first letter of every word in Address when we save it to the database
     */
    public function setAddressAttribute($value) {
        $this->attributes['address'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize the the first letter of every word in City when we save it to the database
     */
    public function setCityAttribute($value) {
        $this->attributes['city'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize all letter in Province when we save it to the database
     */
    public function setProvinceAttribute($value) {
        $this->attributes['province'] = strtoupper($value);
    }

    /**
     * Always capitalize all letter in Postalcode when we save it to the database
     */
    public function setPostalcodeAttribute($value) {
        $this->attributes['postalcode'] = strtoupper($value);
    }


    /* ==========================================|| GET ATTRIBUTE ||==========================================*/
    /**
     * Always put ',' after Address if not empty
     */
    public function getAddressAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return $value;
        }
    }

    /**
     * Always put ',' after City if not empty
     */
    public function getCityAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return $value;
        }
    }

    /**
     * Always put space after Province if not empty
     */
    public function getProvinceAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return $value;
        }
    }

    /**
     * Always format phone number
     */
    // public function getPhoneNumberAttribute($value) {
    //     $formatted_value = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $value). "\n";
    //     if(!empty($value)){
    //         return $formatted_value;
    //     }else{
    //         return '-';
    //     }
    // }

    /**
     * Always format date
     */
    public function getCreatedAtAttribute($value) {
        return date('M j, Y - H:i', strtotime($value));
    }
    /**
     * Always format date
     */
    public function getUpdatedAtAttribute($value) {
        return date('M j, Y - H:i', strtotime($value));
    }

    /* ==========================================|| MODEL RELATIONSHIPS ||==========================================*/
    // Many to Many Relationship - User has many roles
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    // One to Many Relationship - User has many Companies
    public function companies()
    {
        return $this->hasMany('App\Company');
    }


    /* ==========================================|| OTHER ||==========================================*/

    // check if the user has any role
    public function hasAnyRole($roles)
    {
        // if roles is array
        if(is_array($roles)){
            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        // just one variable
        }else{
            if($this->hasRole($role)){
                return true;
            }
        }
        return false;
    }

    // check if the user actually has role that match database
    public function hasRole($role)
    {
        if( $this->roles()->where('name',$role)->first() ){
            return true;
        }
        return false;
    }

    // get full address
    public function fullAddress()
    {
        $full_address = '';
        if(!empty($this->address)){
            $full_address .= $this->address.', ';
        }
        if(!empty($this->city)){
            $full_address .= $this->city.', ';
        }
        if(!empty($this->province)){
            $full_address .= $this->province.' ';
        }
        $full_address .= $this->postalcode;
        return $full_address;
    }

    // format phone number
    public function formatPhone() {
        $formatted_value = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $this->phone_number). "\n";
        if(!empty($this->phone_number)){
            return $formatted_value;
        }else{
            return '-';
        }
    }

    // Delete all children data before delete User
    protected static function boot() {
        parent::boot();
        static::deleting(function($user) { // called BEFORE delete()
            foreach($user->companies as $company){
                foreach($company->properties as $property){
                    foreach($property->workorders as $workorder){
                        $path = 'uploads/'.$workorder->property->company->id;
                        $destination_path = public_path($path);
                        File::deleteDirectory($destination_path);
                        $workorder->images()->delete();
                    }
                    $property->workorders()->delete();
                }
                $company->properties()->delete(); // Causes any child "deleted" events to be called
            }
            $user->companies()->delete();
        });
    }
}
