<?php

namespace Laravel\Nova;

trait WithBadge
{
    /**
     * The badge content for the menu item.
     *
     * @var (\Closure():\Laravel\Nova\Badge)|callable|null|\Laravel\Nova\Badge
     */
    public $badgeCallback;

    /**
     * The type of badge that should represent the item.
     *
     * @var string
     */
    public $badgeType = 'info';

    /**
     * Set the content to be used for the item's badge.
     *
     * @param  \Closure|callable|null|\Laravel\Nova\Badge  $badgeCallback
     * @param  string|null  $type
     * @return \Closure|callable|null|\Laravel\Nova\Badge
     */
    public function withBadge($badgeCallback, $type = 'info')
    {
        $this->badgeType = $type;

        if (is_callable($badgeCallback) || $badgeCallback instanceof Badge) {
            $this->badgeCallback = $badgeCallback;
        }

        if (is_string($badgeCallback)) {
            $this->badgeCallback = function () use ($badgeCallback, $type) {
                return Badge::make($badgeCallback, $type);
            };
        }

        return $this;
    }

    /**
     * Resolve the badge for the item.
     *
     * @return \Laravel\Nova\Badge
     */
    public function resolveBadge()
    {
        if (is_callable($this->badgeCallback)) {
            $result = call_user_func($this->badgeCallback);

            if (is_null($result)) {
                throw new \Exception('A menu item badge must always have a value.');
            }

            if (! $result instanceof Badge) {
                return Badge::make($result, $this->badgeType);
            }

            return $result;
        }

        return $this->badgeCallback;
    }
}
