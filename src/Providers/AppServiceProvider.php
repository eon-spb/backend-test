<?php

declare(strict_types=1);

namespace EON\Providers;

use EON\Models\Apartments;
use EON\XML\Contracts\XMLParserContract;
use EON\XML\Repositories\ApartmentsRepository;
use EON\XML\Services\XMLParserNative;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->singleton(ApartmentsRepository::class, fn ($app) => new ApartmentsRepository(new Apartments()));
        $this->app->bind(XMLParserContract::class, XMLParserNative::class);
    }
}
