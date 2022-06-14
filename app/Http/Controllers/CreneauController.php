<?php

namespace App\Http\Controllers;

use App\Models\creneau;
use App\Models\reservation;
use App\Models\Reservation_materiel;
use Illuminate\Http\Request;

class CreneauController extends Controller
{
      // afficher page tout les créneau

    public function index()
    {
        $creneaus = Creneau::latest()->paginate(6);

        return view('creneaus.index')
        ->with('creneaus',$creneaus);

    }
    // afficher page ajouter
    public function create()
    {
        return view('creneaus.create');
    }

    // ajouter créneau

    public function store(Request $request)
    {


        $this->validate($request,[
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',

        ]);
        $creneau = new Creneau();
        $creneau-> start =  $request->start;
        $creneau-> end =  $request->end;


        $save = $creneau->save();


            if( $save ){
                return redirect()->back()->with('success','Vous avez ajouté avec succès');
            }else{
                return redirect()->back()->with('fail','Un problème est survenu');
            }


    }

    // afficher page mise a jour

      public function edit($id)
    {

        $creneau=Creneau::find($id);

        return view('creneaus.edit')->with('creneau',$creneau);



    }

    // mise a jour créneau

    public function update(Request $request,$id)
    {


        $creneau =  Creneau::find($id);

        $this->validate($request,[

            'start' => "required|date_format:H:i",
            'end' => "required|date_format:H:i|after:start",


        ]);
        $id_reservation=reservation::select('id')->where('code_creneau',$id)->get();
        $reserv_materiel=Reservation_materiel::whereIn('code_reservation',$id_reservation)->get();
        foreach($reserv_materiel as $item) {
            $item->delete();
        }

         $reservation =reservation::where('code_creneau', $id)->get();
         foreach( $reservation as $item) {
            $item->delete();
        }

        $creneau-> start=  $request->start;
        $creneau-> end =  $request->end;


    $save = $creneau->update();

        if( $save ){

            return redirect()->back()->with('success','Créneau mis à jour.');
         }else{
             return redirect()->back()->with('fail','Un problème est survenu');
          }

        }


        // supperimer créneau
        public function destroy($id)
        {



            $id_reservation=reservation::select('id')->where('code_creneau',$id)->get();
            $reserv_materiel=Reservation_materiel::whereIn('code_reservation',$id_reservation)->get();
            foreach($reserv_materiel as $item) {
                $item->delete();
            }

             $reservation =reservation::where('code_creneau', $id)->get();
             foreach( $reservation as $item) {
                $item->delete();
            }

            $creneau=Creneau::find($id);
          $save = $creneau->delete();
          if($save) {


            return redirect()->route('admin.creneaus')
            ->with('success','Le créneau a été supprimé avec succès') ;

            }else{
                return redirect()->back()->with('fail','Un problème est survenu');

            }

       }
}
