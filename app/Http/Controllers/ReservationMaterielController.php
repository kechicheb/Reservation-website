<?php

namespace App\Http\Controllers;

use App\Models\Reservation_materiel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\reservation;
use App\Models\materiel;
use App\Models\Salle;
use App\Models\enseignant;
use App\Models\creneau;
use Carbon\Carbon;
use Auth;

class ReservationMaterielController extends Controller
{

// filtre matériel pas réservée
    public function create(Request $request)

    {

      $creneaus=Creneau::get();

      if(($request->start_end)&&(!$request->date_reservation)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $materiels=[];
        $id_reservation=[];
      }
      if((!$request->start_end)&&($request->date_reservation)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $materiels=[];
        $id_reservation=[];
      }


    if(($request->start_end)&&($request->date_reservation)){
        $nn= Reservation::where('matricule',auth()->id())
        ->where('date_reservation',$request->date_reservation)
        ->whereIn('code_creneau', $request->start_end)->get();

        if($nn->count()>0){
            $reserv= reservation::select('id')->where('date_reservation',$request->date_reservation)
            ->whereIn('code_creneau', $request->start_end)->get();

            $reserv_materiel =Reservation_materiel::select('code_materiel')->whereIn('code_reservation',$reserv);


            $materiels=materiel::whereNotIn('id',$reserv_materiel)->paginate(30);
            $id_reservation=[];
            $id_reservation =$nn;
      if($materiels->count()==0){
      return redirect()->back()->with('pasmateriels',"Il n'y a pas de matériel disponible dans cette date et créneau.");

}


        }else{
            $id_reservation=[];

            return redirect()->back()->with('vide',"Vous ne disposez pas d'une réservation à l'heure et le jour où vous avez entré");
        }

    }
    if((!$request->start_end)&&(!$request->date_reservation)){

        $materiels=[];
        $id_reservation=[];
    }
     return view('reservationMateriels.create')
     ->with('materiels',$materiels)
     ->with('creneaus',$creneaus)
     ->with('id_reservation',$id_reservation);

    }


    // ajouter  reservation materiel
    public function store(Request $request)
    {



        $this->validate($request,[

            'id_reservation' => 'required|exists:reservations,id',
            'checkbox' =>'required|exists:materiels,id',


        ]);

        foreach($request->id_reservation as $item){
            foreach($request->checkbox as $itemm){
                $res = new Reservation_materiel();
                $res-> code_reservation =  $item;
                $res->code_materiel =  $itemm;

        $save=$res->save();







    }
    }
    if( $save ){
        return redirect()->back()->with('success','Le Méteriel a été réservé avec succès');
    }else{
        return redirect()->back()->with('fails',"Echec de l'ajout");
    }


}



// afficher page mise a jour reservation materiel

    public function edit($id)
    {


       $id_reservation_materiel= $id;
        $date_creneau = Reservation_materiel::join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')
        ->where('Reservation_materiels.id',$id)
         ->get(['reservations.date_reservation','reservations.code_creneau']);
foreach($date_creneau as $item) {

    $reserv= reservation::select('id')->where('date_reservation',$item->date_reservation)
    ->where('code_creneau', $item ->code_creneau)->get();
}


         $reserv_materie =Reservation_materiel::select('code_materiel')->whereIn('code_reservation',$reserv);
         $reserv_materiel=materiel::whereNotIn('id',$reserv_materie)->paginate(30);
         return view('reservationMateriels.edit')
        ->with('reserv_materiel',$reserv_materiel)
       ->with('id_reservation_materiel',$id_reservation_materiel);

    }



    // mise a jour reservation  materiel


    public function update(Request $request,$id)
    {
        $Reservation_materiel =Reservation_materiel::find($id);
         $this->validate($request,[
            'id_materiel' =>'required|exists:materiels,id',
        ]);



        $Reservation_materiel ->code_materiel= $request->id_materiel;
       $save= $Reservation_materiel->update();
       if( $save ){
        return redirect()->back()->with('success','La réservation de matériel  mise à jour ');
    }else{
        return redirect()->back()->with('fails',"Mis à jour a échoué");
    }

    }

    // supprimer reservation materiel


    public function destroy($id)
    {


        $reservation_materiel=Reservation_materiel::find($id);

    $save=    $reservation_materiel->delete();
    if($save ) {
        return redirect()->route('enseignant.reservations')
       ->with('delete','Votre réservation de matériel  a été supprimée avec succès ') ;

   }else {
    return redirect()->route('enseignant.reservations')
    ->with('Pasdelete','reservation matériel pas supprimer ') ;
   }

    }
}
