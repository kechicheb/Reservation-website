<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


// use Illuminate\Support\Facades\Auth;
use App\Models\reservation;
use App\Models\Reservation_materiel;
use App\Models\Salle;
use App\Models\enseignant;
use App\Models\creneau;
use App\Models\Attente;
use Carbon\Carbon;
use Auth;



class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

// consultation tout réservation dans l'enseignant

    public function allreservations(Request $request) {



        $creneaus=Creneau::all();


       //one start_end
       if(($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)){



           $reservations = Reservation::whereIn(
               'code_creneau',$request->start_end

           )->paginate(10);



      }
          // code_salle seulement
      if(($request->code_salle)&&(!$request->date_reservation)&&(!$request->start_end)){
       $reservations = Reservation::where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);

      }
      // date seulement
      if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);
       $reservations = Reservation::where(
           'date_reservation',$request->date_reservation

       )->paginate(10);


      }
              // créneau et date et code salle


      if(($request->date_reservation)&&($request->start_end)&&($request->code_salle)){
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);

       $reservations = Reservation::whereIn('code_creneau',$request->start_end)
       ->where('date_reservation', $request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);


      }

             //  date et créneau

      if(($request->date_reservation)&&($request->start_end)&&(!$request->code_salle)){
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);

       $reservations = Reservation::whereIn('code_creneau',$request->start_end)
       ->where('date_reservation', $request->date_reservation)->paginate(10);

      }

              // date et code salle
      if(($request->date_reservation)&&($request->code_salle)&&(!$request->start_end)){
          $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);


              $b= $request->date_reservation;
              $a= $request->code_salle;

       $reservations = Reservation::where(function ($request) use ($a) {
           $request->where('code_salle', 'LIKE', "%".$a."%");
       })->where(function ($request) use ($b) {
           $request->where('date_reservation', '=', $b);

       })->paginate(10);



      }
        // créneau et code salle

      if(($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)){

       $reservations = Reservation::whereIn('code_creneau',$request->start_end)
       ->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
      }

      // date et nom enseignant

      if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);
       $matricule=[];
      $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

      $reservations = Reservation::whereIn('matricule',$matricule)->where('date_reservation',$request->date_reservation)->paginate(10);
    }

        // nom d'enseignant
      if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
           $matricule=[];
          $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

          $reservations = Reservation::whereIn('matricule',$matricule)->paginate(10);
      }


          // nom d'enseignant et code salle
      if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
    }



    // nom d'enseignant et code salle et date
    if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('date_reservation',$request->date_reservation)->paginate(10);
    }



    // nom d'enseignant et créneau

    if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->paginate(10);
    }


    // nom d'enseignant et créneau et code salle
    if(($request->name)&&($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
    }

// nom d'enseignant et créneau et date
    if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->paginate(10);
    }

