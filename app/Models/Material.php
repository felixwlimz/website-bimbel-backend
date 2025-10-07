<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{
    use HasFactory;
    //
    
    protected $fillable = [
        'title',
        'drive_link',
        'preview',
        'package_id'
    ];

    protected $table = 'material';

    public $incrementing = false;
    protected $keyType = 'string';

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // ✅ generate UUID
            }
        });
    }



    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
