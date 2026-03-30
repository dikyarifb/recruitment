<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use DateTime;

class SiteEmployeeRequestStructure extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'site_employee_request_structure';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function site_before() {
        return $this->belongsTo('App\Models\Sites', 'site_before_id');
    }
    public function scopeGroupPosition($query){
        return $query->select('position')->groupBy('position');
    }
    public function site_employee_request(){
        return $this->belongsTo('App\Models\SiteEmployeeRequest', 'site_employee_request_id');
    }
    public function scopeAvailable(){
        return $this->whereHas('site_employee_request', function($paret){
            $paret->where('status', 'requested');
        })->where('status','empty');
    }
    public function getSiteAttribute(){
        return $this->site_employee_request->site;
    }
    public function scopeByParentId($query, $id){
        return $query->where('site_employee_request_id', $id);
    }
    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }
    public function scopePosition($query, $position){
        return $query->where('position', $position);
    }
}
