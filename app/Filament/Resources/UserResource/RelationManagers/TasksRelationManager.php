<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\MarkdownEditor::make('description')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->default(Task::NEW)
                    ->options(collect(TaskController::$status)->mapWithKeys(fn ($value,$key) => [
                        $key => $value['title'],
                    ])),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->numeric(),
                Tables\Columns\TextColumn::make('title')
                    ->description(fn(Task $record) => Str::limit($record->description, 50, '...'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn(string $state) => TaskController::$status[$state]['title'])
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Task::NEW => 'success',
                        Task::IN_PROGRESS => 'warning',
                        Task::DONE => 'danger',
                    }),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(TaskController::$status)->mapWithKeys(fn ($value,$key) => [
                        $key => $value['title'],
                    ])),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
