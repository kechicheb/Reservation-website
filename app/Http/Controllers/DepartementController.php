<?php

namespace App\Http\Controllers;

use App\Models\departement;
use App\Models\enseignant;
use App\Models\reservation;
use App\Models\Reservation_materiel;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    //Affiche tout les Departement
    public function index()
    {
        $departements = Departement::latest()->paginate(6);


        return view('departements.index')
        ->with('departements',$departements);

    }

    //  affiche page ajouter Departement
    public function create()
    {

        return view('departements.create');
    }

    // ajouter Departement
    public function store(Request $request)
    {
        $this->validate($request,[


            'nom_dp' => 'required|alpha|min:1|max:40|unique:departements'
        ]);
        $departement = new Departement();

        $departement -> nom_dp = $request->nom_dp;

        $save = $departement->save();


            if( $save ){
                return redirect()->back()->with('success','Le departement a été ajouté avec succès ');
            }else{
                return redirect()->back()->with('fail','Un problème est survenu');
            }
    }

// affiche page mise a jour Departement
    public function edit($id) {
        $departement=departement::find($id);




        return view('departements.edit')->with('departement',$departement);

       }

       // mise a jour Departement

       public function update(Request $request,$id)
        {
            $departement=departement::find($id);
            $this->validate($request,[

                'nom_dp' => "required|alpha|min:1|max:40|unique:departements,nom_dp,$id"
            ]);





            $departement -> nom_dp = $request->nom_dp;



           $save= $departement->update();

           if( $save ){
            return redirect()->back()->with('success','Le departement mis à jour. ');
        }else{
            return redirect()->back()->with('fail','Un problème est survenu');
        }
    }
    // supprimer  Departement
    public function destroy($id)
    {
         $matricule=enseignant::select('matricule')->where('code_dp',$id)->get();

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



        $departement = Departement::find($id);
       $save= $departement->delete();


        if($save) {


            return redirect()->route('admin.departements')
            ->with('success','Le departement a été supprimé avec succès') ;

            }else{
                return redirect()->back()->with('fail','Un problème est survenu');



       }
    }
}
