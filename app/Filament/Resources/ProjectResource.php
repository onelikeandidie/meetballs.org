<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostResource\Pages\EditHost;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationGroup = 'Projects';
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\Select::make('host_id')
                    ->relationship('host', 'name')
                    ->label('Host')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(function () {
                        return [
                            Forms\Components\TextInput::make('name')
                                ->label('Name')
                                ->required(),
                        ];
                    })
                    ->suffixAction(fn($state) => $state ?
                        Forms\Components\Actions\Action::make('edit-host')
                            ->label('Edit')
                            ->icon('heroicon-o-pencil-square')
                            ->color('gray')
                            ->url(EditHost::getUrl(['record' => $state])) : null
                    )
                    ->nullable(),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required(),
                Forms\Components\DateTimePicker::make('event_date')
                    ->label('Event Date')
                    ->default(now()->setTime(19, 0, 0))
                    ->required(),
                Forms\Components\TagsInput::make('tags'),
                Forms\Components\Repeater::make('links')
                    ->relationship('links')
                    ->defaultItems(0)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->required(),
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon')
                            ->default('heroicon-o-link')
                            ->hint("https://blade-ui-kit.com/blade-icons")
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->limit(20)
                    ->tooltip(fn (Project $project) => $project->name)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('host.name')
                    ->label('Host')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('host.image.path')
                    ->label('Host Image')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(fn (Project $project) => $project->description)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tags')
                    ->label('Tags')
                    ->listWithLineBreaks()
                    ->badge()
                    ->icon(fn ($state) => (Tag::where('name', $state)->first()?->icon) ?? 'heroicon-o-tag')
                    ->color(fn ($state) => Tag::where('name', $state)->first()?->toColorsArray() ?? 'gray')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Event Date')
                    ->dateTime()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
