<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('renove','AppController@renove');

Route::get('default',function (){
    return view('default');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::resource('eleves','EleveController');
Route::resource('responsables','ResponsableController');
Route::resource('personnels','PersonnelController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('initialize','ProjectController@initializeProject');

/*
 * Pour toutes les requetes ajax,
 * avec Vue.js et Axios
 *
 */

Route::get('test',function(){
   return view('test');
});

Route::group(['prefix'=>'ajax'],function(){

    //Blog
    Route::get('load_poste','Admin\BlogController@loadPost');
    Route::post('add_poste','Admin\BlogController@store');
    Route::post('add_comment','Admin\BlogController@storecomment');
    Route::put('update_poste/{id}','Admin\BlogController@updateposte');
    Route::put('loadposte_User/{id}','Admin\BlogController@loaduser');
    Route::get('delete_post/{id}','Admin\BlogController@destroy');
    Route::get('delete_comment/{id}','Admin\BlogController@destroyComment');

    /**
     *
     * PROTECTED MODULES
     */

    //RETARD
    Route::get('load_retards_datas','Ajax\RetardController@loadDatas');

    //CONSEIL
    Route::get('load_conseil_datas','Ajax\ConseilController@loadConseilDatas');
    Route::post('set_conseil_for_eleve','Ajax\ConseilController@setConseil');


    /*
     * HOME PAGE
     */
    Route::get('load_prof_home','HomeController@loadProfHome');
    Route::get('load_admin_home','HomeController@loadAdminHome');
    Route::get('load_parent_home','HomeController@loadParentHome');

    /*
     * GET VALID INFORMATIONS FROM InitController
     */
    Route::get('get_valid_information','InitController@getValidInformation');

    /*
     * AJAX ESPACE ADMIN
     *
     */
    //Eleve
    Route::get('load_eleves','Admin\EleveController@loadEleves');
    Route::post('add_eleve','Admin\EleveController@store');
    Route::get('delete_eleve/{id}','Admin\EleveController@destroy');
    Route::put('update_Eleve/{id}','Admin\EleveController@updateEleves');

    //Responsables
    Route::get('load_responsables','Admin\ResponsableController@loadResponsables');
    Route::post('add_responsable','Admin\ResponsableController@store');
    Route::get('delete_responsable/{id}','Admin\ResponsableController@destroy');
    Route::put('update_Responsable/{id}','Admin\ResponsableController@updateResponsables');

    //Personnel
    Route::get('load_personnels','Admin\PersonnelController@loadPersonnels');
    Route::post('add_personnel','Admin\PersonnelController@store');
    Route::get('delete_personnel/{id}','Admin\PersonnelController@destroy');
    Route::put('update_personnel/{id}','Admin\PersonnelController@updatePersonnels');

    //Matieres
    Route::get('load_matieres','Admin\MatiereController@loadMatieres');
    Route::put('update_matiere/{id}','Admin\MatiereController@updateMatieres');
    Route::post('add_matiere','Admin\MatiereController@store');
    Route::get('delete_matiere/{id}','Admin\MatiereController@destroy');

    //Informations
    Route::get('load_informations','Admin\InformationController@loadInformations');
    Route::post('add_information','Admin\InformationController@store');
    Route::get('delete_information/{id}','Admin\InformationController@destroy');
    Route::put('update_information/{id}','Admin\InformationController@updateInformations');
    Route::put('activate_information/{id}','Admin\InformationController@activateInformation');


    /**
     * EVALUATIONS
     */
    // NOTES
    //Admin
    Route::get('load_notes_datas_from_admin','Admin\EvaluationController@loadNotesDatasFromAdmin');
//    Route::get('delete_evaluation/{id}','AppController@deleteEvaluation');
    Route::get('load_evaluations/{classe_id}/{session_id}/{matiere_id}','Admin\EvaluationController@loadEvaluations');
    Route::get('load_evaluations_of_mod/{classe_id}/{session_id}/{module_id}','Admin\EvaluationController@loadEvaluationsOfMod');
    Route::get('load_evaluations_of_sm/{classe_id}/{session_id}/{sm_id}','Admin\EvaluationController@loadEvaluationsOfSm');
    Route::post('set_appreciation','Admin\EvaluationController@setAppreciation');
//    Route::post('update_note','AppController@updateNote');

    //RELEVES
    Route::get('load_releves_datas_from_admin','Admin\EvaluationController@loadReleveesDatasFromAdmin');

    //Prof
    Route::get('load_notes_datas_from_prof','Prof\EvaluationController@loadNotesDatasFromProf');

    //All
    Route::get('load_evaluations/{classe_id}/{matiere_id}/{session_id}','EvaluationController@loadEvaluations');
    Route::get('delete_evaluation/{evaluation_id}','EvaluationController@deleteEvaluation');
    Route::put('update_evaluation/{evaluation_id}','EvaluationController@updateEvaluation');
    Route::post('create_evaluation','EvaluationController@createEvaluation');
    Route::post('update_note','EvaluationController@updateNote');

    //ABSENCES
    Route::get('load_planning_for_classes_with_absences','Ajax\AbsenceController@loadPlanningWithAbsences');
    Route::post('set_absents','Ajax\AbsenceController@setAbsents');

    //RETARD
    Route::get('load_retards_datas','Ajax\RetardController@loadDatas');
    Route::post('set_eleve_as_late','Ajax\RetardController@setEleveAsLate');


    /*
     * BULLETIN
     */
    //Admin
    Route::get('load_bulletins_datas_from_admin','Admin\EvaluationController@loadBulletinsDatasFromAdmin');
    //Prof
    Route::get('load_bulletins_datas_from_prof','Prof\EvaluationController@loadBulletinsDatasFromProf');
    Route::get('load_bulletin_of_eleve_from_admin/{eleve_id}/{session_id}','Admin\EvaluationController@loadBulletinOfEleveFromAdmin');
    Route::post('set_appreciation','Admin\EvaluationController@setAppreciation');
    Route::get('load_eleves_notes/{eleve_id}/{session_id}','EvaluationController@loadElevesNotes');

    //EPC
    Route::get('load_datas_for_epc_from_admin','Admin\EvaluationController@loadDatasForEpc');
    Route::get('load_datas_for_epc_from_prof','Prof\EvaluationController@loadDatasForEpc');
    Route::get('load_datas_for_epc_from_parent','Parent\EvaluationController@loadDatasForEpc');
    Route::post('evaluate','EvaluationController@evaluate');
    Route::post('set_conseil_for_eleve','EvaluationController@setConseil');

    //PRINT
    Route::group(['prefix'=>'releve'],function (){
        Route::get('print/classe/module/{classe_id}/{session_id}/{id}','EvaluationController@printClasseModuleReleve');
        Route::get('print/classe/sm/{classe_id}/{session_id}/{id}','EvaluationController@printClasseSMReleve');
        Route::get('print/classe/matiere/{classe_id}/{session_id}/{id}','EvaluationController@printClasseMatiereReleve');
    });

    Route::group(['prefix'=>'epc'],function (){
        Route::get('print/{eleve_id}','EvaluationController@printEpc');
    });

    Route::group(['prefix'=>'bulletin'],function (){
        Route::get('print/{eleve_id}/{session_id}','EvaluationController@printBulletin');
    });

    Route::get('print/eleve_releve/{eleve_id}/{session_id}','EvaluationController@printEleveReleve');


    Route::get('load_cLasse_evals/{classe_id}/{session_id}','AppController@loadClasseEvals');

    /*
     * PLANNING
     */
    // CLASSES
    Route::get('load_planning_for_classes_from_admin','PlanningController@loadPlanningForClassesFromAdmin');
    Route::get('load_classe_horaire/{classe_id}','PlanningController@loadClasseHoraire');
    Route::post('create_cours','PlanningController@createCours');
    Route::put('update_cours/{id}','PlanningController@updateCours');
    Route::get('delete_cours/{id}','PlanningController@deleteCours');
    Route::post('store_cdt','PlanningController@storeCdt');
    Route::put('update_cdt/{id}','PlanningController@updateCdt');

    // PROFS (ken)
    Route::get('load_planning_for_profs_from_admin','PlanningController@loadPlanningForProfsFromAdmin');
    Route::get('load_prof_horaire/{prof_id}','PlanningController@loadProfHoraire');

    /*
     * CLASSES
     */
    Route::get('liste_classes','Admin\ClasseController@liste_classes');


    /*
     * IMPRESSION
     */
    Route::get('print_bulletin_of_eleve/{eleve_id}/{sessionId}/{see}','AppController@printBulettinOfEleve');
//    Route::get('see_bulletin_of_eleve/{eleve_id}/{sessionId}','AppController@seeBulettinOfEleve');



    /**
     *  AJAX ESPACE PARENT
     */
    //Planning elèves
    Route::get('load_planning_for_students_from_parent','Parent\PlanningController@loadPlanningForParents');
    Route::get('load_classe_horaire/{classe_id}','Parent\PlanningController@loadClasseHoraire');

    //Evaluations élèves
    Route::get('load_notes_datas_from_parent','Parent\EvaluationController@loadNotesDatasFromParent');
    Route::get('load_bulletins_datas_from_parent','Parent\EvaluationController@loadBulletinsDatasFromParent');
    Route::get('load_evaluations_parent/{eleve_id}/{matiere_id}/{session_id}','Parent\EvaluationController@loadEvaluations');

    Route::get('load_evaluations_for_eleve/{eleve_id}/{session_id}/{matiere_id}','Parent\EvaluationController@loadEvaluationsForEleve');
    Route::get('load_evaluations_of_mod_for_eleve/{eleve_id}/{session_id}/{module_id}','Parent\EvaluationController@loadEvaluationsOfModForEleve');
    Route::get('load_evaluations_of_sm_for_eleve/{eleve_id}/{session_id}/{sm_id}','Parent\EvaluationController@loadEvaluationsOfSmForEleve');


    /*
     *
     * AJAX ESPACE ELEVE
     */
    Route::get('load_planning_for_eleve','Eleve\PlanningController@loadPlanningForEleve');
    Route::get('load_notes_datas_for_eleve','Eleve\EvaluationController@loadNotesDatasForEleve');

    Route::get('load_evaluations_for_eleve/{matiere_id}/{session_id}','Eleve\EvaluationController@loadEvaluations');

    Route::put('update_settingUser','Admin\AccountController@update');
    Route::get('load_mail','Admin\AccountController@load_mail');



});

/*
 * Tout les liens auth
 *
 */

Route::group(['middleware'=>'auth'],function(){

    Route::get('conseil','BasicController@showConseilPage')->name('conseil');
    Route::get('retards','BasicController@showRetardsPages')->name('retards');
    Route::get('absences','BasicController@showAbsencesPages')->name('absences');

    /*
     * Tous les lien relatif à l'Espace Admin
     *
     * prefix=>admin = page bloqued // already use by voyager
     */
    Route::group(['as'=>'admin.'],function (){

        Route::get('account','Admin\AccountController@index')->name('accountsetting');
        Route::get('Blog','Admin\BlogController@index')->name('blog');

        Route::group(['prefix'=>"evaluations",'as'=>'evaluations.'],function(){
            Route::get('notes','Admin\EvaluationController@showNotesPage')->name('notes');
            Route::get('epc','Admin\EvaluationController@showEpcPage')->name('epc');
            Route::get('releves','Admin\EvaluationController@showRelevesPage')->name('releves');
            Route::get('bulletins','Admin\EvaluationController@showBulletinsPage')->name('bulletins');
        });

        Route::group(['prefix'=>'planning','as'=>'planning.'],function(){
            Route::get('classes',"Admin\PlanningController@showClassePage")->name('classes');
            Route::get('profs',"Admin\PlanningController@showProfPage")->name('profs');
            Route::get('salles',"Admin\PlanningController@showSallePage")->name('salles');
        });

        Route::get('classes','Admin\ClasseController@liste')->name('classes');
        Route::get('matieres','Admin\MatiereController@index')->name('matieres.index');
        Route::get('eleves','Admin\EleveController@index')->name('eleves.index');
        Route::get('informations','Admin\InformationController@index')->name('informations.index');
        Route::get('responsables','Admin\ResponsableController@index')->name('responsables.index');
        Route::get('Personnels','Admin\PersonnelController@index')->name('personnels.index');

    });
    /*
     * Tous les lien relatif à l'Espace Prof
     */
    Route::group(['prefix'=>'prof', 'as'=>'prof.'],function (){
        /*Route::group(['prefix'=>"evaluations",'as'=>'evaluations.'],function(){
            Route::get('notes','Prof\EvaluationController@showNotesPage')->name('notes');
            Route::get('compos','Prof\EvaluationController@showComposPage')->name('compos');
            Route::get('releves','Prof\EvaluationController@showRelevesPage')->name('releves');
            Route::get('bulletins','Prof\EvaluationController@showBulletinsPage')->name('bulletins');
        });*/

        Route::group(['prefix'=>"evaluations",'as'=>'evaluations.'],function(){
            Route::get('notes','Prof\EvaluationController@showNotesPage')->name('notes');
            Route::get('epc','Prof\EvaluationController@showEpcPage')->name('epc');
            Route::get('releves','Prof\EvaluationController@showRelevesPage')->name('releves');
            Route::get('bulletins','Prof\EvaluationController@showBulletinsPage')->name('bulletins');
        });

        Route::group(['prefix'=>'planning','as'=>'planning'],function(){
            Route::get('classe',"Prof\PlanningController@showClassePlanningPage")->name('classe');
            Route::get('prof',"Prof\PlanningController@showProfPlanningPage")->name('prof');
        });
    });
    /*
     * Tous les lien relatif à l'Espace Parent
     */
    Route::group(['prefix'=>'parent', 'as'=>'parent.'],function (){
        Route::get('planning','Parent\PlanningController@showPlanningPage')->name('planning');
        Route::get('evaluations','Parent\EvaluationController@showEvaluationPage')->name('evaluations');

        //Evaluations

        Route::group(['prefix'=>"evaluations",'as'=>'evaluations.'],function(){
            Route::get('notes','Parent\EvaluationController@showNotesPage')->name('notes');
            Route::get('epc','Parent\EvaluationController@showEpcPage')->name('epc');
            Route::get('releves','Parent\EvaluationController@showRelevesPage')->name('releves');
            Route::get('bulletins','Parent\EvaluationController@showBulletinsPage')->name('bulletins');
        });

        //Evaluations
        Route::group(['prefix'=>"evaluations",'as'=>'evaluations.'],function(){
            Route::get('notes','Parent\EvaluationController@showNotesPage')->name('notes');
            Route::get('compos','Parent\EvaluationController@showComposPage')->name('compos');
            Route::get('releves','Parent\EvaluationController@showRelevesPage')->name('releves');
            Route::get('bulletins','Parent\EvaluationController@showBulletinsPage')->name('bulletins');
        });
    });


    /*
     * Tous les lien relatif à l'Espace Elève
     */
    Route::group(['prefix'=>'eleve', 'as'=>'eleve.'],function (){
        Route::get('planning','Eleve\PlanningController@showPlanningPage')->name('planning');
        Route::get('evaluations','Eleve\EvaluationController@showEvaluationPage')->name('evaluations');

        //Evaluations
        Route::group(['prefix'=>"evaluations",'as'=>'evaluations.'],function(){
            Route::get('notes','Eleve\EvaluationController@showNotesPage')->name('notes');
//            Route::get('compos','Parent\EvaluationController@showComposPage')->name('compos');
            Route::get('releves','Eleve\EvaluationController@showRelevesPage')->name('releves');
            Route::get('bulletins','Eleve\EvaluationController@showBulletinsPage')->name('bulletins');
        });
    });



    /*
     * Impressions
     */

    Route::get('print_bulletin_of_eleve/{eleve_id}/{sessionId}','AppController@printBulettinOfEleve');
});