<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZnsMessage extends Model
{
    use HasFactory;

    protected $table = 'sgo_zns_messages';

    protected $fillable = [
        'name',
        'phone',
        'sent_at',
        'status',
        'note',
        'template_id',
        'oa_id',
        'user_id',
    ];

    // Define a relationship with OaTemplate
    public function template()
    {
        return $this->belongsTo(OaTemplate::class, 'template_id');
    }

    // Define a relationship with ZaloOa
    public function zaloOa()
    {
        return $this->belongsTo(ZaloOa::class, 'oa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