// nom d'enseignant et date et code salle et créneau

    if(($request->name)&&($request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
        $this->validate($request,[

            'date_reservation' =>  'date|after:yesterday',

        ]);
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
    }


// rien

      if((!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)&&(!$request->name)){
            $reservations = Reservation::paginate(10);

        }

        // filtre par bouton tout les réservations
if($request->all_reservation) {
    $reservations = Reservation::paginate(10);

}


       return view('reservations.allreservations')
       ->with('reservations',$reservations)
       ->with('creneaus',$creneaus);




    }


    // afficher page mes réservation et filtre
    public function index(Request $request )
    {
        $test_reservations=reservation::where('matricule', auth()->id())->get();
        // test si il a une réservation
        if( $test_reservations->count()>0) {
// obtenir réservation materiel
        $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
        ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')
        ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
         ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');

        }else{
            $reservations=reservation::where('matricule', auth()->id())->paginate(10);
            $materiels_reserve = new Reservation_materiel;

        }
        $creneaus=Creneau::all();

            // créneau

         if(($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)){

          $reservations = Reservation::whereIn(
               'code_creneau',$request->start_end

           )->where('matricule', auth()->id())->paginate(10);

              $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
        ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')
        ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())->whereIn(
            'creneaus.id',$request->start_end

        )
         ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');




      }

      // code_salle

      if(($request->code_salle)&&(!$request->date_reservation)&&(!$request->start_end)){
       $reservations = Reservation::where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('matricule', auth()->id())->paginate(10);

       $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
       ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')->where(
        'reservations.code_salle', 'LIKE', "%".$request->code_salle."%"

    )
       ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
        ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');






      }


      // date

      if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
       $reservations = Reservation::where(
           'date_reservation',$request->date_reservation

       )->where('matricule', auth()->id())->paginate(10);
       $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
       ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')->where(
        'reservations.date_reservation',$request->date_reservation


    )
       ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
        ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');









      }

       // date et créneau et code salle


      if(($request->date_reservation)&&($request->start_end)&&($request->code_salle)){

       $reservations = Reservation::whereIn('code_creneau',$request->start_end)
       ->where('date_reservation', $request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('matricule', auth()->id())->paginate(10);

       $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
       ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')->where(
        'reservations.date_reservation',$request->date_reservation


    )->whereIn('reservations.code_creneau',$request->start_end)->where('reservations.code_salle', 'LIKE', "%".$request->code_salle."%")
       ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
        ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');



      }
          // date et créneau
      if(($request->date_reservation)&&($request->start_end)&&(!$request->code_salle)){

       $reservations = Reservation::whereIn('code_creneau',$request->start_end)
       ->where('date_reservation', $request->date_reservation)->where('matricule', auth()->id())->paginate(10);

       $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
       ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')->where(
        'reservations.date_reservation',$request->date_reservation


    )->whereIn('reservations.code_creneau',$request->start_end)
       ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
        ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');




      }


      // date et code salle
      if(($request->date_reservation)&&($request->code_salle)&&(!$request->start_end)){


              $b= $request->date_reservation;
              $a= $request->code_salle;

       $reservations = Reservation::where(function ($request) use ($a) {
           $request->where('code_salle', 'LIKE', "%".$a."%");
       })->where(function ($request) use ($b) {
           $request->where('date_reservation', '=', $b);

       })->where('matricule', auth()->id())->paginate(10);


       $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
       ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')->where(
        'reservations.date_reservation',$request->date_reservation


    )->where('reservations.code_salle', 'LIKE', "%".$request->code_salle."%")
       ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
        ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');





      }

          // créneau et code salle

      if(($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)){

       $reservations = Reservation::whereIn('code_creneau',$request->start_end)
       ->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('matricule', auth()->id())->paginate(10);

       $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
       ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')->whereIn('reservations.code_creneau',$request->start_end)->where('reservations.code_salle', 'LIKE', "%".$request->code_salle."%")
       ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
        ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');


      }
            // rien

        if((!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)){
            $reservations = Reservation::where('matricule', auth()->id())->latest()->paginate(10);
            $test_reservations=reservation::where('matricule', auth()->id())->get();

              // test si il a une réservation material

            if( $test_reservations->count()>0) {

                $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
                ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')
                ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
                 ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');

                }
                else{
                    $reservations=reservation::where('matricule', auth()->id())->paginate(10);
                    $materiels_reserve = new Reservation_materiel;

                }


        }





              //  bouton tout, obtenir tout les réservation
        if($request->all_reservation) {
            $reservations=reservation::where('matricule', auth()->id())->paginate(10);
            $materiels_reserve = Reservation_materiel::join('materiels', 'reservation_materiels.code_materiel', '=', 'materiels.id')
            ->join('reservations', 'reservation_materiels.code_reservation', '=', 'reservations.id')
            ->join('creneaus','reservations.code_creneau','=','creneaus.id')->where('reservations.matricule',auth()->id())
             ->paginate(10,['reservation_materiels.id', 'materiels.nom','reservations.code_salle','reservations.date_reservation','creneaus.start','creneaus.end'],'page_materiel');

        }






        return view('reservations.index')
        ->with('reservations',$reservations)
        ->with('creneaus',$creneaus)
        ->with('materiels_reserve',$materiels_reserve);

    }

    // afficher page réservation salle

    public function create(Request $request)  {
        $salles= Salle::all();
        $creneaus=Creneau::all();





       // date et code salle
      if(($request->date_reservation)&&(!$request->start_end)&&($request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];



       }


       // date et code salle
       if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];



       }

// créneau

       if(($request->start_end)&&(!$request->date_reservation)&&(!$request->code_salle)){



        $rooms=[];
        $date="";
        $start_end=[];

    }


    // code salle
    if((!$request->start_end)&&(!$request->date_reservation)&&($request->code_salle)){

        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];

    }





