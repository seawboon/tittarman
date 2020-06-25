<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Builder::macro('whereLike', function($attributes, string $searchTerm) {
         foreach(array_wrap($attributes) as $attribute) {
            $this->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
         }

         return $this;
      });

      Blade::directive('money', function ($amount) {
          return "<?php echo 'RM ' . number_format($amount, 2); ?>";
      });

    }
}
