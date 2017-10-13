<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use \App\Achievement;
use Auth;
use \App\Person;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        // View::composer(
        //     'profile', 'App\Http\ViewComposers\ProfileComposer'
        // );

        // Using Closure based composers...
        View::composer('public.include.last_achievement', function ($view) {
            $achievements = Achievement::with('student','stage','student.institution')->orderBy('id','asc')->take(20)->get();
            $view->with('achievements', $achievements);
        });


        View::composer('admin.include.statistic', function ($view) {
            $ui = Auth::user()->institution->pluck('id');

            $teachers = Person::with(['mainInstitution'=>function($q) use($ui){
                $q->where('institutions.id','=',9);
            }])->get();

            $view->with('teachers', $teachers);
        });


    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}