// créneau et date et code salle

    if(($request->start_end)&&($request->date_reservation)&&($request->code_salle)){

                 $d=Carbon::today();
                 $h=Carbon::now()->format('H:i:s');
                 $start_end=Creneau::select('id','start','end')->whereIn('id',$request->start_end)->get();
                 $this->validate($request,[
                'start_end' =>  'required',
                'date_reservation' =>  'required|date|after:yesterday',

            ]);




        if(($request->date_reservation)<=$d){

            foreach($start_end as $item){
                if(($item->start)<=$h){

              return redirect()->back()->with('time_start',"L'heure à laquelle vous souhaitez réserver avant l'heure actuelle");



            }






          }
        }


        $reservations=[];

        $date=$request->date_reservation;
        $nn=[];

     $nn= Reservation::where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->whereIn('code_creneau', $request->start_end)->get();



     if($nn->count()>0)
     {


      $k=[];
     $k= Reservation::select('code_creneau')->where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->whereIn('code_creneau', $request->start_end)->get();


        $crene=[];

     $crene=Creneau::select('id','start','end')->whereIn('id',$k)->get();

                   $n="";
             foreach($crene as $item) {
                 $g=$item->start ." - ". $item->end;
                 $n=$n ."  ". $g;
             }

            return redirect()->back()->with('error','Vous avez déjà une réservation dans ce créneau'.$n ." et à cette date : ".$date);

        $rooms="";

     }else{

    $reservations = Reservation::select('code_salle')->where('date_reservation',$request->date_reservation)->whereIn('code_creneau', $request->start_end)->get();
    $test_ecxist =Salle::where('code_salle', 'LIKE', "%".$request->code_salle."%")->get();
    if(  $test_ecxist->count()>0){
     $rooms = Salle::whereNotIn('code_salle',$reservations)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(30);
    if($rooms->count()==0){
        return redirect()->back()->with('pasReservation',"La salle n'est pas libre.");
    }}
    else{
        return redirect()->back()->with('pasSalle',"La salle n'existe pas.");
    }

     }




    }
    if(($request->start_end)&&($request->date_reservation)&&(!$request->code_salle)){
        $d=Carbon::today();
                 $h=Carbon::now()->format('H:i:s');
                 $start_end=Creneau::select('id','start','end')->whereIn('id',$request->start_end)->get();
                 $this->validate($request,[
                'start_end' =>  'required',
                'date_reservation' =>  'required|date|after:yesterday',

            ]);

        if(($request->date_reservation)<=$d){

            foreach($start_end as $item){
                if(($item->start)<=$h){

              return redirect()->back()->with('time_start',"L'heure à laquelle vous souhaitez réserver avant l'heure actuelle");



            }






          }
        }

        $reservations=[];


     $date=$request->date_reservation;
     $nn=[];

     $nn= Reservation::where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->whereIn('code_creneau', $request->start_end)->get();


     if($nn->count()>0)
     {


      $k=[];
     $k= Reservation::select('code_creneau')->where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->whereIn('code_creneau', $request->start_end)->get();


        $crene=[];

     $crene=Creneau::select('id','start','end')->whereIn('id',$k)->get();

                   $n="";
             foreach($crene as $item) {
                 $g=$item->start ." - ". $item->end;
                 $n=$n ."  ". $g;
             }

            return redirect()->back()->with('error','Vous avez déjà une réservation dans ce créneau'.$n ." et à cette date : ".$date);

        $rooms="";

     }else{
        $reservations = Reservation::select('code_salle')->where('date_reservation',$request->date_reservation)->whereIn('code_creneau', $request->start_end)->get();
              $count=  $reservations->count();

        $rooms = Salle::whereNotIn('code_salle',$reservations)->paginate(30);
        if($rooms->count()==0){
            return redirect()->back()->with('pasReservation',"Il n'y a pas des salles en ce creneaux et date ");
        }




     }



        $date=$request->date_reservation;

    }
    if((!$request->start_end)&&(!$request->date_reservation)&&(!$request->code_salle)){


        $rooms=[];
        $date="";
        $start_end=new creneau();
     }
     $data=[];



        return view('reservations.create')
        ->with('rooms',$rooms)
        ->with('start_end',$start_end)
        ->with('date',$date)
        ->with('salles',$salles)
        ->with('data',$data)
        ->with('creneaus',$creneaus);

    }



    // ajouter réservation salle

    public function store(Request $request)
    {



        $this->validate($request,[
            'start_end' =>  'required|exists:creneaus,id',
            'code_salle' =>'required|string|exists:salles,code_salle',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);


   $d=  $request->start_end;
   $special= Salle::where('code_salle',$request->code_salle)->get();

foreach($special as $itemm) {
    // si salle normal
if($itemm->special != "spécial") {
    foreach($d as $item){

        $reservation = new Reservation();
        $reservation ->matricule =  Auth::id();
        $reservation  ->code_salle =  $request->code_salle;
        $reservation ->code_creneau =  $item;
        $reservation ->date_reservation =$request->date_reservation;
        $reservation ->attente ="non";
        $save = $reservation->save();

    }

}else {
    // si salle special
    foreach($d as $item){


        $reservation = new Reservation();
        $reservation ->matricule =  Auth::id();
        $reservation  ->code_salle =  $request->code_salle;
        $reservation ->code_creneau =  $item;
        $reservation ->date_reservation =$request->date_reservation;
        $reservation ->attente ="oui";
        $save = $reservation->save();

    }

}
}



        if( $save ){
            return redirect()->back()->with('success','Votre réservation a été effectuée avec succès.');
        }else{
            return redirect()->back()->with('fail',"Il y a un problème, la réservation n'a pas été effectuée.");
        }





    }



     // afficher page mise a jour réservation et filtre

    public function edit(Request $request,$id)

    {
        $fff=$id;

        $salles= Salle::all();
        $creneaus=Creneau::all();

        $reservation=Reservation::find($id);






       //
      if(($request->date_reservation)&&(!$request->start_end)&&($request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];



       }
       if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];



       }
       if(($request->start_end)&&(!$request->date_reservation)&&(!$request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];

    }
    if((!$request->start_end)&&(!$request->date_reservation)&&($request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $rooms=[];
        $date="";
        $start_end=[];

    }







    if(($request->start_end)&&($request->date_reservation)&&($request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);
        $reservations=[];
     $start_end=Creneau::select('id','start','end')->where('id',$request->start_end)->get();

        $date=$request->date_reservation;
        $nn=[];
        $i=0;
        $nn= Reservation::where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->where('code_creneau', $request->start_end)->get();

     foreach($nn as $item){
        if($item->id != $id) {
           $i=$i+1;
        }

    }

     if($i>0)
     {


      $k=[];
     $k= Reservation::select('code_creneau')->where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->where('code_creneau', $request->start_end)->get();


     $crene=[];
     $crene=Creneau::select('id','start','end')->where('id',$k)->get();


       $n="";
             foreach($crene as $item) {
                 $g=$item->start ." - ". $item->end;
                 $n=$n ."  ". $g;
             }

            return redirect()->back()->with('error','Vous avez déjà une réservation dans ce créneau'.$n ." et à cette date : ".$date);

        $rooms="";

     }else{
    $reservations = Reservation::select('code_salle')->where('date_reservation',$request->date_reservation)->where('code_creneau', $request->start_end)->get();
    $test_ecxist =Salle::where('code_salle', 'LIKE', "%".$request->code_salle."%")->get();
if($test_ecxist->count()>0){
    $rooms = Salle::whereNotIn('code_salle',$reservations)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(30);
    if($rooms->count()==0){
        return redirect()->back()->with('pasReservation',"La salle n'est pas libre.");
    }
}else{
    return redirect()->back()->with('pasSalle',"La salle n'existe pas.");

}

     }




    }
    if(($request->start_end)&&($request->date_reservation)&&(!$request->code_salle)){
        $this->validate($request,[
            'start_end' =>  'required',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);

        $reservations=[];


     $start_end=Creneau::select('id','start','end')->where('id',$request->start_end)->get();
     $date=$request->date_reservation;
     $nn=[];
     $i=0;


        $nn= reservation::where('matricule',auth()->id())
        ->where('code_creneau', $request->start_end)
        ->where('date_reservation',$request->date_reservation)->get();

foreach($nn as $item){
    if($item->id != $id) {
       $i=$i+1;
    }

}

     if($i>0)
     {



      $k=[];
     $k= Reservation::select('code_creneau')->where('matricule',auth()->id())->where('date_reservation',$request->date_reservation)->where('code_creneau', $request->start_end)->get();


      $crene=[];
     $crene=Creneau::select('start','end')->where('id',$request->start_end)->get();

         $n="";
             foreach($crene as $item) {
                 $g=$item->start ." - ". $item->end;
                 $n=$n ."  ". $g;
             }


            return redirect()->back()->with('error','Vous avez déjà une réservation dans ce créneau'.$n ." et à cette date : ".$date);

        $rooms="";

     }else{
        $reservations = Reservation::select('code_salle')->where('date_reservation',$request->date_reservation)->where('code_creneau', $request->start_end)->get();


        $rooms = Salle::whereNotIn('code_salle',$reservations)->paginate(30);
            if($rooms->count()==0){
            return redirect()->back()->with('pasReservation',"Il n'y a pas des salles en ce creneaux et date ");
        }

     }



        $date=$request->date_reservation;

    }
    if((!$request->start_end)&&(!$request->date_reservation)&&(!$request->code_salle)){

        $rooms=[];
        $date="";
        $start_end=new creneau();
     }



     return view('reservations.edit')
        ->with('reservation',$reservation)
        ->with('fff',$fff)
        ->with('rooms',$rooms)
        ->with('start_end',$start_end)
        ->with('date',$date)
        ->with('salles',$salles)
        ->with('creneaus',$creneaus);



    }


      // mise a jour réservation
    public function update(Request $request,$id)

    {
        $reservation =Reservation::find( $id );

        $this->validate($request,[
            'id' =>  "unique:reservations,id,$id",
            'start_end' =>  'required|exists:creneaus,id',
            'code_salle' =>'required|string|exists:salles,code_salle',
            'date_reservation' =>  'required|date|after:yesterday',

        ]);



        $reserv_materiel=Reservation_materiel::where('code_reservation',$id)->get();

// si il a une réservation material ,supperime

        foreach($reserv_materiel as $item) {
            $item->delete();
        }




        $d=  $request->start_end;





     $special= Salle::where('code_salle',$request->code_salle)->get();
     foreach($special as $itemm) {
    if($itemm->special == "normal") {
     foreach($d as $item){

        $reservation  ->code_salle =  $request->code_salle;
        $reservation ->code_creneau=  $item;
        $reservation ->date_reservation =$request->date_reservation;
        $reservation ->attente ="non";
        $save= $reservation->update();
     }
    }else {
        foreach($d as $item){
        $reservation  ->code_salle =  $request->code_salle;
        $reservation ->code_creneau=  $item;
        $reservation ->date_reservation =$request->date_reservation;
        $reservation ->attente ="oui";
        $save= $reservation->update();
    }


     }
    }






      $fff=$id;


        if( $save ){

            return redirect()->back()->with('success','Réservation mise à jour.');
         }else{
             return redirect()->back()->with('fail',"Il y a un problème et la réservation n'a pas été effectuée avec succès");
          }


        }


        // supprimer réservation dans enseignant
    public function destroy($id)
    {



        $reserv_materiel=Reservation_materiel::where('code_reservation',$id)->get();


       foreach($reserv_materiel as $item) {
           $item->delete();
       }

        $reservation =reservation::find($id);
       $save= $reservation->delete();

if($save) {

    return redirect()->route('enseignant.reservations')
    ->with('rerservationS','Cette réservation a été supprimée avec succès ');
}else{

    return redirect()->route('enseignant.reservations')
    ->with('PasrerservationS','Echec de la suppression');
}



  }

// afficher consultaion  reservation dans personne admin
  public function consultationReservationV(Request $request) {



    $creneaus=Creneau::all();


   //one start_end
   if(($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)){



       $reservations = Reservation::whereIn(
           'code_creneau',$request->start_end

       )->paginate(10);


       //one code_salle
  }

  if(($request->code_salle)&&(!$request->date_reservation)&&(!$request->start_end)){
   $reservations = Reservation::where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);

  } //one date
  if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
   $reservations = Reservation::where(
       'date_reservation',$request->date_reservation

   )->paginate(10);

   // three work

  }if(($request->date_reservation)&&($request->start_end)&&($request->code_salle)){
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);

   $reservations = Reservation::whereIn('code_creneau',$request->start_end)
   ->where('date_reservation', $request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);


  }

  if(($request->date_reservation)&&($request->start_end)&&(!$request->code_salle)){
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);

   $reservations = Reservation::whereIn('code_creneau',$request->start_end)
   ->where('date_reservation', $request->date_reservation)->paginate(10);

  }


  if(($request->date_reservation)&&($request->code_salle)&&(!$request->start_end)){
      $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);


          $b= $request->date_reservation;
          $a= $request->code_salle;

   $reservations = Reservation::where(function ($request) use ($a) {
       $request->where('code_salle', 'LIKE', "%".$a."%");
   })->where(function ($request) use ($b) {
       $request->where('date_reservation', '=', $b);

   })->paginate(10);



  }

  if(($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)){

   $reservations = Reservation::whereIn('code_creneau',$request->start_end)
   ->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
  }


  if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
   $matricule=[];
  $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

  $reservations = Reservation::whereIn('matricule',$matricule)->where('date_reservation',$request->date_reservation)->paginate(10);
}


  if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
       $matricule=[];
      $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

      $reservations = Reservation::whereIn('matricule',$matricule)->paginate(10);
  }



  if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
}
if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('date_reservation',$request->date_reservation)->paginate(10);
}

