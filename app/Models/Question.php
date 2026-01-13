<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    /* =========================
     * TABLE
     * ========================= */

    protected $table = 'questions';



    protected $fillable = [
        'package_id',

        'title',
        'content',

        // media
        'media_type',
        'media_path',

        // scoring
        'weight',

        // classification
        'sub_topic_id',

        // explanation
        'explanation',
    ];

    /* =========================
     * CASTS
     * ========================= */

    protected $casts = [
        'weight' => 'integer',
    ];

    /* =========================
     * RELATIONSHIPS
     * ========================= */

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class);
    }
}
