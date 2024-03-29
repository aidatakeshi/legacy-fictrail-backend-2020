<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ScheduleTrip extends Model{

    protected $table = 'schedule_trips';
    protected $primaryKey = 'id_auto';
    protected $hidden = ['created_at', 'updated_at', 'id_auto', 'isDeleted'];

    //Fields Modifiable by PATCH / POST
    protected $fillable = [
        'version_id', 'schdraft_template_id',
        'operator_id', 'train_type_id', 'train_name_id',
        'operator_info', 'train_type_info', 'train_name_info', 'train_consist_info',
        'train_number', 'trip_number', 'run_number',
        'wk', 'ph', 'remarks', 'other_info',
    ];

    //Data validations
    public static $validations_update = [

    ];
    public static $validations_new = [

    ];

    //Filters
    public static function filters($query, $param){
    }
    
    //Sortings
    public static $sort_default = 'sort';
    public static $sortable = [];

    //Resource Relationships

    //Display data returned for GET
    public function displayData($request){
        return [

        ];
    }

    //Additional processing of data
    public function whenGet($request){

    }
    public function whenSet($request){
        
    }
    public function whenCreated($request){

    }
    public function whenRemoved($request){

    }

    /**
     * Custom Methods
     */


}
