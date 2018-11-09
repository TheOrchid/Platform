<?php

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\UTMField;
use Orchid\Screen\Fields\CodeField;
use Orchid\Screen\Fields\TagsField;
use Orchid\Screen\Fields\InputField;
use Orchid\Screen\Fields\SelectField;
use Orchid\Screen\Fields\PictureField;
use Orchid\Screen\Fields\TinyMCEField;
use Orchid\Screen\Fields\CheckBoxField;
use Orchid\Screen\Fields\TextAreaField;
use Orchid\Screen\Fields\DateTimerField;
use Orchid\Screen\Fields\SimpleMDEField;

class RowExample extends Rows
{
    /**
     * @return array
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [

            Field::group([

                InputField::make('name')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Name Articles')
                    ->help('Article title'),

                InputField::make('title')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title('Article Title')
                    ->help('SEO title'),

            ]),

            Field::group([

                DateTimerField::make('open')
                    ->title('Opening date')
                    ->help('The opening event will take place'),

                InputField::make('phone')
                    ->type('text')
                    ->mask('(999) 999-9999')
                    ->title('Phone')
                    ->help('Number Phone'),

                CheckBoxField::make('free')
                    ->sendTrueOrFalse()
                    ->title('Free')
                    ->placeholder('Event for free')
                    ->help('Event for free'),
            ]),

            TextAreaField::make('description')
                ->max(255)
                ->rows(5)
                ->required()
                ->title('Short description'),

            TinyMCEField::make('body')
                ->required()
                ->title('Name Articles')
                ->help('Article title'),

            PictureField::make('picture')
                ->name('picture')
                ->width(500)
                ->height(300),

            UTMField::make('link')
                ->title('UTM link')
                ->help('Generated link'),

            SelectField::make('robot.')
                ->options([
                    'index' => 'Index',
                    'noindex' => 'No index',
                ])
                ->multiple()
                ->title('Indexing')
                ->help('Allow search bots to index'),

            TagsField::make('keywords')
                ->title('Keywords')
                ->help('SEO keywords'),

            SimpleMDEField::make('body2')
                ->title('Name Articles')
                ->help('Article title'),

            CodeField::make('code')
                ->title('Name Articles')
                ->help('Article title'),

        ];
    }
}
