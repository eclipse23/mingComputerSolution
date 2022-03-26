<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReplyInquire extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y h:m a');
    }

    public function inquire()
    {
        return $this->belongsTo(Inquire::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
