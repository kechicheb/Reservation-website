<?php

namespace App\Http\Controllers;

use App\Models\materiel;

use App\Models\Reservation_materiel;


use Illuminate\Http\Request;

class MaterielController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');

    }
// affiche tout Materiel
    public function index(Request $request){

        $materiels = Materiel::latest()->paginate(10);
        if(!$request == null) {


            $materiels = Materiel::where('nom', 'LIKE', "%".$request->nom."%")
            ->orWhere('marque', 'LIKE', "%".$request->nom."%")->paginate(10);
        }
        if($request->all_materiel) {
            $materiels = Materiel::latest()->paginate(10);
        }
        return view('materiels.index',compact('materiels'));
    }

// affiche page ajouter Materiel
    public function create()
    {
        return view('materiels.create');
    }

// ajouter Materiel
    public function store(Request $request)
    {
        $this->validate($request,[

            'n_serie' =>  'required|string|min:3|max:40|unique:materiels',
            'nom' =>  'required|string|min:3|max:30',
            'marque' =>  'required|alpha|min:1|max:30',
            'desecription' =>  'required|string|min:3|max:200',

        ]);
        $materiel = new Materiel();
        $materiel-> n_serie =  $request->n_serie;
        $materiel->nom =  $request->nom;
        $materiel-> marque =   $request->marque;
        $materiel-> desecription =  $request->desecription;
        $save = $materiel->save();


        if( $save ){
            return redirect()->back()->with('success','Le matérial a été ajouté avec succès ');
        }else{
            return redirect()->back()->with('fail','Un problème est survenu');
        }









    }

   //afficher page  mise a jour Materiel

    public function edit($id)
    {

        $materiel=Materiel::find($id);


        return view('materiels.edit',compact('materiel'));

    }


    // mise a jour Materiel

    public function update(Request $request,$id)
    {
        $materiel=Materiel::find($id);
         $this->validate($request,[
            'n_serie' =>  "required|string|min:3|max:40|unique:materiels,n_serie,$id",
            'nom' =>  'required|string|min:3|max:30',
            'marque' =>  'required|alpha|min:1|max:30',
            'desecription' =>  'required|string|min:3|max:200',
        ]);

        $materiel-> n_serie =  $request->n_serie;
        $materiel->nom =  $request->nom;
        $materiel-> marque =   $request->marque;
        $materiel-> desecription =  $request->desecription;
       $save= $materiel->update();

       if( $save ){
        return redirect()->back()->with('success','Le matérial mis à jour. ');
    }else{
        return redirect()->back()->with('fail','Un problème est survenu');
    }

    }


// supprimer Materiel
    public function destroy($id)
    {
        $reserv_materiel=Reservation_materiel::where('code_materiel',$id)->get();
            foreach($reserv_materiel as $item) {
                $item->delete();
            }

        $materiel=Materiel::find($id);
    $save=    $materiel->delete();

        if( $save ){
                return redirect()->route('admin.materiels')
                ->with('success','Le matérial a été supprimé avec succès ');
        }else{
            return redirect()->route('admin.materiels')
            ->with('fail','Un problème est survenu');
        }

   }


}
