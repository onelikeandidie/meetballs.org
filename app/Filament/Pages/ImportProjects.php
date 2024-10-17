<?php

namespace App\Filament\Pages;

use App\Libraries\Importer\Parser;
use App\Libraries\Importer\Project as ParsedProject;
use App\Models\Project;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

/**
 * Page where the user can upload the old readme file to import the projects.
 */
class ImportProjects extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.import-projects';
    protected static ?string $navigationGroup = 'Legacy';

    public $fileContent = '';
    public $projectsParsed = 0;

    /** @var Collection<ParsedProject> */
    private Collection $projects;

    public function mount(): void
    {
        $this->projects = collect();
    }

    public function parseProjects()
    {
        $parser = new Parser();
        $this->projects = $parser->parse($this->fileContent);
        $this->projectsParsed = $this->projects->count();
    }

    public function importProjects()
    {
        $parser = new Parser();
        $this->projects = $parser->parse($this->fileContent);
        if ($this->projects->isEmpty()) {
            panic('No projects to import.');
        }
        $result = $parser->import($this->projects);

        if ($result->count() === 0) {
            Notification::make()
                ->title('No Projects Imported')
                ->body('No projects were imported. Please check the file and try again.')
                ->danger()
                ->send();
            return;
        }

        Notification::make()
            ->title($result->count() . ' Projects Imported')
            ->body('The projects have been imported successfully.')
            ->success()
            ->send();
    }
}
