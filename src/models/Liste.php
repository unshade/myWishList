<?php
namespace mywishlist\models;
class liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function items() {
        return $this->hasMany('mywishlist\models\Item','id');
    }
}