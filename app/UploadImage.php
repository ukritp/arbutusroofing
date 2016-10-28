<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

class UploadImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'name',
    ];

    /* ==========================================|| GET ATTRIBUTE ||==========================================*/
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
    public function workorder()
    {
        return $this->belongsTo('App\Workorder');
    }

    /* ==========================================|| OTHERS ||==========================================*/

    // Delete all children data before delete Company
    protected static function boot() {
        parent::boot();
        static::deleting(function($uploadimage) { // called BEFORE delete()
            $path = 'uploads/'.$uploadimage->workorder->property->company->id.'/'.$uploadimage->workorder->property->id.'/'.$uploadimage->workorder->id.'/'.'images/';
            $destination_path = public_path($path.$uploadimage->name);
            File::delete($destination_path);
        });
    }
}
