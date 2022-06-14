<?php

namespace App\Http\Controllers;

use App\Models\statu;
use App\Models\enseignant;
use App\Models\reservation;
use App\Models\Reservation_materiel;
use Illuminate\Http\Request;

class StatuController extends Controller
{

    // afficher tout status
    public function index()
    {
        $status = statu::latest()->paginate(10);


        return view('status.index')
        ->with('status',$status);

    }
    //afficher page ajouter status

    public function create()
    {
        return view('status.create');
    }


    // ajouter status
    public function store(Request $request)
    {

        $this->validate($request,[
            'type_status' =>  'required|alpha|min:2|max:30|unique:status'
        ]);
        $status = new statu();
        $status-> type_status =  $request->type_status;

        $save = $status->save();


        if( $save ){
            return redirect()->back()->with('success','Le status a été ajouté avec succès ');
        }else{
            return redirect()->back()->with('fail','Un problème est survenu');
        }


    }


    // afficher page mise a jour status

    public function edit($id) {
        $statu=statu::find($id);




        return view('status.edit')->with('statu',$statu);

       }
// mise a jour status
       public function update(Request $request,$id)
        {
            $statu=statu::find($id);
            $this->validate($request,[
                'type_status' =>  "required|alpha|min:2|max:30|unique:status,type_status,$id"
            ]);

            $statu-> type_status =  $request->type_status;








           $save=  $statu->update();

           if( $save ){
            return redirect()->back()->with('success','Le status  mise à jour. ');
        }else{
            return redirect()->back()->with('fail','Un problème est survenu');
        }

            }






       // supprimer statu

        public function destroy($id)
        {
        $matricule=enseignant::select('matricule')->where('type_status',$id)->get();
        $id_reservation=reservation::select('id')->whereIn('matricule', $matricule)->get();
        $reserv_materiel=Reservation_materiel::whereIn('code_reservation',$id_reservation)->get();
        foreach($reserv_materiel as $item) {
            $item->delete();
        }

         $reservation =reservation::whereIn('matricule',$matricule)->get();
         foreach( $reservation as $item) {
            $item->delete();
        }
        $enseignant=enseignant::whereIn('matricule',$matricule)->get();
        foreach(   $enseignant as $item) {
            $item->delete();
        }


        $status = statu::find( $id);
     $save=  $status->delete();


        if( $save ){
            return redirect()->route('admin.status')
            ->with('success','Le status a été supprimé avec succès ');
    }else{
        return redirect()->route('admin.status')
        ->with('fail','Un problème est survenu');
    }

   }
}
