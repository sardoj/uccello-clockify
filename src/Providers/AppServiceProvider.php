<?php

namespace Sardoj\Clockify\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * App Service Provider
 */
class AppServiceProvider extends ServiceProvider
{
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  public function boot()
  {
    // Views
    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'clockify');

    // Translations
    $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'clockify');

    // Migrations
    $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

    // Routes
    $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

    // Publish assets
    $this->publishes([
      __DIR__ . '/../../public' => public_path('vendor/sardoj/clockify'),
    ], 'clockify-assets');

  }

  public function register()
  {

  }
}