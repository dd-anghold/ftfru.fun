<?php

namespace App\Orchid\Screens\ids;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Добавлено для проверки уникальности
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Models\ids;
use App\Orchid\Layouts\ids\idsEditLayout;

class idsEditScreen extends Screen
{

    /**
     * @var ids
     */
    public $ids;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ids $ids): iterable
    {
        return [
            'ids' => $ids,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edit IDs';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->method('remove'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block([
                idsEditLayout::class
            ])
        ];
    }

    public function save(Request $request, ids $ids)
    {   
        $validatedData = $request->validate([
            'ids.streamid' => [
                'required',
                Rule::unique(ids::class, 'streamid')->ignore($ids->id),
            ],
            'ids.steamid' => [
                'required',
                Rule::unique(ids::class, 'steamid')->ignore($ids->id),
            ],
            'ids.teamspeakid' => [
                Rule::unique(ids::class, 'teamspeakid')->ignore($ids->id),
            ],
        ]);
    
        // Заполняем данные для модели
        $ids->fill([
            'streamid' => $validatedData['ids']['streamid'],
            'steamid' => $validatedData['ids']['steamid'],
        ]);
        
        $ids['teamspeakid']=$validatedData['ids']['teamspeakid'];
        
        $ids->save();
    
        Toast::info(__("Id's was saved"));
    
        return redirect()->route('platform.systems.ids');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(ids $ids)
    {
        $ids->delete();

        Toast::info(__('IDs was removed'));

        return redirect()->route('platform.systems.ids');
    }
}
