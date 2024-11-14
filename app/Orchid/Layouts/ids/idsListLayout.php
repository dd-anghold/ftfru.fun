<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\ids;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

use App\Models\ids;

class idsListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'ids';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', __('ID'))
                ->sort(),

            TD::make('streamid', __('Stream ID'))
                ->sort()
                ->render(fn(ids $ids) => Link::make($ids->streamid)
                    ->route('platform.systems.ids.edit', $ids->id)),

            TD::make('teamspeakid', __('TeamSpeak ID'))
                ->sort(),

            TD::make('steamid', __('Steam ID'))
                ->sort(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),
        ];
    }
}
