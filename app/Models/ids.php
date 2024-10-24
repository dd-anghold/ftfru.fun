<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Access\RoleAccess;
use Orchid\Access\RoleInterface;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class ids extends Model
{
    use AsSource, Chartable, Filterable, HasFactory, RoleAccess;

    protected $table = 'ids';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'steamid',
        'streamid',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id' => Where::class,
        'steamid' => Like::class,
        'streamid' => Like::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'steamid',
        'streamid'
    ];
}
