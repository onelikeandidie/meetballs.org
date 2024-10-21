<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        return view('project', [
            'project' => $project,
        ]);
    }

    public function image(Project $project)
    {
        $imagePath = storage_path('app/public/project-image-' . $project->id . '.webp');
        $image = Storage::exists($imagePath);
        if (!$image) {
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
            $image->text($project->name, 20, 48, function ($font) {
                $font->file(resource_path('fonts/overdozesans.ttf'));
                $font->size(64);
                $font->color('#000000');
                $font->align('left');
                $font->valign('top');
                $font->wrap(360);
            });
            // Add the project description
            $image->text(Str::limit($project->description, 80), 20, 84, function ($font) {
                $font->file(resource_path('fonts/InterDisplay-Medium.ttf'));
                $font->size(18);
                $font->color('#000000aa');
                $font->align('left');
                $font->valign('top');
                $font->wrap(360);
                $font->lineHeight(1.5);
            });
            // Add the tags
            $tags = $project->tags;
            $startX = 20;
            $startY = 148;
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
            $filepath = storage_path('app/public/project-image-' . $project->id . '.webp');
            $encodedImage->save($filepath);
        }

        return response()->file($imagePath);
    }
}
