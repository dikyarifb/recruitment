<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon;
class SiteEmployeeRequest extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'site_employee_request';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function eform() {
        return $this->hasOne('App\Models\Eform', 'form_id')->where('name', 'Structure Request');
    }
    public function logs() {
        return $this->hasMany('App\Models\SiteEmployeeRequestLog', 'site_employee_request_id');
    }
    public function site() {
        return $this->belongsTo('App\Models\Sites', 'site_id');
    }
    public function structures() {
        return $this->hasMany('App\Models\SiteEmployeeRequestStructure', 'site_employee_request_id')->orderBy('position', 'asc');
    }
    public function supervisor(){
        return $this->hasOne('App\Models\SiteEmployeeRequestStructure', 'site_employee_request_id')->where('position','like', 'Supervisor');
    }
    public function team_leader(){
        return $this->hasOne('App\Models\SiteEmployeeRequestStructure', 'site_employee_request_id')->where('position','like', 'Team Leader');
    }
    public function getStructureCountAttribute(){
        $structures = [];
        $final_structures = [];
        foreach ($this->structures as $key => $structure) {
            if(!in_array($structure->position, $structures)){
                $structures[] = $structure->position;
            }
        }
        foreach ($structures as $key => $structure) {
            $male_count = $this->structures->where('position', $structure)->where('gender', 'Male')->count();
            $female_count = $this->structures->where('position', $structure)->where('gender', 'Female')->count();
            $male_count_filled = $this->structures->where('user_id', '<>', NULL)->where('position', $structure)->where('gender', 'Male')->count();
            $female_count_filled = $this->structures->where('user_id', '<>', NULL)->where('position', $structure)->where('gender', 'Female')->count();
            $total = $male_count + $female_count;
            $filled = $this->structures->where('user_id', '<>', NULL)->where('position', $structure)->count();
            if($filled > 0){
                $progress = ($filled / $total) * 100;
            }else{
                $progress = 0;
            }
            
            $final_structures[] = [
                'position' => $structure,
                'progress' => ceil($progress),
                'count' => [
                    'male' => $male_count,
                    'female' => $female_count
                ],
                'count_filled' => [
                    'male' => $male_count_filled,
                    'female' => $female_count_filled
                ]
            ];
        }
        return $final_structures;
    }
    public function getAvailableStructureAttribute(){
        $structures = [];
        $final_structures = [];
        foreach ($this->structures as $key => $structure) {
            if(!in_array($structure->position, $structures)){
                $structures[] = $structure->position;
            }
        }
        foreach ($structures as $key => $structure) {
            if($this->structures->where('position', $structure)->where('status', 'empty')->count() > 0){
                $final_structures[] = $structure;
            }
           
        }
        return $final_structures;
    }
    public function getEffectiveDateAttribute($value){
        $date = Carbon\Carbon::parse($value);
        return $date->format('F j, Y');
    }
}
