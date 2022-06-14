<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Salle;
use App\Models\Type_salle;
use App\Models\reservation;
use App\Models\Reservation_materiel;

class SalleController extends Controller
{


    // affiche tout les salles et type salles
    public function index(Request $request)
    {
        $salles = Salle::latest()->paginate(10);
        if(!$request == null) {


            $salles = Salle::where('code_salle', 'LIKE',$request->code_salle."%")->
            orWhere('capacite', 'LIKE', "%".$request->code_salle."%")->
            orWhere('etage', 'LIKE', "%".$request->code_salle."%")->orWhere('special', 'LIKE', "%".$request->code_salle."%")->paginate(10);
        }
        $type_salles = Type_salle::latest()->paginate(4);
if($request->all_salle) {
    $salles = Salle::latest()->paginate(10);
}
        return view('salles.index')
        ->with('salles',$salles)
        ->with('type_salles',$type_salles);

    }


//afficher page  ajouter salle
    public function create()
    {
             $type_salles = Type_salle::all();
        if ($type_salles->count() == 0) {
            return   redirect()->route('admin.type_salle.create');
        }
        return view('salles.create')
                    ->with('type_salles' ,  $type_salles);
    }

    // ajouter salle
    public function store(Request $request)
    {

        $this->validate($request,[

            'code_salle' =>  'required|alpha_number|min:1|max:15|unique:salles',
            'type_salle' =>  'required|string|min:1|max:15|exists:type_salles,type_salle',
            'capacite' =>  'required|numeric|digits_between:1,10',
            'etage' =>  'required|numeric|digits_between:0,10',

        ]);
        $type_salles=Type_salle::get();
        foreach($type_salles as $item){
            if($item->type_salle == $request->type_salle) {
                $type=$item->id;
            }

        }
        $salle = new Salle();
        $salle-> code_salle =  $request->code_salle;
        $salle-> type_salle =  $type;
        $salle->capacite =  $request->capacite;
        $salle-> etage =   $request->etage;
        if(!$request->special){
            $salle-> special="normal";
        }else{
            $salle-> special="spécial";
        }

        $save=$salle->save();


        if( $save ){
            return redirect()->back()->with('success','La salle a été ajouté avec succès ');
        }else{
            return redirect()->back()->with('fail','Un problème est survenu');
        }

    }



// supprimer salle

    public function destroy($id)
    {
         $id_reservation=reservation::select('id')->where('code_salle',$id)->get();
        $reserv_materiel=Reservation_materiel::whereIn('code_reservation',$id_reservation)->get();
        foreach($reserv_materiel as $item) {
            $item->delete();
        }

         $reservation =reservation::whereIn('id',$id_reservation)->get();
         foreach( $reservation as $item) {
            $item->delete();
        }
        $salle=Salle::find($id);
      $save=  $salle->delete();

        if( $save ){
            return redirect()->route('admin.salles')
            ->with('success','La salle a été supprimé avec succès ');
    }else{
        return redirect()->route('admin.salles')
        ->with('fail','Un problème est survenu');
    }


   }
}
