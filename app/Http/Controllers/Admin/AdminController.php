<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MaterielController;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Reservation_materiel;
use App\Models\reservation;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{






      // supprime réservation spécial



    public function destroyR($id)
    {



        $reserv_materiel=Reservation_materiel::where('code_reservation',$id)->get();


       foreach($reserv_materiel as $item) {
           $item->delete();
       }

        $reservation =reservation::find($id);
     $save=   $reservation->delete();


      if($save) {return redirect()->back()
        ->with('success','La réservation a été supprimèe avec succès');
    }else {
        return redirect()->back()
        ->with('fail',"Il ya un problème, il n'est pas supprimé") ;
    }



  }



     // accepte réservation spécial

  public function accepte(Request $request) {

    $this->validate($request,[
        'start_end' =>  'required|exists:creneaus,id',
        'code_salle' =>'required|string|exists:salles,code_salle',
        'date_reservation' =>  'required|date|after:yesterday',

    ]);

    $reservation = new Reservation();
    $reservation ->matricule =  Auth::id();
    $reservation  ->code_salle =  $request->code_salle;
    $reservation ->code_creneau = $request->start_end;
    $reservation ->date_reservation =$request->date_reservation;
    $save = $reservation->save();
    if( $save ){
        return redirect()->back()->with('success','Réservation a été acceptée avec succès');
    }else{
        return redirect()->back()->with('fail',"Il y a un problème, l'opération ne s'est pas terminée avec succès");
    }

  }








   //vérifiez que les information de connexion sont correctes pour la connexion

  function check(Request $request){
    //Validate Inputs
    $request->validate([
       'email'=>'required|email|exists:admins,email',
       'password'=>'required|min:10|max:30'
    ],[
        'email.exists'=>'This email is not exists in admins table'
    ]);

    $creds = $request->only('email','password');



    if( Auth::guard('admin')->attempt($creds) ){
        return redirect()->route('admin.specials');
    }else{
        return redirect()->route('admin.login')->with('fail','Incorrect credentials');
    }
}

         //déconnecter
function logout(){
   Auth::guard('admin')->logout();





   return redirect('/');
}
}