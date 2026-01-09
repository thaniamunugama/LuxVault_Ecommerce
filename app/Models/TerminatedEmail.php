<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminatedEmail extends Model
{
    use HasFactory;

    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'reason',
        'terminated_at',
    ];
}

