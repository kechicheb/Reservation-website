<?php

namespace App\Http\Controllers;

use App\Models\Type_salle;
use App\Models\Salle;
use App\Models\reservation;
use App\Models\Reservation_materiel;

use Illuminate\Http\Request;

class TypeSalleController extends Controller
{


    // afficher page ajouter type_salle

    public function create()
    {
        return view('type_salles.create');
    }


    // ajouter type_salle

    public function store(Request $request)
    {

        $this->validate($request,[
            'type_salle' =>  'required|alpha_number|min:1|max:15|unique:type_salles'
        ]);
        $type_salle = new Type_salle();
        $type_salle-> type_salle =  $request->type_salle;

        $save = $type_salle->save();

        if( $save ){
            return redirect()->back()->with('success','Le type salle a été ajouté avec succès ');
        }else{
            return redirect()->back()->with('fail','Un problème est survenu');
        }


    }
// supprimer type_salle

        public function destroy($id)
    {
        $code=Salle::select('code_salle')->where('type_salle',$id)->get();
         $id_reservation=reservation::select('id')->whereIn('code_salle',$code)->get();
        $reserv_materiel=Reservation_materiel::whereIn('code_reservation',$id_reservation)->get();
        foreach($reserv_materiel as $item) {
            $item->delete();
        }

         $reservation =reservation::whereIn('code_salle',$code)->get();
         foreach( $reservation as $item) {
            $item->delete();
        }
        $salle=Salle::whereIn('code_salle',$code)->get();
        foreach( $salle as $item) {
            $item->delete();
        }


        $type_salle = Type_salle::find( $id);
       $save= $type_salle->delete();

        if( $save ){
            return redirect()->route('admin.salles')
            ->with('success','Le ype sallet a été supprimé avec succès ');
    }else{
        return redirect()->route('admin.salles')
        ->with('fail','Un problème est survenu');
    }

   }

   // afficher page mise a jour type_salle

   public function edit($id) {
    $type_salle=Type_salle::find($id);




    return view('type_salles.edit')->with('type_salle',$type_salle);

   }


   // mise a jour type_salle
   public function update(Request $request,$id)
    {
        $type_salle=Type_salle::find($id);
        $this->validate($request,[

            'type_salle' =>  "required|alpha_number|min:1|max:15|unique:type_salles,type_salle,$id"


       ]);




        $type_salle->type_salle = $request->type_salle;



       $save= $type_salle->update();

       if( $save ){
        return redirect()->back()->with('Typesuccess','Le type salle a été  mise à jour. ');
    }else{
        return redirect()->back()->with('Typefail','Un problème est survenu');
    }

        }

}
