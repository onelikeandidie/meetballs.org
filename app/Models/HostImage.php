<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $path
 * @property string $host_id
 * @property Host $host
 */
class HostImage extends Model
{
    protected $fillable = [
        'path',
        'host_id',
    ];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
