<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectUserFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'role'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
