<?php

namespace App\Http\Controllers\Personne_admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne_admin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Personne_adminController extends Controller
{

     // afficher tout les personne admin

    public function index(Request $request)
    {
        $Personne_admins = Personne_admin::latest()->paginate(10);
        if(!$request == null) {


            $Personne_admins = Personne_admin::where('nom_prenom', 'LIKE', "%".$request->Personne_admin."%")->paginate(10);
        }
        if($request->all_personne)
        {

            $Personne_admins = Personne_admin::paginate(10);
        }

        return view('Personne_admins.index',compact('Personne_admins'));
    }

    // page ajouter personne admin

    public function create()
    {
        return view('Personne_admins.create');
    }

    // ajouter personne admin

    public function store(Request $request)
    {

        if($request->telephone) {
            $request->validate([


                'nom_prenom'=>'required|alpha_spaces|min:2|max:40',
                  'email'=>"required|email|unique:Personne_admins,email",
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


              ]);
         }
        else{
            $request->validate([

                'nom_prenom'=>'required|alpha_spaces|min:2|max:40',
                'email'=>"required|email|unique:Personne_admins,email",
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




              ]);
         }


         $Personne_admin = new Personne_admin();

         $Personne_admin->nom_prenom = $request->nom_prenom;

         $Personne_admin->telephone = $request->telephone;
         $Personne_admin->email = $request->email;
         $Personne_admin->password = \Hash::make($request->password);
         $save = $Personne_admin->save();

            if( $save ){
                return redirect()->back()->with('success','Ajouté avec succès');
            }else{
                return redirect()->back()->with('fail',"Echec de l'ajout");
            }











        }


      // afficher page mise a jour

    public function edit($id)
    {

        $Personne_admin=Personne_admin::find($id);


        return view('Personne_admins.edit',compact('Personne_admin'));

    }

       // mise a jour personne admin
    public function update(Request $request,$id)
    {


        if($request->telephone) {
            $request->validate([

                'nom_prenom'=>'required|alpha_spaces|min:2|max:40',
                  'email'=>"required|email|unique:Personne_admins,email,$id",
                  'telephone'=>'required|numeric|digits:10',


              ]);
         }else {
            $request->validate([

                'nom_prenom'=>'required|alpha_spaces|min:2|max:40',
                  'email'=>"required|email|unique:Personne_admins,email,$id",
                  'telephone'=>'required|numeric|digits:10',



              ]);
         }



    $Personne_admin =  Personne_admin::find($id);

    $Personne_admin->nom_prenom = $request->nom_prenom;
    $Personne_admin->telephone = $request->telephone;
    $Personne_admin->email = $request->email;

       $save= $Personne_admin->update();

       if( $save ){
        return redirect()->back()->with('success','Mis à jour avec succès');
    }else{
        return redirect()->back()->with('fail',"Mis à jour n'a pas réussi");
    }


    }


     // supprime personne admin

    public function destroy($id)
    {
        $Personne_admin=Personne_admin::find($id);
      $save=  $Personne_admin->delete();
      if($save) {
        return redirect()->route('admin.Personne_admins')
        ->with('success','Il a été supprimé avec suuccès');
      }else {
           return redirect()->route('admin.Personne_admins')
        ->with('fail','Echec de la suppression');

      }


   }


        // afficher le profil personne admin
   public function passedit($id) {

    $Personne_admin=Personne_admin::find($id);
        return view('dashboard.Personne_admin.edit')->with('Personne_admin',$Personne_admin);

}
                // mise a jour mot de passe ou téléphone

public function  passupdate(Request $request, $id)
{
    $Personne_admin=Personne_admin::find($id);
    if(!$request->telephone && !$request->oldpassword && !$request->newpassword){
          $Personne_admin->telephone=$request->telephone;

        $save=   $Personne_admin->update();

        if( $save ){

            return redirect()->back()->with('success','Votre numéro de téléphone a été mis à jour');
         }else{
             return redirect()->back()->with('fail','Il y a un problème, ne pas mettre à jour votre numéro de téléphone');
          }

    }
            if(!$request->telephone && $request->oldpassword && $request->newpassword) {


                $this->validate($request, [

                    'oldpassword' => 'required',
                    'newpassword' => [
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
                if (Hash::check($request->oldpassword, $Personne_admin->password)) {

                    $Personne_admin->telephone=$request->telephone;
                    $Personne_admin->password = Hash::make($request->newpassword);
                    $save= $Personne_admin->update();

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
                    'newpassword' => [
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
                    'newpassword' => [
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

                    $Personne_admin->telephone = $request->telephone;
                    $save= $Personne_admin->update();

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
                'newpassword' => [
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
            if (Hash::check($request->oldpassword, $Personne_admin->password)) {

                $Personne_admin->telephone = $request->telephone;
                $Personne_admin->password = Hash::make($request->newpassword);
                $save= $Personne_admin->update();

                if( $save ){

                    return redirect()->back()->with('success','Vos informations ont été mises à jour avec succès');
                 }else{
                     return redirect()->back()->with('fail','Un problème est survenu');
                  }
             }}




            }









   //vérifiez que les information de connexion sont correctes pour la connexion

    function check(Request $request){
        //Validate Inputs
        $request->validate([
           'email'=>'required|email|exists:Personne_admins,email',
           'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>"Cet email n'existe pas  sur la table des Personne_admins"
        ]);

        $creds = $request->only('email','password');

        if( Auth::guard('Personne_admin')->attempt($creds) ){
            return redirect()->route('Personne_admin.consultationReservation');
        }else{
            return redirect()->route('Personne_admin.login')->with('fail','Les informations que vous avez saisies sont erronées');
        }
    }

         // déconnecter
    function logout(){
        Auth::guard('Personne_admin')->logout();

        return redirect('/');
    }


        // afficher page de envoyer un lien de changer le mot de passe
    public function showForgotForm() {
        return view('dashboard.Personne_admin.forgot');
    }




    // envoyer un lien de changer le mot de passe à email
    public function sendResetLink(Request $request) {

        $this->validate($request, [
            'email' => 'required|email|exists:Personne_admins,email',
        ]);
       $token = \Str::random(64);
       \DB::table('password_resets')->insert([
           'email'=>$request->email,
           'token'=> $token,
           'created_at' => Carbon::now(),
       ]);
       $action_link = route('Personne_admin.reset.password.form',['token' => $token,'email'=>$request->email]);

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


        return view('dashboard.Personne_admin.reset')->with(['token'=>$token,'email'=>$request->email]);
    }



// réinitialiser le mot de passe

    public function resetPassword(Request $request) {

        $request ->validate([
        'email'=>'required|email|exists:Personne_admins,email',
        'password' => [
            'required',
            'string',
            'min:10',
            'max:30',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',

        ],
        'cpassword' => [
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
          Personne_admin::where('email',$request->email)->update([
              'password'=>\Hash::make($request->password)
          ]);
          \DB::table('password_resets')->where([
              'email'=>$request->email
          ])->delete();

          return redirect()->route('Personne_admin.login')
          ->with('info','Votre mot de passe a été changé! vous pouvez vous connecter avec un nouveau mot de passe')
          ->with('verifiedEmail',$request->email);

        }

    }
}