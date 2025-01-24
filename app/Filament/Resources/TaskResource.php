<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Str;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
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
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Filters\SelectFilter::make('user_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->label('User')
                    ->searchable()
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