if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->paginate(10);
}
if(($request->name)&&($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
}


if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->paginate(10);
}
if(($request->name)&&($request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->paginate(10);
}
  if((!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)&&(!$request->name)){
        $reservations = Reservation::paginate(10);

    }
if($request->all_reservation){
    $reservations = Reservation::paginate(10);
}
   return view('dashboard.Personne_admin.consultationReservation')
   ->with('reservations',$reservations)
   ->with('creneaus',$creneaus);




}







// afficher consultation tout  Reservation dans admin et filtre


public function consultationReservationA(Request $request) {



    $creneaus=Creneau::all();


   //one start_end
   if(($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)){



       $reservations = Reservation::whereIn(
           'code_creneau',$request->start_end

       )->where('attente','non')->paginate(10);


       //one code_salle
  }

  if(($request->code_salle)&&(!$request->date_reservation)&&(!$request->start_end)){
   $reservations = Reservation::where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','non')->paginate(10);

  } //one date
  if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
   $reservations = Reservation::where(
       'date_reservation',$request->date_reservation

   )->where('attente','non')->paginate(10);

   // three work

  }if(($request->date_reservation)&&($request->start_end)&&($request->code_salle)){
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);

   $reservations = Reservation::whereIn('code_creneau',$request->start_end)
   ->where('date_reservation', $request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','non')->paginate(10);


  }

  if(($request->date_reservation)&&($request->start_end)&&(!$request->code_salle)){
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);

   $reservations = Reservation::whereIn('code_creneau',$request->start_end)
   ->where('date_reservation', $request->date_reservation)->where('attente','non')->paginate(10);

  }


  if(($request->date_reservation)&&($request->code_salle)&&(!$request->start_end)){
      $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);


          $b= $request->date_reservation;
          $a= $request->code_salle;

   $reservations = Reservation::where(function ($request) use ($a) {
       $request->where('code_salle', 'LIKE', "%".$a."%");
   })->where(function ($request) use ($b) {
       $request->where('date_reservation', '=', $b);

   })->where('attente','non')->paginate(10);



  }

  if(($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)){

   $reservations = Reservation::whereIn('code_creneau',$request->start_end)
   ->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','non')->paginate(10);
  }


  if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
   $matricule=[];
  $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

  $reservations = Reservation::whereIn('matricule',$matricule)->where('date_reservation',$request->date_reservation)->where('attente','non')->paginate(10);
}


  if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
       $matricule=[];
      $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

      $reservations = Reservation::whereIn('matricule',$matricule)->where('attente','non')->paginate(10);
  }



  if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','non')->paginate(10);
}
if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('date_reservation',$request->date_reservation)->where('attente','non')->paginate(10);
}

