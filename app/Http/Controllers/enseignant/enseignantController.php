<?php

namespace App\Http\Controllers\enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reservation;
use App\Models\Reservation_materiel;
use App\Models\enseignant;
use App\Models\Departement;
use App\Models\Statu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;






class enseignantController extends Controller
{

    // afficher page enseignant


   public function index(Request $request)
    {
        $enseignants = enseignant::latest()->paginate(10);
        if(!$request == null) {


            $enseignants = enseignant::where('nom_prenom', 'LIKE', "%".$request->user."%")
                                     ->orWhere('matricule', 'LIKE', "%".$request->user."%")->paginate(10);
        }
        if($request->all_enseignant){
            $enseignants = enseignant::latest()->paginate(10);
        }
         $status = Statu::all();
         $departements = Departement::all();

        return view('enseignants.index')
        ->with('enseignants',$enseignants)
        ->with('status',$status)
        ->with('departements',$departements);

    }


        // afficher page de ajouter enseignant
    public function create()
    {
        $status =Statu::all();
         $departements =Departement::all();

        if ($status->count() == 0) {
            return   redirect()->route('admin.status.create');
        }elseif($departements->count() == 0){
            return   redirect()->route('admin.departement.create');
        }
        return view('enseignants.create')
                    ->with('status' ,  $status)
                    ->with('departements',$departements);
    }

    // ajouter enseignant

   public function store(Request $request){
     if($request->telephone) {
        $request->validate([

            'matricule'=>'required|integer|unique:enseignants,matricule',
            'nom_prenom'=>'required|alpha_spaces|min:2|max:40',

              'email'=>'required|email|unique:enseignants,email',
              'password'=> [
                'required',
                'string',
                'min:10',
                'max:30',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',

            ],
              'cpassword'=>'required|min:10|max:30|same:password',
              'telephone'=>'required|numeric|digits:10',
              'type_status'=>'required|alpha|exists:status,type_status',
              'nom_dp' =>'required|alpha|exists:departements,nom_dp',


          ]);
     }else {
        $request->validate([
            'matricule'=>'required|integer|unique:enseignants,matricule',
            'nom_prenom'=>'required|alpha_spaces|min:2|max:40',
              'email'=>'required|email|unique:enseignants,email',
              'password'=> [
                'required',
                'string',
                'min:10',
                'max:30',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',

            ],
              'cpassword'=>'required|min:10|max:30|same:password',

              'type_status'=>'required|alpha|exists:status,type_status',
              'nom_dp' =>'required|alpha|exists:departements,nom_dp',


          ]);
     }

          //Validate Inputs


          $departements =Departement::all();
          foreach($departements as $item){
              if($item->nom_dp == $request->nom_dp){

                $code_dep =$item->id;
              }
          }
          $status =statu::all();
          foreach($status  as $item){
              if($item->type_status == $request->type_status){

                $type_s =$item->id;
              }
          }
 if($request->type_etat) {
    $enseignant = new enseignant();
    $enseignant->matricule = $request->matricule;
    $enseignant->nom_prenom = $request->nom_prenom ;
    $enseignant->email = $request->email;
    $enseignant->password = Hash::make($request->password);
    $enseignant->telephone = $request->telephone;
    $enseignant->type_etat = "acitve";
    $enseignant->type_status = $type_s;
    $enseignant->code_dp = $code_dep;

      $save = $enseignant->save();
 }else{
    $enseignant = new enseignant();
    $enseignant->matricule = $request->matricule;
    $enseignant->nom_prenom = $request->nom_prenom ;
    $enseignant->email = $request->email;
    $enseignant->password = Hash::make($request->password);
    $enseignant->telephone = $request->telephone;
    $enseignant->type_etat = "désactive";
    $enseignant->type_status = $type_s;
    $enseignant->code_dp = $code_dep;

      $save = $enseignant->save();
 }


 if( $save ){
    return redirect()->back()->with('success','Le enseignant a été ajouté avec succès ');
}else{
    return redirect()->back()->with('fail','Un problème est survenu');
}



    }

    // afficher page mise a jour enseignant

    public function edit($id)
    {

        $enseignant=enseignant::find($id);
        $status =Statu::all();
         $departements =Departement::all();



        return view('enseignants.edit')->with('enseignant',$enseignant)
          ->with('status',$status)
        ->with('departements',$departements);



    }


    // mise a jour enseignant

