<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;

class Reply extends Model
{

    use Favoritable;

	protected $guarded = [];

	protected $with = [ 'owner', 'favorites' ];

	public function owner()
	{

		return $this->belongsTo( User::class, 'user_id' );

	}


}
