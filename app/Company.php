<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use File;

class Company extends Model
{
    // Search all column using Sofa Eloque
    use Eloquence;
    protected $searchableColumns = [
        'company_name'     => 20,
        'first_name'       => 20,
        'last_name'        => 20,
        'user.first_name' => 15,
        'user.email'      => 15,
        'user.roles.name' => 15,
        'user.last_name'  => 15,
        'phone_number'     => 10,
        'address'          => 10,
        'city'             => 10,
        'province'         => 5,
        'label'            => 5,
        'postalcode'       => 5,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name', 'label','first_name', 'last_name', 'address','city','province','postalcode','phone_number',
    ];

    /* ==========================================|| SET ATTRIBUTE ||==========================================*/
    /**
     * Always capitalize the the first letter of every word in Company name when we save it to the database
     */
    public function setCompanyNameAttribute($value) {
        $this->attributes['company_name'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize the label when we save it to the database
     */
    public function setLabelAttribute($value) {
        $this->attributes['label'] = ucfirst($value);
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
     * Always put '-' after Address if not empty
     */
    public function getCompanyNameAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return '-';
        }
    }

    /**
     * Always put '-' after Label if not empty
     */
    public function getLabelAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return '-';
        }
    }

    /**
     * Always put '-' after first name if not empty
     */
    public function getFirstNameAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return '-';
        }
    }

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

    // One to Many Relationship - User has many Companies
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // One to Many Relationship - Company has many Properties
    public function properties()
    {
        return $this->hasMany('App\Property');
    }

    /* ==========================================|| OTHERS ||==========================================*/
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
        if(!empty($formatted_value)){
            return $formatted_value;
        }else{
            return '-';
        }
    }

    // Delete all children data before delete Company
    protected static function boot() {
        parent::boot();
        static::deleting(function($company) { // called BEFORE delete()
            foreach($company->properties as $property){
                foreach($property->workorders as $workorder){
                    $path = 'uploads/'.$workorder->property->company->id;
                    $destination_path = public_path($path);
                    File::deleteDirectory($destination_path);
                    $workorder->images()->delete();
                }
                $property->workorders()->delete();
            }
            $company->properties()->delete();
        });
    }
}