    public function update(Request $request,$id)
    {

        $enseignant=enseignant::find($id);
        if($request->telephone) {
            $request->validate([
                'nom_prenom'=>'required|alpha_spaces|min:2|max:40',
                  'telephone'=>'required|numeric|digits:10',
                  'type_status'=>'required|alpha|exists:status,type_status',
                  'nom_dp' =>'required|alpha|exists:departements,nom_dp',

              ]);
         }else {
            $request->validate([
                'nom_prenom'=>'required|alpha_spaces|min:2|max:40',

                  'type_status'=>'required|alpha|exists:status,type_status',
                  'nom_dp' =>'required|alpha|exists:departements,nom_dp',

              ]);
         }



       $departements =Departement::all();
       foreach($departements as $item){
           if($item->nom_dp == $request->nom_dp){

             $code_dep =$item->id;
           }
       }
       $status =statu::all();
       foreach($status  as $item){
           if($item->type_status == $request->type_status){

             $type_s =$item->id;
           }
       }
       $enseignant->nom_prenom = $request->nom_prenom;
        $enseignant->telephone = $request->telephone;
       if($request->type_etat) {

        $enseignant->type_etat = 'active';
       } else{
        $enseignant->type_etat = 'désactive';
       }

        $enseignant->type_status = $type_s;
        $enseignant->code_dp = $code_dep;


       $save= $enseignant->update();

       if( $save ){
        return redirect()->back()->with('success','Le enseignant a été mis à jour ');
    }else{
        return redirect()->back()->with('fail','Un problème est survenu');
    }


        }

        // supprimer enseignant

    public function destroy($id)
    {

        $id_reservation=reservation::select('id')->where('matricule',$id)->get();
        $reserv_materiel=Reservation_materiel::whereIn('code_reservation',$id_reservation)->get();
        foreach($reserv_materiel as $itemm) {
            $itemm->delete();
        }

         $reservation =reservation::where('matricule', $id)->delete();

        $enseignant=enseignant::find($id);
     $save=  $enseignant->delete();
     if($save) {
        return redirect()->route('admin.enseignants')
        ->with('success','enseignant supprimé avec succès') ;
     }else {
        return redirect()->route('admin.enseignants')
        ->with('fail',"enseignant pas supprimé , il y a problème ") ;
     }


   }



      //vérifiez que les information de connexion sont correctes pour la connexion


    function check(Request $request){
        //Validate inputs
        $request->validate([
           'email'=>'required|email|exists:enseignants,email',
           'password'=>'required|min:10|max:30'
        ],[

           'email.exists'=>"Cet email n'existe pas  sur la table des enseignants ",
        ]);



        $creds = $request->only('email','password');
        if( Auth::guard('web')->attempt($creds) ){
            return redirect()->route('enseignant.consultationReservation');
        }else{
            return redirect()->route('enseignant.login')->with('fail','Les informations que vous avez saisies sont erronées');
        }
    }

       // déconnecter

    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }

         // afficher page profil
    public function passedit($id) {

        $enseignant=enseignant::find($id);
            return view('dashboard.enseignant.edit')->with('enseignant',$enseignant);

    }

