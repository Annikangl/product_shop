<?php


namespace App\Traits\Models;


use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    // TODO unique slug
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if (!$this->{$this->slugColumn()}) {
            $slug = $this->uniqueSlug(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );

            $this->{$this->slugColumn()} = $slug;
        }
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    protected function slugFrom(): string
    {
        return 'title';
    }

    protected function uniqueSlug(string $slug): string
    {
        $originalSLug = $slug;
        $i = 0;

        while (Product::query()->where('slug', $slug)->exists()) {
            $i++;
            $slug = $originalSLug . '-' . $i;
        }

        return $slug;
    }
}
