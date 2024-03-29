<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\Line;

class LineGroup extends Model{

    protected $table = 'line_groups';
    protected $primaryKey = 'id_auto';
    protected $hidden = ['created_at', 'updated_at', 'id_auto', 'isDeleted'];

    //Fields Modifiable by PATCH / POST
    protected $fillable = [
        'name_chi', 'name_eng', 'name_eng_short',
        'remarks', 'other_info',
    ];
    
    //JSON fields
    protected $casts = [
        'other_info' => 'object',
    ];

    //Data validations
    public static $validations_update = [
        'sort' => 'integer',
        'other_info' => 'json',
    ];
    public static $validations_new = [
        'sort' => 'integer',
        'name_chi' => 'required',
        'name_eng' => 'required',
        'other_info' => 'json',
    ];

    //Filters
    public static function filters($query, $param){
        switch ($query){
            case 'name_chi':
            return ['query' => 'LOWER(name_chi) LIKE LOWER(?)', 'params' => ["%$param%"]];
            case 'name_eng':
            return ['query' => 'LOWER(name_eng) LIKE LOWER(?)', 'params' => ["%$param%"]];
        }
    }
    
    //Sortings
    public static $sort_default = 'name_eng';
    public static $sortable = ['name_chi', 'name_eng', 'name_eng_short'];

    //Resource Relationships
    public function lines(){
        return $this->hasMany(Line::class, 'line_group_id', 'id')->where('isDeleted', false);
    }

    //Display data returned for GET
    public function displayData($request){
        $data = clone $this;
        //Show total distance
        $length_total = Line::selectRaw('sum(length_km)')
        ->where('isDeleted', false)->where('line_group_id', $this->id)->first()->sum;
        $data->length_km_total = round(floatval($length_total), 1);
        //"from_selecter" -> Only essential fields for selecter
        if ($request->input("from_selecter")){
            $data = (object)[
                "id" => $data->id,
                "name_chi" => $data->name_chi,
                "name_eng" => $data->name_eng,
            ];
        }
        //"more" -> Get also lines as well
        if ($request->input('more')){
            $query = $this->lines()->orderBy('name_eng', 'asc');
            if ($request->input("from_selecter")){
                $data->lines = $query->selectRaw('id, name_chi, name_eng')->get();
            }else{
                $data->lines = $query->get();
            }
        }
        return $data;
    }

    /**
     * Custom Methods
     */


}
