<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use MoonShine\Laravel\Fields\Relationships\HasOne;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Пользователи';

    protected int $itemsPerPage = 5;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Text::make('Email')->sortable(),
            Text::make('Страна', 'country.name'),
            Text::make('Avatar'),

//            HasOne::make('Страна', 'country', resource: CountryResource::class)
//                ->sortable()
//                ->fields([
//                    Text::make(column: 'name')
//                ])
//            ,
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Name'),
                Text::make('Email'),
                Image::make('Avatar')
                    ->onApply(function ( $value , Model $item,){

                        dd($value->getRealPath());
                        $image = ImageManager::imagick()->read($value->getRealPath());
                        $image->resize(300, 200);
//                            ->encode();

                        $filename = Str::uuid() . '.' . $value->getClientOriginalExtension();

                        $image->save( $filename);

//                        Storage::put('/photos' . $filename, $image);

                        return 'photos/' . $filename;
                    })
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param User $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
