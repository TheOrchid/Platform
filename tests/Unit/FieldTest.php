<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\UTM;
use Orchid\Tests\TestUnitCase;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TinyMCE;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Illuminate\Contracts\View\View;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\RadioButtons;

/**
 * Class FieldTest.
 */
class FieldTest extends TestUnitCase
{
    /**
     * @return array
     */
    public function exampleFields()
    {
        return [
            [TextArea::class,
             [
                 'name' => 'example',
             ], ],
            [Input::class,
             [
                 'name' => 'example',
             ], ],
            [Select::class,
             [
                 'name'    => 'example',
                 'options' => [],
             ], ],
            [RadioButtons::class,
             [
                 'name'    => 'example',
                 'options' => ['value' => 'example'],
             ], ],
            [Map::class,
             [
                 'name' => 'example',
             ], ],
            [Cropper::class,
             [
                 'name'   => 'example',
                 'width'  => '100',
                 'height' => '100',
             ], ],
            [DateTimer::class,
             [
                 'name' => 'example',
             ], ],
            [CheckBox::class,
             [
                 'name' => 'example',
             ], ],
            [TinyMCE::class,
             [
                 'name' => 'example',
             ], ],
            [Password::class,
             [
                 'name' => 'example',
             ], ],
            [SimpleMDE::class,
             [
                 'name' => 'example',
             ], ],
            [Upload::class,
             [
                 'name' => 'example',
             ], ],
            [UTM::class,
             [
                 'name' => 'example',
             ], ],
            [DateRange::class,
             [
                 'name' => 'example',
             ], ],
            [Switcher::class,
             [
                 'name' => 'example',
             ], ],
            [Picture::class,
             [
                 'name' => 'example',
             ], ],
        ];
    }

    /**
     * @param string $field
     * @param mixed  $options
     *
     * @dataProvider exampleFields
     *
     * @throws \Throwable
     */
    public function testHasCorrectInstance(string $field, $options)
    {
        /** @var \Orchid\Screen\Field $field */
        $field = new $field();

        foreach ($options as $key => $option) {
            $field->set($key, $option);
        }

        $view = $field->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertStringContainsString('example', $view->withErrors([])->render());
    }
}
