<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description'
    ];
    public function getPages($slug){
    	return self::where('slug',$slug)->first();
    }
    public function updatePage($id,$dataArr){
    	return self::where('id',$id)->update($dataArr);
    }
    public function savePage($dataArr){
    	return self::create($dataArr);
    }
}
