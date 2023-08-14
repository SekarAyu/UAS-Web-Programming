<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Course extends Authenticatable
{
    use HasFactory;


    protected $table = 'course';

    protected $fillable = [
        'Id',
        'CourseName',
        'Price',
        'Days',
        'IsCertificate',
        'IsActive',
    ];
}
