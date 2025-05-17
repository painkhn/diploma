<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'content',
    ];

    public function Task()
    {
        return $this->belongsTo(Task::class);
    }
}
