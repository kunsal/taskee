<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $guarded = [];

    protected $dates = ['due_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