if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('attente','non')->paginate(10);
}
if(($request->name)&&($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','non')->paginate(10);
}


if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->where('attente','non')->paginate(10);
}
if(($request->name)&&($request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
    $this->validate($request,[

        'date_reservation' =>  'date|after:yesterday',

    ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','non')->paginate(10);
}
  if((!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)&&(!$request->name)){
        $reservations = Reservation::where('attente','non')->paginate(10);

    }

 if($request->all_reservation){

    $reservations = Reservation::where('attente','non')->paginate(10);
 }
   return view('dashboard.admin.consultationReservation')
   ->with('reservations',$reservations)
   ->with('creneaus',$creneaus);




}


// affiche page reservation attente  et filtre

public function reservationSpecial(Request $request) {
    $creneaus=Creneau::all();


    //one start_end
    if(($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)){



        $reservations = Reservation::whereIn(
            'code_creneau',$request->start_end

        )->where('attente','oui')->paginate(10);


        //one code_salle
   }

   if(($request->code_salle)&&(!$request->date_reservation)&&(!$request->start_end)){
    $reservations = Reservation::where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','oui')->paginate(10);

   } //one date
   if(($request->date_reservation)&&(!$request->start_end)&&(!$request->code_salle)){
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);
    $reservations = Reservation::where(
        'date_reservation',$request->date_reservation

    )->where('attente','oui')->paginate(10);

    // three work

   }if(($request->date_reservation)&&($request->start_end)&&($request->code_salle)){
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);

    $reservations = Reservation::whereIn('code_creneau',$request->start_end)
    ->where('date_reservation', $request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','oui')->paginate(10);


   }

   if(($request->date_reservation)&&($request->start_end)&&(!$request->code_salle)){
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);

    $reservations = Reservation::whereIn('code_creneau',$request->start_end)
    ->where('date_reservation', $request->date_reservation)->where('attente','oui')->paginate(10);

   }


   if(($request->date_reservation)&&($request->code_salle)&&(!$request->start_end)){
       $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);


           $b= $request->date_reservation;
           $a= $request->code_salle;

    $reservations = Reservation::where(function ($request) use ($a) {
        $request->where('code_salle', 'LIKE', "%".$a."%");
    })->where(function ($request) use ($b) {
        $request->where('date_reservation', '=', $b);

    })->where('attente','oui')->paginate(10);



   }

   if(($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)){

    $reservations = Reservation::whereIn('code_creneau',$request->start_end)
    ->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','oui')->paginate(10);
   }


   if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);
    $matricule=[];
   $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

   $reservations = Reservation::whereIn('matricule',$matricule)->where('date_reservation',$request->date_reservation)->where('attente','oui')->paginate(10);
 }


   if(($request->name)&&(!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
        $matricule=[];
       $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

       $reservations = Reservation::whereIn('matricule',$matricule)->where('attente','oui')->paginate(10);
   }



   if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
     $matricule=[];
    $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

    $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','oui')->paginate(10);
 }
 if(($request->name)&&(!$request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);
     $matricule=[];
    $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

    $reservations = Reservation::whereIn('matricule',$matricule)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('date_reservation',$request->date_reservation)->where('attente','oui')->paginate(10);
 }

 if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)) {
     $matricule=[];
    $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

    $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('attente','oui')->paginate(10);
 }
 if(($request->name)&&($request->start_end)&&($request->code_salle)&&(!$request->date_reservation)) {
     $matricule=[];
    $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

    $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','oui')->paginate(10);
 }


 if(($request->name)&&($request->start_end)&&(!$request->code_salle)&&($request->date_reservation)) {
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);
     $matricule=[];
    $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

    $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->where('attente','oui')->paginate(10);
 }
 if(($request->name)&&($request->start_end)&&($request->code_salle)&&($request->date_reservation)) {
     $this->validate($request,[

         'date_reservation' =>  'date|after:yesterday',

     ]);
     $matricule=[];
    $matricule=enseignant::select('matricule')->where('nom_prenom', 'LIKE', "%".$request->name."%")->get();

    $reservations = Reservation::whereIn('matricule',$matricule)->whereIn('code_creneau',$request->start_end)->where('date_reservation',$request->date_reservation)->where('code_salle', 'LIKE', "%".$request->code_salle."%")->where('attente','oui')->paginate(10);
 }
   if((!$request->start_end)&&(!$request->code_salle)&&(!$request->date_reservation)&&(!$request->name)){
         $reservations = Reservation::where('attente','oui')->paginate(10);

     }


if($request->all_reservation){
    $reservations = Reservation::where('attente','oui')->paginate(10);
}
    return view('dashboard.admin.special')
    ->with('reservations',$reservations)
    ->with('creneaus',$creneaus);




 }

// accepte reservation attente

 public function accepte($id) {
     $reservation= reservation::find($id);
     $reservation->attente="non";

   $save=  $reservation->update();
   if($save) {
       return redirect()->back()
        ->with('accepte','réservation accepté avec succès ');
   }else {
    return redirect()->back()
    ->with('pas_accepte',"La réeservation n'a pas été acceptée, il y a un problème");
   }



 }














}
