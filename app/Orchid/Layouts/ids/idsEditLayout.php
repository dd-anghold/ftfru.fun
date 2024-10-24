<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ids;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class idsEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('ids.steamid')
                ->type('number')
                ->required()
                ->title(__('Steam ID'))
                ->placeholder(__('Steam ID'))
                ->help(__('Role display name')),

            Input::make('ids.streamid')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Stream ID'))
                ->placeholder(__('Stream ID'))
                ->help(__('Actual name in the system')),
        ];
    }
}
