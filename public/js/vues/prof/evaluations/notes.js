/**
 * Created by User on 22/11/2018.
 */

import {url} from '../../../base_url.js'
//        alert(baseUrl)
let instance = axios.create({
    baseURL : url
});

const add = (a,b) => a+b;

let notes = {
    template: "#notes",
    data(){
        return {
            classes:[],
            eleves:[],
            evs:[
                {
                    nom:"Farid",
                    evaluations:[{
                        pivot:{
                            note: 20
                        }
                    }]
                },
            ],
            matieres:[],
            sousMatieres:[],
            modules:[],
            sessions:[],
            inters:[],
            appreciations:[],
            selectedClasseId: null,
            selectedSousMatiereId: null,
            selectedModuleId: null,
            selectedMatiereId: null,
            selectedSessionId: null,
            selectedClasse: {
                eleves:[]
            },
            selectedMatiere: {},
            selectedSousMatiere: {},
            selectedModule: {},
            selectedSession: {},
            evals:[],
            evaluations:[],
            selectedEval:{
                id:0,
                date: "",
                notation:0,
                coef:0,
                commentaire:"",
                session_id: this.selectedSessionId,
                classe_id:this.selectedClasseId,
                matiere_id:this.selectedMatiereId,
            },
            evaluation:{
                date: "",
                notation:10,
                coef:1,
                commentaire:"",
                session_id: this.selectedSessionId,
                classe_id:this.selectedClasseId,
                matiere_id:this.selectedMatiereId,
                sous_matiere_id:this.selectedSousMatiereId,
                module_id:this.selectedModuleId
            },
            readyToPair: false,
            link:"",
            basePintLink: url+"releve/print/classe/",
            showInput:false,
            showApprInput:false,
            clickedEvaluationColumn:{},
        }
    },
    mounted(){
        // $('#mainTable').editableTableWidget().find('td:first').focus();
        this.loadDatas()
        this.initView()
        moment.locale('fr')
    },
    watch:{
        selectedClasseId(value){
//                    this.matieres = []
        },
        ready(value){
            if(this.ready){
//                      this.evals = this.evaluation.filter(it => it.classe_id == this.selectedClasseId && it.matiere_id == this.selectedMatiereId && it.session_id == this.selectedSessionId)
//                      alert(this.readyToPair)
//                      console.log(this.evals)
//                      this.loadEvaluations();

            }else {
                this.evals = []
//                      alert(this.readyToPair)
            }
        }
    },
    computed:{
        ready(){
            // console.log(this.selectedClasseId)
            // console.log(this.selectedMatiereId)
            // console.log(this.selectedSessionId)
//                  alert("ready")
//                  this.readyToPair = this.selectedClasseId != null && this.selectedMatiereId!=null && this.selectedSessionId!=null;
            if (this.selectedClasseId != null){
                if(this.selectedMatiereId!=null){
                    if(this.selectedMatiere.sous_matieres.length != 0){
                        if(this.selectedSousMatiereId!=null){
//                                  this.selectedSousMatiere = this.sousMatieres.filter(it=>it.id == this.selectedSousMatiereId)[0]
                            if(this.selectedSousMatiere.modules && this.selectedSousMatiere.modules.length !=0){
                                if(this.selectedModuleId!=null){
                                    if(this.selectedSessionId!=null){
//                                              this.readyToPair = true
                                        this.evals = []
                                        // this.loadEvaluations()
//                                              alert()
                                        return true
                                    }
                                }
                            }else {
                                if(this.selectedSessionId!=null){
//                                          this.readyToPair = true
                                    this.evals = []
                                    // this.loadEvaluations()
//                                          alert()
                                    return true
                                }
                            }
                        }
                    }else {
                        if(this.selectedSessionId!=null){
//                                  this.readyToPair = true
                            this.evals = []
                            // this.loadEvaluations()
//                                  alert()
                            return true
                        }
                    }
                }
            }
            return false
//                  return this.selectedClasseId != null && this.selectedMatiereId!=null && this.selectedSessionId!=null;
        },
        hasSousMatiere(){
            return this.sousMatieres.length!=0
        },
        hasModule(){
            return this.modules.length != 0
        }
    },
    methods:{
        closeAllInputs(){
            this.clickedEvaluationColumn = {}
            this.showApprInput = false
        },
        showAppreciationInput(){
            this.showApprInput = true
        },
        apprBlur(e){
            // var appreciation = prompt("Entrer l'appréciation")
            // alert(e.appreciations[0].appreciation);
            // e.appreciations[0].appreciation = appr
            instance.post('set_appreciation',e.appreciations[0]).then(res=>{
                console.log(res.data)
                e.appreciations[0].appreciation = res.data
                $.gritter.add({
                    title:"Appréciation prise en compte ave success",
                    time:1000,
                    text:"",
                    class_name:"colo success"
                })
            }).catch(err=>{
                console.log(err.response.data)
                // alert("Appréciation non enrégistrée: Veuillez saisir de nouveau SVP.")
                e.appreciations[0].appreciation = ""
                $.gritter.add({
                    title:"Appréciation non enrégistrée",
                    time:1000,
                    text:"Veuillez saisir de nouveau SVP.",
                    class_name:"colo success"
                })
            })
        },
        moment(date,format=""){
            return new moment(date).format(format)
        },
        getMoment(date){
            return new moment(date).format('YYYY-MM-DD')
        },

        eleveFocus(eleve){
            /*$.gritter.add({
             title:"Modification",
             time:2000,
             text:"Note enrégistrée avec Success.",
             class_name:"color success"
             });*/
        },
        showNoteInput(ev){
            return this.clickedEvaluationColumn.id == ev.id;
        },
        showNoteInput(ev){
            return this.clickedEvaluationColumn.id == ev.id;
        },

        noteFocus(ev){
            this.clickedEvaluationColumn = ev
        },
        _noteFocus(e){
            // console.log(e.pivot.id)
            var note = prompt("Entrer la note")
            note = parseFloat(note)
            // console.log(isNaN(note))
            if(!isNaN(note)){
                console.log("ISNAN",isNaN(note));
                if (note>e.notation){
                    alert("La note entrée est supérieure à la notation maximale pour cette évaluation")
//                            alert("Note trop élevée")
                }else if(note<0){
                    alert("Note non valide. Veuillez saisir une note valide")
                }
                else {
                    e.pivot.note = note
                    instance.post('update_note',e.pivot).then(res=>{
                        // console.log("note response",res.data)
                        e.pivot.note = res.data.note.toFixed(2)
                    }).catch(err=>{
                        alert("Note non enrégistrée: Veuillez saisir de nouveau SVP.")
                        console.log(err.response.data)
                        e.pivot.note = "-"
                    })
                }
            }else {
                e.pivot.note = ""
                instance.post('update_note',e.pivot).then(res=>{
                    // console.log("note response",res.data)
                    e.pivot.note = res.data.note
                }).catch(err=>{
                    alert("Note non enrégistrée: Veuillez saisir de nouveau SVP.")
                    console.log(err.response.data)
                    e.pivot.note = "-"
                })

            }
//                  console.log(typeof pivot.note)
        },
        noteBlur(el,e){
            // this.clickedEvaluationColumn = {}
            // alert(note)
            let note = e.pivot.note
            if (isNaN(note) || note == null){
                if(confirm("Format incorrect.Voulez-vous supprimer cette note ?")){
                    e.pivot.note = ""
                    instance.post('update_note',e.pivot).then(res=>{
                        // console.log("note response",res.data)
                        e.pivot.note = res.data.note
                        $.gritter.add({
                            title:"Modification",
                            time:2000,
                            text:"Note supprimée avec Success.",
                            class_name:"color success"
                        });
                    }).catch(err=>{
                        console.log(err.response.data)
                        e.pivot.note = ""
                        $.gritter.add({
                            title:"Erreur",
                            time:4000,
                            text:"Veuillez saisir la note de nouveau pou l'élève "+el.nom_complet,
                            class_name:"color danger"
                        });
                    })
                }
            }
            else {
                if (note>10){
                    alert("La note entrée est supérieure à la notation maximale pour cette matière")
                    e.pivot.note = ""
//                            alert("Note trop élevée")
                }
                else if(note<0){
                    alert("Note non valide. Veuillez saisir une note valide")
                    e.pivot.note=""
                }
                else {
                    instance.post('update_note',e.pivot).then(res=>{
                        $.gritter.add({
                            title:"Modification",
                            time:2000,
                            text:"Note enrégistrée avec Success pour l'élève "+el.nom_complet,
                            class_name:"color success"
                        });
                        // console.log("note response",res.data)
                    }).catch(err=>{
                        // alert()
                        // e.pivot.note = ""
                        $.gritter.add({
                            title:"Erreur",
                            time:4000,
                            text:"Veuillez saisir de nouveau la de l'élève "+el.nom_complet,
                            class_name:"color danger"
                        });
                        console.log(err.response.data)
                    })
                }
            }
        },

        initView(){
            $('#select2-classe')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    this.selectedClasseId = $('#select2-classe').val()
                    this.classeChange($('#select2-classe').val())
                });
            $('#select2-matiere')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',()=> {
                    // alert(this.value)
                    this.selectedMatiereId = $('#select2-matiere').val()
                    this.matiereChange($('#select2-matiere').val())
                    if(this.ready){
                        this.loadEvaluations()
                    }
                });
            $('#select2-sm')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',()=> {
                    // alert(this.value)
                    this.selectedSousMatiereId = $('#select2-sm').val()
                    this.smChange($('#select2-sm').val())
                    if(this.ready){
                        this.loadEvaluations()
                    }
                });
            $('#select2-mod')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',()=> {
                    // alert(this.value)
                    this.selectedModuleId = $('#select2-mod').val()
                    this.moduleChange($('#select2-mod').val())
                    if(this.ready){
                        this.loadEvaluations()
                    }
                });

            $('#select2-session')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change', ()=> {
                    // alert(this.value)
                    this.selectedSessionId = $('#select2-session').val()
                    this.sessionChange($('#select2-session').val())
                    if(this.ready){
                        this.loadEvaluations()
                    }
                });

        },
        reload(){
            this.loadDatas()
        },
        loadDatas(){
            instance.get('load_notes_datas_from_prof').then(res=>{
                console.log(res.data)
                this.classes = res.data.classes
                this.sessions = res.data.sessions
                this.inters = res.data.interventions
            }).catch(err=>{
                console.log(err.response.data)
            })
        },

        classeChange(classeId){
            // alert(new_id)
            this.matieres = []
            this.sousMatieres = []
            this.modules = []
            this.selectedMatiereId = null
            this.selectedSousMatiereId = null
            this.selectedModuleId= null
            this.selectedMatiere = {}
            this.selectedSousMatiere = {}
            this.selectedModule= {}

            this.evaluation.matiere_id = null
            this.evaluation.sous_matiere_id = null
            this.evaluation.module_id = null

            this.evaluation.classe_id = classeId;
            this.selectedClasse = this.classes.find(it=>it.id==classeId);

            let intervs = this.inters.find(it=>it.classe.id == this.selectedClasseId);
            intervs.matieres.forEach(i=>{
//                        alert(i.matiere.intitule)
//                        console.log(i.matiere.sous_matieres.length)
                this.matieres.push(i)
            })

            this.reloadMatiereSelector()
        },
        reInit(){
            this.currentMatiere = []
            this.currentMatiereId = null
            // this.currentEvaluations = [];
        },
        matiereChange(matId){
            this.sousMatieres = []
            this.modules = []
            this.selectedSousMatiereId = null
            this.selectedModuleId= null
            this.selectedSousMatiere = {}
            this.selectedModule= {}
            this.evaluation.matiere_id = matId
            this.evaluation.sous_matiere_id = null
            this.evaluation.module_id = null
            this.selectedMatiere = this.matieres.filter(it=>it.id == matId)[0]
            if(this.selectedMatiere && this.selectedMatiere.sous_matieres.lenth != 0){
                this.selectedMatiere.sous_matieres.forEach(sm=>{
//                            console.log(sm)
                    this.sousMatieres.push(sm)
                })
            }else {

            }

            this.reloadSMSelector()
            this.reloadModuleSelector()

        },
        smChange(smId){
            this.modules = []
            this.selectedModuleId= null
            this.selectedModuleId= null
            this.selectedModule= {}
            // this.evaluation.sous_matiere_id = this.selectedSousMatiereId
            this.evaluation.module_id = null
            this.evaluation.sous_matiere_id = smId

            this.selectedSousMatiere = this.sousMatieres.filter(it=>it.id == smId)[0]
            if(this.selectedSousMatiere && this.selectedSousMatiere.modules.length !=0){
                this.selectedSousMatiere.modules.forEach(mod=> this.modules.push(mod))
            }

            this.reloadModuleSelector()
        },
        moduleChange(modId){
            // this.evaluation.module_id = this.selectedModuleId
            this.evaluation.module_id = modId
            this.selectedModule = this.modules.filter(it=>it.id==modId)[0]
        },
        sessionChange(sId){
            this.selectedSession = this.sessions.filter(it=>it.id == sId)[0]
            this.evaluation.session_id = this.selectedSession.id
        },


        reloadMatiereSelector(){
            let options = [{
                id:"null",
                text:"Selectionner une matière",
                disabled:true,
                selected:true
            }]
            this.matieres.forEach(m=>{
                options.push({
                    id:m.id,
                    text:m.intitule
                })
            })
            $('#select2-matiere').empty()
            $('#select2-sm').empty()
            $('#select2-mod').empty()
            $('#select2-matiere').select2({
                    data:options
                }

            )
        },
        reloadSMSelector(){
            let options = [{
                id:"null",
                text:"Selectionner une sous-matière",
                disabled:true,
                selected:true
            }]
            this.sousMatieres.forEach(m=>{
                options.push({
                    id:m.id,
                    text:m.nom
                })
            })
            $('#select2-sm').empty()
            $('#select2-sm').select2({
                    data:options
                }

            )
        },
        reloadModuleSelector(){
            let options = [{
                id:"null",
                text:"Selectionner un module",
                disabled:true,
                selected:true
            }]
            this.modules.forEach(m=>{
                options.push({
                    id:m.id,
                    text:m.nom
                })
            })
            $('#select2-mod').empty()
            $('#select2-mod').select2({
                    data:options
                }

            )
        },

        moment(date){
            return new moment(date).locale('fr')
        } ,
        eleveReleveLink(eleve){
            return url+"print/eleve_releve/"+eleve.id+"/"+this.selectedSession.id
        },
        moyCalc(evals){
            let total = 0
            let moyenne = 0
            let offEval = 0
            evals.forEach(e=>{
                if(!e.pivot.note){
                    offEval+=1
                }else {
                    total = parseFloat(total) + parseFloat(e.pivot.note)
                }
            })
            moyenne = total/(evals.length-offEval)
            // console.log("total",total)
            // console.log("evals",evals.length)
            return moyenne.toFixed(2);

            /*

             //                    console.log(evals)
             if(evals.length == 1){
             return evals[0].pivot.note
             }else if(evals.length == 2){
             /!*evals.forEach((e,i)=>{
             console.log(i+"pivot",e.pivot)
             console.log(i+"note",e.pivot.note)
             })*!/
             let t = evals.reduce(function(a,b){
             return parseFloat(a.pivot.note).toFixed(2)+parseFloat(b.pivot.note).toFixed(2)
             })
             let moy = t/evals.length
             return moy
             }else if (evals.length > 2){
             let moy = 0;
             let sum = 0;
             evals.forEach(e=>{
             sum+=parseFloat(e.pivot.note)
             })

             return parseFloat(sum/evals.length).toFixed(2)
             }*/

        },
        loadEvaluations(){
            $('#loader').modal('show')
            // alert('yeah loading evals')
//                    alert(this.selectedSousMatiereId)
            this.link = this.basePintLink+"module/"+this.selectedClasseId+"/"+this.selectedSessionId+"/"+this.selectedModuleId
            this.evals = []
            this.eleves = []
            if(this.selectedModuleId){
                instance.get('load_evaluations_of_mod/'+this.selectedClasseId+"/"+this.selectedSessionId+"/"+this.selectedModuleId)
                    .then(res=>{
                        $('#loader').modal('hide')
                        console.log(res.data)
                        this.evals = res.data.evals
                        /*this.evals.forEach(e=>{
                         console.log(e)
                         this.evs.push(e)
                         })*/
                        this.eleves = res.data.eleves

                        // this.appreciations = res.data.appreciations
//                            console.log(this.evals)
//                            console.log(this.evs)

                    }).catch(err=>{
                    $('#loader').modal('hide')
                    console.log(err.response.data)
                })
            }else if(this.selectedSousMatiereId && this.selectedSousMatiereId!=0){
                this.link = this.basePintLink+"sm/"+this.selectedClasseId+"/"+this.selectedSessionId+"/"+this.selectedSousMatiereId
                instance.get('load_evaluations_of_sm/'+this.selectedClasseId+"/"+this.selectedSessionId+"/"+this.selectedSousMatiereId)
                    .then(res=>{
                        $('#loader').modal('hide')
                        console.log(res.data)
                        this.evals = res.data.evals
                        /*this.evals.forEach(e=>{
                         console.log(e)
                         this.evs.push(e)
                         })*/
                        this.eleves = res.data.eleves
                        /*this.eleves.forEach(e=>{
                         console.log(e.appreciations)
                         })*/
//                            console.log(this.evals)
//                            console.log(this.evs)
//                         this.appreciations = res.data.appreciations

                    }).catch(err=>{
                    $('#loader').modal('hide')
                    console.log(err.response.data)
                })
            }else {
                this.link = this.basePintLink+"matiere/"+this.selectedClasseId+"/"+this.selectedSessionId+"/"+this.selectedMatiereId
                instance.get('load_evaluations/'+this.selectedClasseId+"/"+this.selectedSessionId+"/"+this.selectedMatiereId)
                    .then(res=>{
                        $('#loader').modal('hide')
                        console.log(res.data)
                        this.evals = res.data.evals
                        /*this.evals.forEach(e=>{
                         console.log(e)
                         this.evs.push(e)
                         })*/
                        this.eleves = res.data.eleves
//                            console.log(this.evals)
//                            console.log(this.evs)
//                         this.appreciations = res.data.appreciations

                    }).catch(err=>{
                    $('#loader').modal('hide')
                    console.log(err.response.data)
                })
            }


        },

        appreciationFocus(){
            this.showApprInput = true
        },
        selectEval(e){
//                    console.log(e)
            this.selectedEval.id = e.id
            this.selectedEval.date = e.date,
                this.selectedEval.notation = e.notation,
                this.selectedEval.coef = e.coef,
                this.selectedEval.commentaire = e.commentaire
//                    console.log(this.selectedEval)
            $('#update-modal').modal('show')
        },

        updateEvaluation(){
            instance.put('update_evaluation/'+this.selectedEval.id,this.selectedEval)
                .then(res=>{
//                            console.log(res.data)
                    this.loadEvaluations()
                }).catch(err=>{
                console.log(err.response.data)
            })
        },
        deleteEvaluation(){
            instance.get('delete_evaluation/'+this.selectedEval.id).then(res=>{
                console.log(res.data)
                this.loadEvaluations()
            })
                .catch(err=>{
                    console.log(err.response.data)
                })
        },
        showEvaluationCreateModal(){
            $('#create-modal').modal('show')
        },
        createEvaluation(){

//                    console.log("matiere",this.evaluation.matiere_id)
//                    console.log("sous",this.evaluation.sous_matiere_id)
//                    console.log("module",this.evaluation.module_id)
//                    console.log("sess",this.evaluation.session_id)
            if (this.evaluation.date == ""){
                this.evaluation.date = new moment().format('YYYY-MM-DD')
//                        console.log(this.evaluation.date)
//                        alert("Veuillez selectionner la date")
                console.log("this.evaluation.matiere_id",this.evaluation.matiere_id)
                console.log("this.evaluation.sm",this.evaluation.sous_matiere_id)
                console.log("this.evaluation.matiere_id",this.evaluation.module_id)
                instance.post('create_evaluation',this.evaluation).then(res=>{
//                        console.log(res.data)
                    this.loadEvaluations()
                }).catch(err=>{
                    console.log(err.response.data)
                })
            }else {
                instance.post('create_evaluation',this.evaluation).then(res=>{
//                        console.log(res.data)
                    this.loadEvaluations()
                }).catch(err=>{
                    console.log(err.response.data)
                })
            }

        },

    }
};

let vm = new Vue({
    el:'#app',
    data:{},
    mounted(){
        // alert(0)
    },
    methods:{},
    components:{
        notes
    }
})
