<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* Role helpers */
    public function isUser(): bool { return $this->role === 'user'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }

    /* Relations */
    public function affiliate() { return $this->hasOne(Affiliate::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function answerSheets() { return $this->hasMany(AnswerSheet::class); }
    public function createdPackages() { return $this->hasMany(Package::class, 'created_by'); }
    public function createdVouchers() { return $this->hasMany(Voucher::class, 'created_by'); }
    public function approvedWithdrawals() { return $this->hasMany(Withdrawal::class, 'approved_by'); }
}
