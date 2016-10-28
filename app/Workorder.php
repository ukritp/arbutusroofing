<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use File;

class Workorder extends Model
{
    // Search all column using Sofa Eloque
    use Eloquence;
    protected $searchableColumns = [
        'property.property_name'           => 20,
        'property.company.company_name'    => 20,
        'property.company.first_name'      => 20,
        'property.company.last_name'       => 20,
        'property.company.user.first_name' => 15,
        'property.company.user.email'      => 15,
        'property.company.user.roles.name' => 15,
        'property.company.user.last_name'  => 15,
        'workorder_number'                 => 10,
        'description'                      => 10,
        'tenant_first_name'                => 5,
        'tenant_last_name'                 => 5,
        'tenant_phone_number'              => 5,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'workorder_number','tenant_first_name', 'tenant_last_name','tenant_phone_number',
    ];

    /* ==========================================|| SET ATTRIBUTE ||==========================================*/
    /**
     * Always capitalize the first name when we save it to the database
     */
    public function setTenantFirstNameAttribute($value) {
        $this->attributes['tenant_first_name'] = ucfirst($value);
    }

    /**
     * Always capitalize the last name when we save it to the database
     */
    public function setTenantLastNameAttribute($value) {
        $this->attributes['tenant_last_name'] = ucfirst($value);
    }

    /* ==========================================|| GET ATTRIBUTE ||==========================================*/
    /**
     * Always put '-' after first name if not empty
     */
    public function getTenantFirstNameAttribute($value) {
        if(!empty($value)){
            return $value.'  ';
        }else{
            return '-';
        }
    }

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

    // One to Many Relationship - Property has many Workorders
    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    // One to Many Relationship - Workorders has many images
    public function images()
    {
        return $this->hasMany('App\UploadImage');
    }

    // One to Many Relationship - Workorders has many invoices
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    /* ==========================================|| OTHERS ||==========================================*/
    // format phone number
    public function formatPhone() {
        $formatted_value = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $this->tenant_phone_number). "\n";
        if(!empty($formatted_value)){
            return $formatted_value;
        }else{
            return '-';
        }
    }

    // Delete all children data before delete Company
    protected static function boot() {
        parent::boot();
        static::deleting(function($workorder) { // called BEFORE delete()
            $path = 'uploads/'.$workorder->property->company->id.'/'.$workorder->property->id.'/'.$workorder->id;
            $destination_path = public_path($path);
            File::deleteDirectory($destination_path);
            $workorder->images()->delete();
        });
    }
}
