<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $host_id
 * @property string $name
 * @property string $url
 * @property string $icon
 * @property Host $host
 */
class HostLink extends Model
{
    protected $fillable = [
        'host_id',
        'name',
        'url',
        'icon',
    ];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }
}
