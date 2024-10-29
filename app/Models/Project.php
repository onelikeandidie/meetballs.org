<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

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

    public function forgetImage()
    {
        Storage::delete('project-image-' . $this->id . '.webp');
    }

    /**
     * Generate the project image
     *
     * @param bool $force Whether to force the generation of the image
     * @return string The path to the generated image
     */
    public function generateImage(bool $force = false): string
    {
        $imagePath = storage_path('app/public/project-image-' . $this->id . '.webp');
        $image = Storage::exists($imagePath);
        if (!$image || $force) {
            $manager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            // Create a white background image
            $image = $manager->create(400, 200);
            $image->fill('#ffffff');

            // Add the website name
            $image->text(config('app.name'), 20, 20, function ($font) {
                $font->file(resource_path('fonts/InterDisplay-Medium.ttf'));
                $font->size(22);
                $font->color('#000000aa');
                $font->align('left');
                $font->valign('top');
            });
            // Add the project title
            $image->text($this->name, 20, 48, function ($font) {
                $font->file(resource_path('fonts/overdozesans.ttf'));
                $font->size(64);
                $font->color('#000000');
                $font->align('left');
                $font->valign('top');
                $font->wrap(360);
                $font->lineHeight(1.6);
            });
            $descriptionStart = 84;
            if (strlen($this->name) > 16) {
                $descriptionStart += 36;
            }
            // If the title is too big (typically 32 characters), then there is no space for the description
            if (strlen($this->name) <= 32) {
                // Add the project description
                $image->text(Str::limit($this->description, 80), 20, $descriptionStart, function ($font) {
                    $font->file(resource_path('fonts/InterDisplay-Medium.ttf'));
                    $font->size(18);
                    $font->color('#000000aa');
                    $font->align('left');
                    $font->valign('top');
                    $font->wrap(360);
                    $font->lineHeight(1.5);
                });
            }
            // Add the tags
            $tags = $this->tags;
            $startX = 20;
            // $startY = $descriptionStart + 64;
            $startY = 200 - 24;
            foreach ($tags as $tag) {
                if ($tag == "featured") {
                    continue;
                }
                $parentTag = \App\Models\Tag::where('name', $tag)->first();
                $length = Str::length($tag) * 8 + 4;
                if ($startX + $length > 380) {
                    $startX = 20;
                    $startY += 20;
                }
                $image->text('#' . $tag, $startX, $startY, function ($font) use ($parentTag) {
                    $font->file(resource_path('fonts/InterDisplay-Medium.ttf'));
                    $font->size(14);
                    $font->color($parentTag->color ?? '#000000');
                    $font->align('left');
                    $font->valign('top');
                });
                $startX += $length;
            }


            // Save the image to the cache
            $encodedImage = $image->toWebp();
            $filepath = storage_path('app/public/project-image-' . $this->id . '.webp');
            $encodedImage->save($filepath);
        }

        return $imagePath;
    }
}
