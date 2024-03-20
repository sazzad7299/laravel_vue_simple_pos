<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory,SoftDeletes,CreatedUpdatedBy;
    protected $table = 'settings';
    protected $fillable = ['post_id','meta_key','meta_value','created_by','updated_by'];
}