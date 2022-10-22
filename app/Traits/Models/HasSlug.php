<?php


namespace App\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    // TODO unique slug
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->slug = $model->slug
                ??
                str($model->{self::slugFrom()})
                    ->append(time())
                    ->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}
