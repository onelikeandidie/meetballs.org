<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property string $icon
 * @property string $url
 * @property string $name
 */
class ProjectLink extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'url',
        'icon',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
