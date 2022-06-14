<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\enseignant\enseignantController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Personne_admin\Personne_adminController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\TypeSalleController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\StatuController;
use App\Http\Controllers\CreneauController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationMaterielController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});





// Auth::routes();
Auth::routes([
    'register' => false,
    'request' => false,
    'reset' => false,
    'email' => false,
    'confirm' => false,
    'update'=>false,
    'notice'=>false,
    'resend'=>false,
    'verify' => false,
    'login'=>false,

]);


// les enseignant
Route::prefix('enseignant')->name('enseignant.')->group(function(){

    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.enseignant.login')->name('login');

          Route::post('/check',[enseignantController::class,'check'])->name('check');
          Route::get('/password/forgot',[enseignantController::class,'showForgotForm'])->name('forgot.password.form');
          Route::post('/password/forgot',[enseignantController::class,'sendResetLink'])->name('forgot.password.link');
          Route::get('/password/reset/{token}',[enseignantController::class,'showResetForm'])->name('reset.password.form');
          Route::post('/password/reset',[enseignantController::class,'resetPassword'])->name('reset.password');



    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
      ;
          Route::post('/logout',[enseignantController::class,'logout'])->name('logout');
        ;


          // Reservation salle

          Route::match(['get', 'post'],'/reservations',[ReservationController::class,'index'])->name('reservations');
          Route::match(['get', 'post'],'/reservation/create',[ReservationController::class,'create'])->name('reservation.create');
          Route::post('/reservation/store',[ReservationController::class,'store'])->name('reservation.store');
          Route::get('/reservation/show',[ReservationController::class,'show'])->name('reservation.show');
          Route::match(['get', 'post'],'/reservation/edit/{id}',[ReservationController::class,'edit'])->name('reservation.edit');
          Route::post('/reservation/update/{id}',[ReservationController::class,'update'])->name('reservation.update');
          Route::get('/reservation/destroy/{id}',[ReservationController::class,'destroy'])->name('reservation.destroy');


         //reservation materiel

          Route::match(['get', 'post'],'/reservationM/create',[ReservationMaterielController::class,'create'])->name('reservationM.create');
          Route::post('/reservationM/store',[ReservationMaterielController::class,'store'])->name('reservationM.store');
          Route::match(['get', 'post'],'/reservationM/edit/{id}',[ReservationMaterielController::class,'edit'])->name('reservationM.edit');
          Route::post('/reservationM/update/{id}',[ReservationMaterielController::class,'update'])->name('reservationM.update');
          Route::get('/reservationM/destroy/{id}',[ReservationMaterielController::class,'destroy'])->name('reservationM.destroy');

           //consultation et filtre tout les réservation

          Route::match(['get', 'post'], '/consultationReservation', [ReservationController::class,'allreservations'])->name('consultationReservation');
          Route::post('/allreservations',[ReservationController::class,'filter'])->name('reservation.filter');





          // profil enseignant

          Route::get('/passedit/{id}',[enseignantController::class,'passedit'])->name('enseignant.passedit');

          // mise a jour mot de passe ou téléphone
          Route::put('/passupdate/{id}',[enseignantController::class,'passupdate'])->name('enseignant.passupdate');




    });

});
       // admin
Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.admin.login')->name('login');
          Route::post('/check',[AdminController::class,'check'])->name('check');
    });


    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');




        //supprimer reservation salle normal

        Route::get('/reservation/destroy/{id}',[AdminController::class,'destroyR'])->name('reservation.destroy');


        // accepte et supprimer réservation spécial


        Route::match(['get', 'post'],'/reservationSpecial',[ReservationController::class,'reservationSpecial'])->name('specials');
        Route::match(['get', 'post'],'special/accepte/{id}',[ReservationController::class,'accepte'])->name('special.accepte');



       //Admin consulter reservation
        Route::match(['get', 'post'], '/consultationReservation', [ReservationController::class,'consultationReservationA'])->name('consultationReservation');


               //gestion enseignant


        Route::match(['get', 'post'],'/enseignants',[enseignantController::class,'index'])->name('enseignants');
        Route::get('/enseignant/create',[enseignantController::class,'create'])->name('enseignant.create');
        Route::post('/enseignant/store',[enseignantController::class,'store'])->name('enseignant.store');
        Route::get('/enseignant/show',[enseignantController::class,'show'])->name('enseignant.show');
        Route::get('/enseignant/edit/{matricule}',[enseignantController::class,'edit'])->name('enseignant.edit');
        Route::put('/enseignant/update/{matricule}',[enseignantController::class,'update'])->name('enseignant.update');
        Route::get('/enseignant/destroy/{matricule}',[enseignantController::class,'destroy'])->name('enseignant.destroy');



          //  gestion materiel

        Route::match(['get', 'post'],'materiels',[MaterielController::class,'index'])->name('materiels');
        Route::get('/materiel/create',[MaterielController::class,'create'])->name('materiel.create');
        Route::post('/materiel/store',[MaterielController::class,'store'])->name('materiel.store');
        Route::get('/materiel/show',[MaterielController::class,'show'])->name('materiel.show');
        Route::get('/materiel/edit/{id}',[MaterielController::class,'edit'])->name('materiel.edit');
        Route::put('/materiel/update/{id}',[MaterielController::class,'update'])->name('materiel.update');
        Route::get('/materiel/destroy/{id}',[MaterielController::class,'destroy'])->name('materiel.destroy');

        // gestion Person Admin
        Route::match(['get', 'post'],'/Personne_admins',[Personne_adminController::class,'index'])->name('Personne_admins');
        Route::get('/Personne_admin/create',[Personne_adminController::class,'create'])->name('Personne_admin.create');
        Route::post('/Personne_admin/store',[Personne_adminController::class,'store'])->name('Personne_admin.store');
        Route::get('/Personne_admin/show',[Personne_adminController::class,'show'])->name('Personne_admin.show');
        Route::get('/Personne_admin/edit/{id}',[Personne_adminController::class,'edit'])->name('Personne_admin.edit');
        Route::put('/Personne_admin/update/{id}',[Personne_adminController::class,'update'])->name('Personne_admin.update');
        Route::get('/Personne_admin/destroy/{id}',[Personne_adminController::class,'destroy'])->name('Personne_admin.destroy');


        // gestion Salle

        Route::match(['get', 'post'],'/salles',[SalleController::class,'index'])->name('salles');
        Route::get('/salle/create',[SalleController::class,'create'])->name('salle.create');
        Route::post('/salle/store',[SalleController::class,'store'])->name('salle.store');
      ;
        Route::get('/salle/destroy/{id}',[SalleController::class,'destroy'])->name('salle.destroy');

        // gestion Type Salle


        Route::get('/type_salle/create',[TypeSalleController::class,'create'])->name('type_salle.create');
        Route::post('/type_salle/store',[TypeSalleController::class,'store'])->name('type_salle.store');

        Route::get('/type_salle/edit/{id}',[TypeSalleController::class,'edit'])->name('type_salle.edit');
        Route::put('/type_salle/update/{id}',[TypeSalleController::class,'update'])->name('type_salle.update');
        Route::get('/type_salle/destroy/{id}',[TypeSalleController::class,'destroy'])->name('type_salle.destroy');

        // gestion Departement


        Route::get('/departements',[DepartementController::class,'index'])->name('departements');
        Route::get('/departement/create',[DepartementController::class,'create'])->name('departement.create');
        Route::post('/departement/store',[DepartementController::class,'store'])->name('departement.store');

        Route::get('/departement/edit/{id}',[DepartementController::class,'edit'])->name('departement.edit');
        Route::put('/departement/update/{id}',[DepartementController::class,'update'])->name('departement.update');
        Route::get('/departement/destroy/{id}',[DepartementController::class,'destroy'])->name('departement.destroy');

        // gestion status



        Route::get('/status',[StatuController::class,'index'])->name('status');
        Route::get('/status/create',[StatuController::class,'create'])->name('status.create');
        Route::post('/status/store',[StatuController::class,'store'])->name('status.store');

        Route::get('/status/edit{id}',[StatuController::class,'edit'])->name('status.edit');
        Route::post('/status/store{id}',[StatuController::class,'update'])->name('status.update');
        Route::get('/status/destroy/{id}',[StatuController::class,'destroy'])->name('status.destroy');


        // gestion Creneau

        Route::get('/creneaus',[CreneauController::class,'index'])->name('creneaus');
        Route::get('/creneau/create',[CreneauController::class,'create'])->name('creneau.create');
        Route::post('/creneau/store',[CreneauController::class,'store'])->name('creneau.store');

        Route::get('/creneau/edit/{id}',[CreneauController::class,'edit'])->name('creneau.edit');
        Route::put('/creneau/update/{id}',[CreneauController::class,'update'])->name('creneau.update');
        Route::get('/creneau/destroy/{id}',[CreneauController::class,'destroy'])->name('creneau.destroy');





    });

});

