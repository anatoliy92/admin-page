<?php

namespace Avl\AdminPage;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Config;

class AdminPageServiceProvider extends ServiceProvider
{

		/**
		 * Bootstrap the application services.
		 *
		 * @return void
		 */
		public function boot()
		{
			// dd('pages');
				// Публикуем файл конфигурации
				$this->publishes([
						__DIR__ . '/../config/adminpage.php' => config_path('adminpage.php'),
				]);

				$this->publishes([
						__DIR__ . '/../public' => public_path('vendor/adminpage'),
				], 'public');

				$this->loadRoutesFrom(__DIR__ . '/routes.php');

				$this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminpage');
		}

		/**
		 * Register the application services.
		 *
		 * @return void
		 */
		public function register()
		{
				// Добавляем в глобальные настройки системы новый тип раздела
				Config::set('avl.sections.page', 'Страничный раздел');

				// объединение настроек с опубликованной версией
				$this->mergeConfigFrom(__DIR__ . '/../config/adminpage.php', 'adminpage');

				// migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

		}

}
