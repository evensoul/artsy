<?php

namespace Laravel\Nova\Menu;

use JsonSerializable;
use Laravel\Nova\AuthorizedToSee;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Makeable;
use Laravel\Nova\URL;
use Laravel\Nova\WithBadge;

/**
 * @method static static make(string $name, array|iterable $items = [], string $icon = 'collection')
 */
class MenuSection implements JsonSerializable
{
    use AuthorizedToSee;
    use Makeable;
    use WithBadge;

    /**
     * The menu's component.
     *
     * @var string
     */
    public $component = 'menu-section';

    /**
     * The menu's name.
     *
     * @var string
     */
    public $name;

    /**
     * The menu's items.
     *
     * @var \Illuminate\Support\Collection
     */
    public $items;

    /**
     * The menu's collapsable state.
     *
     * @var bool
     */
    public $collapsable = false;

    /**
     * the menu's icon.
     *
     * @var string
     */
    public $icon;

    /**
     * The menu's path.
     *
     * @var string|null
     */
    public $path;

    /**
     * Construct a new Menu Section instance.
     *
     * @param  string  $name
     * @param  array|iterable  $items
     * @param  string  $icon
     */
    public function __construct($name, $items = [], $icon = 'collection')
    {
        $this->name = $name;
        $this->items = collect($items);
        $this->icon = $icon;
    }

    /**
     * Create a menu from dashboard class.
     *
     * @param  class-string<\Laravel\Nova\Dashboard>  $dashboard
     * @return static
     */
    public static function dashboard($dashboard)
    {
        return with(new $dashboard(), function ($dashboard) {
            return static::make(
                $dashboard->label()
            )->path('/dashboards/'.$dashboard->uriKey())
                ->canSee(function ($request) use ($dashboard) {
                    return $dashboard->authorizedToSee($request);
                });
        });
    }

    /**
     * Set path to the menu.
     *
     * @param  string  $path
     * @return $this
     */
    public function path($path)
    {
        $this->path = $path;
        $this->collapsable = false;

        return $this;
    }

    /**
     * Set the menu section as collapsable.
     *
     * @return $this
     */
    public function collapsable()
    {
        $this->collapsable = true;
        $this->path = null;

        return $this;
    }

    /**
     * Set the menu section as collapsable.
     *
     * @return $this
     */
    public function collapsible()
    {
        return $this->collapsable();
    }

    /**
     * Set icon to the menu.
     *
     * @param  string  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Prepare the menu for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $request = app(NovaRequest::class);
        $url = ! empty($this->path) ? URL::make($this->path) : null;

        return [
            'key' => md5($this->name.'-'.$this->path),
            'name' => $this->name,
            'component' => 'menu-section',
            'items' => $this->items->reject(function ($item) use ($request) {
                return method_exists($item, 'authorizedToSee') && ! $item->authorizedToSee($request);
            })->values(),
            'collapsable' => $this->collapsable,
            'icon' => $this->icon,
            'path' => (string) $url,
            'active' => optional($url)->active() ?? false,
            'badge' => $this->resolveBadge(),
        ];
    }
}
