<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'package_id',
        'title',
        'drive_link',
        'access_type',
        'order',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
