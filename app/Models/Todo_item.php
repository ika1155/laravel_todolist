<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo_item extends Model
{
    use HasFactory;

	protected $fillable = [
		'item_name',
		'user_id',
		'registration_date',
		'expire_date',
		'finished_date'
	];

	public function user(){
		return $this->belongsTo(User::class);
	}
}
