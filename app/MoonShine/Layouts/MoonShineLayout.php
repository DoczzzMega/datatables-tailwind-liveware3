<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\Models\User;
use App\MoonShine\Resources\CountryResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Fragment;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\{Layout\Body,
    Layout\Content,
    Layout\Div,
    Layout\Flash,
    Layout\Html,
    Layout\Layout,
    Layout\Wrapper};

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),

            MenuGroup::make(__('moonshine::menu.Group-links'), [
                MenuItem::make('Google', 'https://google.com')
//                    ->customAttributes(['style'=> 'background-color: red'])
//                    ->style('background-color: red')
                    ->blank()
                    ->icon('document-arrow-down'),
                MenuDivider::make(),
                MenuItem::make('Facebook', 'https://facebook.com')
                    ->badge(fn() => 4)
                    ->blank()
                    ->icon('document'),
                MenuItem::make(__('moonshine::menu.Comments'), 'https://google.com')
                    ->icon('chat-bubble-bottom-center-text')
                    ->blank()
                    ->canSee(fn () => auth()->id() != 2)
            ])->icon('document-check'),
            MenuItem::make(__('moonshine::menu.Users'), UserResource::class)
                ->badge(fn() => User::all()->count())
                ->icon('m.user'),
            MenuItem::make('Countries', CountryResource::class),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

//         $colorManager->primary('#00000');
         $colorManager
                 ->bulkAssign([
                     'primary' => '50, 180, 180',
                     'secondary' => '50, 170, 240',
                     'body' => '50, 50, 50',
                 ]);
    }

    protected function getLogo(bool $small = false): string
    {
        return parent::getLogo($small);
    }

    public function build(): Layout
    {
        return Layout::make([
            Html::make([
                $this->getHeadComponent(),
                Body::make([
                    Wrapper::make([
                        // $this->getTopBarComponent(),
                        $this->getSidebarComponent(),

                        Div::make([
                            Fragment::make([
                                Flash::make(),

                                $this->getHeaderComponent(),

                                Content::make($this->getContentComponents()),

//                                $this->getFooterComponent(),
                            ])->class('layout-page')->name(self::CONTENT_FRAGMENT_NAME),
                        ])->class('flex grow overflow-auto')->customAttributes(['id' => self::CONTENT_ID]),
                    ]),
                ]),
            ])
                ->customAttributes([
                    'lang' => $this->getHeadLang(),
                ])
                ->withAlpineJs()
                ->withThemes(),
        ]);
    }
}
