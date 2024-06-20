<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentsResource\Pages;
use App\Filament\Resources\CommentsResource\RelationManagers;
use App\Models\Comments;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsResource extends Resource
{
    protected static ?string $model = Comments::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label("User")
                    ->options(User::all()->pluck('name', 'id'))
                    ->default(auth()->user()->id)
                    ->searchable()
                    ->required()
                    ->hidden(fn (string $operation): bool => $operation === 'edit'),

                Forms\Components\Select::make('post.message')
                    ->label('Post')
                    ->options(Post::all()->pluck('message'))
                    ->searchable()
                    ->required()
                    ->hidden(fn (string $operation): bool => $operation === 'edit'),
                Forms\Components\TextInput::make('comment')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Comments $comments) : ?string => $comments->created_at?->isoFormat('LLL'))
                            ->hidden(fn (string $operation): bool => $operation === 'create'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Comments $comments) : ?string => $comments->updated_at?->isoFormat('LLL'))
                            ->hidden(fn (string $operation): bool => $operation === 'create'),
                        ])
                        ->hidden(fn (?Comments $comments) => null === $comments)
                        ->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('comment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('post.message')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComments::route('/create'),
            'edit' => Pages\EditComments::route('/{record}/edit'),
        ];
    }
}
