<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'type',
        'price',
        'duration_minutes',
        'passing_grade',
        'thumbnail',
        'status',
        'created_by',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