// mise a jour mot de passe ou téléphone
    public function  passupdate(Request $request, $id)
    {
        $enseignant=enseignant::find($id);
        if(!$request->telephone && !$request->oldpassword && !$request->newpassword){
            $enseignant->telephone=$request->telephone;

            $save= $enseignant->update();

            if( $save ){

                return redirect()->back()->with('success','Votre numéro de téléphone a été mis à jour');
             }else{
                 return redirect()->back()->with('fail','Il y a un problème, ne pas mettre à jour votre numéro de téléphone');
              }

        }
                if(!$request->telephone && $request->oldpassword && $request->newpassword) {


                    $this->validate($request, [

                        'oldpassword' => 'required',
                        'newpassword'=> [
                            'required',
                            'string',
                            'min:10',
                            'max:30',
                            'regex:/[a-z]/',
                            'regex:/[A-Z]/',
                            'regex:/[0-9]/',
                            'regex:/[@$!%*#?&]/',
                            'different:oldpassword',

                        ],


                    ]);
                    if (Hash::check($request->oldpassword, $enseignant->password)) {

                         $enseignant->telephone=$request->telephone;
                        $enseignant->password = Hash::make($request->newpassword);
                        $save= $enseignant->update();

                        if( $save ){

                            return redirect()->back()->with('success','Le mot de passe été mis à jour avec succès');
                         }else{
                             return redirect()->back()->with('fail','mauvais ancien mot de passe');
                          }
                     }
                }
                if($request->telephone && (($request->oldpassword &&  !$request->newpassword) ||(!$request->oldpassword &&  $request->newpassword))) {
                    $this->validate($request, [
                        'telephone'=>'required|numeric|digits:10',
                        'oldpassword' => 'required',
                        'newpassword'=> [
                            'required',
                            'string',
                            'min:10',
                            'max:30',
                            'regex:/[a-z]/',
                            'regex:/[A-Z]/',
                            'regex:/[0-9]/',
                            'regex:/[@$!%*#?&]/',
                            'different:oldpassword',

                        ],

                    ]);
                }
                if(!$request->telephone &&  (($request->oldpassword &&  !$request->newpassword) ||(!$request->oldpassword &&  $request->newpassword))) {
                    $this->validate($request, [

                        'oldpassword' => 'required',
                        'newpassword'=> [
                            'required',
                            'string',
                            'min:10',
                            'max:30',
                            'regex:/[a-z]/',
                            'regex:/[A-Z]/',
                            'regex:/[0-9]/',
                            'regex:/[@$!%*#?&]/',
                            'different:oldpassword',

                        ],

                    ]);

                }
                if($request->telephone && (!$request->oldpassword && !$request->newpassword)) {

                    $this->validate($request, [
                        'telephone'=>'required|numeric|digits:10',

                    ]);

                        $enseignant->telephone = $request->telephone;
                        $save= $enseignant->update();

                        if( $save ){

                            return redirect()->back()->with('success','Votre numéro de téléphone a été mis à jour');
                         }else{
                             return redirect()->back()->with('fail','Il y a un problème, ne pas mettre à jour votre numéro de téléphone');
                          }
                }
                if($request->telephone &&  $request->oldpassword &&  $request->newpassword){
                    $this->validate($request, [
                    'telephone'=>'required|numeric|digits:10',
                    'oldpassword' => 'required',
                    'newpassword'=> [
                        'required',
                        'string',
                        'min:10',
                        'max:30',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/',
                        'different:oldpassword',

                    ]

                ]);
                if (Hash::check($request->oldpassword, $enseignant->password)) {

                    $enseignant->telephone = $request->telephone;
                    $enseignant->password = Hash::make($request->newpassword);
                    $save= $enseignant->update();

                    if( $save ){

                        return redirect()->back()->with('success','Vos informations ont été mises à jour avec succès');
                     }else{
                         return redirect()->back()->with('fail','Un problème est survenu');
                      }
                 }}





    }

        // afficher page de envoyer un lien de changer le mot de passe

    public function showForgotForm() {
        return view('dashboard.enseignant.forgot');
    }

    // envoyer un lien de changer le mot de passe à email

    public function sendResetLink(Request $request) {

        $this->validate($request, [
            'email' => 'required|email|exists:enseignants,email',
        ]);
       $token = \Str::random(64);
       \DB::table('password_resets')->insert([
           'email'=>$request->email,
           'token'=> $token,
           'created_at' => Carbon::now(),
       ]);
       $action_link = route('enseignant.reset.password.form',['token' => $token,'email'=>$request->email]);

       $body = "Nous recevons une demande de réinitialisation de mot de passe du <b> Site de réservation </b> compte associe à ".$request ->email;
         \Mail::send('email-forgot', ['action_link'=>$action_link,'body'=>$body ], function ($message) use ($request) {
            $message->from('ahmed.kechicheb@univ-constantine2.dz', 'Site de réservation');
            $message->to($request->email, 'Site de réservation');
            $message->subject('Réinitialiser le mot de passe');


        });
     return redirect()->back()->with('success','Nous avons envoyé lien de réinitialisation de mot de passe par email!');

    }
    // page oublier mot de passe

    public function showResetForm(Request $request,$token = null ) {


        return view('dashboard.enseignant.reset')->with(['token'=>$token,'email'=>$request->email]);
    }

    // réinitialiser le mot de passe

    public function resetPassword(Request $request) {

        $request ->validate([
        'email'=>'required|exists:enseignants,email',
        'password'=> [
            'required',
            'string',
            'min:10',
            'max:30',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',


        ],
        'cpassword'=> [
            'required',
            'string',
            'min:10',
            'max:30',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
            'same:password',

        ],

        ]);
        $check_token = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();

        if(!$check_token) {
            return back()->withInput()->with('fail','Non valide token');
        }else {
          enseignant::where('email',$request->email)->update([
              'password'=>\Hash::make($request->password)
          ]);
          \DB::table('password_resets')->where([
              'email'=>$request->email
          ])->delete();

          return redirect()->route('enseignant.login')
          ->with('info','Votre mot de passe a été changé! vous pouvez vous connecter avec un nouveau mot de passe')
          ->with('verifiedEmail',$request->email);

        }

    }




}