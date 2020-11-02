<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
           if($attribute == 'contact') {
             $this->orWhereRaw("CONCAT(provider, contact) LIKE ?", ['%'.$searchTerm.'%']);
           } elseif ($attribute == 'id') {
             $this->orWhereRaw("CONCAT('p', id) LIKE ?", [$searchTerm]);
           }
           else {
            $this->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
          }
         }

         return $this;
      });

      Blade::directive('money', function ($amount) {
          return "<?php echo 'RM ' . number_format($amount, 2); ?>";
      });

      Schema::defaultStringLength(191);

    }
}
