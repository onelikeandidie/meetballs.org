<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property Project[] $projects
 * @property HostLink[] $links
 */
class Host extends Model
{
    protected $fillable = [
        'name',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function links()
    {
        return $this->hasMany(HostLink::class);
    }

    public function image()
    {
        return $this->hasOne(HostImage::class);
    }
}
