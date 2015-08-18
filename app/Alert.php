<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Alert extends Model
{
	protected $fillable = [
		'email',
		'stop',
		'route',
		'departure_time',
		'time_to_stop',
		'lead_time',
		'alert_time',
		'last_sent',
		'timezone'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function belongsToUser() {
    	return $this->user_id == Auth::user()->id;
    }
}
