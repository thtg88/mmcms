<?php

namespace Thtg88\MmCms\Concerns;

use Illuminate\Foundation\Events\DiscoverEvents;
use Illuminate\Support\Facades\Event;
use Thtg88\MmCms\Events\ContentFieldDestroyed;
use Thtg88\MmCms\Events\ContentFieldStored;
use Thtg88\MmCms\Events\ContentModelStored;
use Thtg88\MmCms\Listeners\DatabaseMigrate;
use Thtg88\MmCms\Listeners\MakeContentFieldDropColumnMigration;
use Thtg88\MmCms\Listeners\MakeContentFieldMigration;
use Thtg88\MmCms\Listeners\MakeContentModelController;
use Thtg88\MmCms\Listeners\MakeContentModelDestroyRequest;
use Thtg88\MmCms\Listeners\MakeContentModelMigration;
use Thtg88\MmCms\Listeners\MakeContentModelModel;
use Thtg88\MmCms\Listeners\MakeContentModelRepository;
use Thtg88\MmCms\Listeners\MakeContentModelStoreRequest;
use Thtg88\MmCms\Listeners\MakeContentModelUpdateRequest;

trait WithProvidedEvents
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ContentModelStored::class => [
            MakeContentModelMigration::class,
            MakeContentModelModel::class,
            MakeContentModelRepository::class,
            MakeContentModelDestroyRequest::class,
            MakeContentModelStoreRequest::class,
            MakeContentModelUpdateRequest::class,
            MakeContentModelController::class,
            // TODO: add API resource
            DatabaseMigrate::class,
        ],
        ContentFieldDestroyed::class => [
            MakeContentFieldDropColumnMigration::class,
            DatabaseMigrate::class,
        ],
        ContentFieldStored::class => [
            MakeContentFieldMigration::class,
            DatabaseMigrate::class,
        ],
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function bootEvents(): void
    {
        $events = $this->getEvents();

        foreach ($events as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens(): array
    {
        return $this->listen;
    }

    /**
     * Get the discovered events and listeners for the application.
     *
     * @return array
     */
    public function getEvents(): array
    {
        if ($this->app->eventsAreCached()) {
            $cache = require $this->app->getCachedEventsPath();

            return $cache[get_class($this)] ?? [];
        }

        return array_merge_recursive(
            $this->discoveredEvents(),
            $this->listens()
        );
    }

    /**
     * Get the discovered events for the application.
     *
     * @return array
     */
    protected function discoveredEvents(): array
    {
        return $this->shouldDiscoverEvents()
            ? $this->discoverEvents()
            : [];
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * Discover the events and listeners for the application.
     *
     * @return array
     */
    public function discoverEvents(): array
    {
        return collect($this->discoverEventsWithin())
            ->reject(function ($directory) {
                return !is_dir($directory);
            })
            ->reduce(function ($discovered, $directory) {
                return array_merge_recursive(
                    $discovered,
                    DiscoverEvents::within($directory, base_path())
                );
            }, []);
    }

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin(): array
    {
        return [
            $this->app->path('Listeners'),
        ];
    }
}
