<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'name', 'invoiced_at',
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

    /**
     * Always format date
     */
    public function getInvoicedAtAttribute($value) {
        return date('M j, Y', strtotime($value));
    }

    /**
     * Always format date
     */
    public function getDescriptionAttribute($value) {
        if(!empty($value)){
            return $value;
        }else{
            return '-';
        }
    }

    /* ==========================================|| MODEL RELATIONSHIPS ||==========================================*/

    // One to Many Relationship - Workorders has many invoices
    public function workorder()
    {
        return $this->belongsTo('App\Workorder');
    }

    /* ==========================================|| OTHERS ||==========================================*/

    public function getShortDescription()
    {
        if(!empty($this->description)){
            $suffix = '';
            if(strlen($this->description)>40){
                $suffix = '....';
            }
            return substr($this->description, 0,40).$suffix;
        }else{
            return '-';
        }
    }

    // Delete all children data before delete Company
    protected static function boot() {
        parent::boot();
        static::deleting(function($invoice) { // called BEFORE delete()
            $path = 'uploads/'.$invoice->workorder->property->company->id.'/'.$invoice->workorder->property->id.'/'.$invoice->workorder->id.'/'.'pdfs/';
            $destination_path = public_path($path.$invoice->name);
            File::delete($destination_path);
        });
    }
}
