<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Symfony\Component\Yaml\Inline;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->default(auth()->user()->id)
                    ->required(),
                Forms\Components\TextInput::make('message')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Post $post) : ?string => $post->created_at?->isoFormat('LLL'))
                                ->hidden(fn (string $operation): bool => $operation === 'create'),

                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Post $post) : ?string => $post->updated_at?->isoFormat('LLL'))
                                ->hidden(fn (string $operation): bool => $operation === 'create'),
                        ])
                        ->hidden(fn (?Post $post) => null === $post)
                        ->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
