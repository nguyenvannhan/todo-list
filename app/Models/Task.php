<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title', 'description', 'completed', 'user_id'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $with = ['user'];

    /** Relationship n - 1 */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
