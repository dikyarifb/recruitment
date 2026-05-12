<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use DateTime;

class Scheduler extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // time, type, sub_type, email, status
    protected $table = 'scheduler';
    protected $dates = ['time'];

    public function scopeLatest($query){
        return $query->orderBy('id', 'desc');
    }
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function scopeRunningTask($query){
        return $query->whereTime('time','<', date('H:i:s'))->where('status', 1);
    }
    public function getStatusTextAttribute(){
        $status = $this->status;
        $text= 'Passed';

        if($this->created_at->format('Y-m-d') == date('Y-m-d')){
            switch ($status) {
                case 1:
                    $now = strtotime(date('H:i'));
                    $time = strtotime($this->time->format('H:i'));
                    if($now >= $time){
                        $text = 'On Processed';
                    }else{
                        $text = 'Scheduled';
                    }
                    # code...
                    break;
                case 3:
                    $text = 'Failed';
                    break;
                default:
                    $text = 'Done';
                    break;
            }
        }
        
        return $text;
    }
    public function getStatusColorAttribute(){
        $status = $this->status;
        $text= 'primary';
        if($this->created_at->format('Y-m-d') == date('Y-m-d')){
            switch ($status) {
                case 1:
                    $now = strtotime(date('H:i'));
                    $time = strtotime($this->time->format('H:i'));
                    if($now >= $time){
                        $text = 'danger';
                    }else{
                        $text = 'info';
                    }
                    # code...
                    break;
                case 3:
                    $text = 'danger';
                    break;
                default:
                    $text = 'success';
                    break;
            }
        }
        return $text;
    }
}