//Personne_admin
Route::prefix('Personne_admin')->name('Personne_admin.')->group(function(){

       Route::middleware(['guest:Personne_admin','PreventBackHistory'])->group(function(){
            Route::view('/login','dashboard.Personne_admin.login')->name('login');
            Route::post('/check',[Personne_adminController::class,'check'])->name('check');
            Route::get('/password/forgot',[Personne_adminController::class,'showForgotForm'])->name('forgot.password.form');
            Route::post('/password/forgot',[Personne_adminController::class,'sendResetLink'])->name('forgot.password.link');
            Route::get('/password/reset/{token}',[Personne_adminController::class,'showResetForm'])->name('reset.password.form');
            Route::post('/password/reset',[Personne_adminController::class,'resetPassword'])->name('reset.password');
       });

       Route::middleware(['auth:Personne_admin','PreventBackHistory'])->group(function(){

            Route::post('logout',[Personne_adminController::class,'logout'])->name('logout');

               //Personne_admin consulter reservation

        Route::match(['get', 'post'], '/consultationReservation', [ReservationController::class,'consultationReservationV'])->name('consultationReservation');


              //profil Personne_admin

          Route::get('/passedit/{id}',[Personne_adminController::class,'passedit'])->name('Personne_admin.passedit');

               //mise a jour mot de passe ou téléphone
          Route::put('/passupdate/{id}',[Personne_adminController::class,'passupdate'])->name('Personne_admin.passupdate');
       });



});