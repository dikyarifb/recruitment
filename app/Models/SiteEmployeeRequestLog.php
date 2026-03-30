<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use DateTime;

class SiteEmployeeRequestLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'site_employee_request_log';

    public function site_employee_request() {
        return $this->belongsTo('App\Models\SiteEmployeeRequest', 'site_employee_request_id');
    }
}
