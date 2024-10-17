<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostResource\Pages;
use App\Filament\Resources\HostResource\RelationManagers;
use App\Models\Host;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostResource extends Resource
{
    protected static ?string $model = Host::class;

    protected static ?string $navigationGroup = 'Projects';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image.path')
                    ->label('Image')
                    ->saveRelationshipsUsing(function ($record, $state) {
                        $hostImage = $record->image;
                        if (!$hostImage) {
                            $hostImage = new \App\Models\HostImage();
                            $hostImage->host_id = $record->id;
                        }
                        if (!empty($state)) {
                            $hostImage->path = collect($state)->first();
                            $hostImage->save();
                        } else {
                            $hostImage->delete();
                        }
                    })
                    ->afterStateHydrated(fn (?Host $record, Forms\Set $set) => $record?->image?->path && $set('image.path', [$record?->image?->path]))
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->minSize(1)
                    ->maxSize(2048)
                    ->nullable(),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image.path')
                    ->label('Image')
                    ->sortable(),
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
            'index' => Pages\ListHosts::route('/'),
            'create' => Pages\CreateHost::route('/create'),
            'edit' => Pages\EditHost::route('/{record}/edit'),
        ];
    }
}
