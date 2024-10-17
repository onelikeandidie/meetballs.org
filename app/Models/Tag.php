<?php

namespace App\Models;

use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $icon
 * @property Project[] $projects
 */
class Tag extends Model
{
    protected $fillable = [
        'name',
        'color',
        'icon',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_tags');
    }

    /**
     * Generate an array of color shades filled with the tag's color.
     * @return array
     */
    public function toColorsArray()
    {
        return Color::hex($this->color);
    }
}
