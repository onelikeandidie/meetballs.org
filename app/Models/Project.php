<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $host_id
 * @property Collection<string> $tags
 * @property Host $host
 * @property ProjectLink[] $links
 */
class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'host_id',
        'tags',
    ];

    protected $casts = [
        'tags' => 'collection',
    ];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function links()
    {
        return $this->hasMany(ProjectLink::class);
    }
}
