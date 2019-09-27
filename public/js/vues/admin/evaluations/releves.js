/**
 * Created by User on 22/11/2018.
 */

import {url} from '../../../base_url.js'
//        alert(baseUrl)
let instance = axios.create({
    baseURL : url
});


let releve = {
    template: "#releve",
    data(){
        return {
            classes:[],
            matieres:[],
            sessions:[],
            types:[],
            eleves:[],
            evaluations:[],
            currentClasse:{},
            currentMatiere:{},
            currentSession:{},
            selectedEvaluation:{},
            currentClasseId:null,
            currentMatiereId:null,
            currentSessionId:null,
            selectedTypeId:1,
            newEvaluation:{
                take:1,
                commentaire:"",
                date: "",
                notation:20,
                // coef:2,
                session_id: 0,
                classe_id:0,
                matiere_id:0,
                type_id:1
            }
        }
    },
    mounted(){
        // $('#mainTable').editableTableWidget().find('td:first').focus();
        this.loadDatas()
        this.initView()
    },
    computed:{
        isReady(){
            let bool = this.currentClasseId !=null && this.currentMatiereId!=null && this.currentSessionId!=null
            if(bool){
                this.loadEvaluations()
                return true
            }
            return false
        },
    },
    methods:{
        getTypeLabelColor(type){
          return "label-"+type.bootstrap
        },
        taken(e){
          if(e.take){
              return "success"
          }
        },
        getType(e){
            // console.log(e.type)
            return e.type.nom
        },

        eleveFocus(eleve){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Echec de suppression',
                // (string | mandatory) the text inside the notification
                text: "Une erreur s'est produite lors de la suppression.",
                class_name: 'danger',
                time: 3000,
                position: 'top-right',
                sticky: false
            });
        },
        noteClick(eleve,e){
          // alert(eleve.nom)
          // alert(pivot.note)

            var note = prompt("Entrez la note : "+eleve.nom_complet)

            if(isNaN(note) || !note){
                console.log("ISNAN",isNaN(note));
                if(confirm("Format incorrect.Voulez-vous supprimer cette note ?")){
                    e.pivot.note = ""
                    instance.post('update_note',e.pivot).then(res=>{
                        // console.log("note response",res.data)
                        e.pivot.note = res.data.note
                    }).catch(err=>{
                        console.log(err.response.data)
                    })
                }else {

                }
            }else {
                if (note>20){
                    alert("La note entrée est supérieure à la notation maximale pour cette évaluation")
//                            alert("Note trop élevée")
                }else if(note<0){
                    alert("Note non valide. Veuillez saisir une note valide")
                }
                else {
                    e.pivot.note = note
                    instance.post('update_note',e.pivot).then(res=>{
                        console.log("note response",res.data)
                        e.pivot.note = res.data.note.toFixed(2)
                    }).catch(err=>{
                        console.log(err.response.data)
                        $.gritter.add({
                            // (string | mandatory) the heading of the notification
                            title: 'Echec de suppression',
                            // (string | mandatory) the text inside the notification
                            text: "Une erreur s'est produite lors de la suppression.",
                            class_name: 'danger',
                            time: 3000,
                            sticky: false
                        });
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
                    this.onClasseChange($('#select2-classe').val())
                });
            $('#select2-matiere')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',()=> {
                    // alert(this.value)
                    this.onMatiereChange($('#select2-matiere').val())
                });
            $('#select2-session')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change', ()=> {
                    // alert(this.value)
                    this.onSessionChange($('#select2-session').val())
                });

        },
        reload(){
          this.loadDatas()
        },
        loadDatas(){
            instance.get('load_releves_datas_from_admin').then(res=>{
                console.log(res.data)
                this.classes = res.data.classes
                this.sessions = res.data.sessions
            }).catch(err=>{
                console.log(err.response.data)
            })
        },

        loadEvaluations(){
            instance.get('load_evaluations/'+this.currentClasseId+'/'+this.currentMatiereId+'/'+this.currentSessionId).then(res=>{
                console.log(res.data)
                this.eleves = res.data.eleves
                this.evaluations = res.data.evaluations
            }).catch(err=>{
                console.log(err.response.data)
            })
        },

        onClasseChange(classeId){
            // alert(new_id)
            this.currentClasseId = classeId
            this.currentClasse = this.classes.filter(it=>it.id==classeId)[0]
            this.eleves = this.currentClasse.eleves
            // alert(classe.nom)
            this.matieres = this.currentClasse.niveau.matieres
            // console.log(this.matieres)
            this.reInit()
            this.reloadMatiereSelector()
        },
        eleveReleveLink(eleve){
            return url+"print/eleve_releve/"+eleve.id+"/"+this.currentSessionId
        },
        reInit(){
            this.currentMatiere = []
            this.currentMatiereId = null
            // this.currentEvaluations = [];
        },
        onMatiereChange(matId){
            // alert(matId)
            this.currentMatiereId = matId
            this.currentMatiere = this.matieres.filter(it=>it.id==matId)[0]
        },
        onSessionChange(sessionId){
            this.currentSessionId = sessionId
            this.currentSession = this.sessions.filter(it=>it.id==sessionId)[0]
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
            $('#select2-matiere').select2({
                data:options
                }

            )
        },
        showEvaluationUpdateModal(evaluation){
            this.selectedEvaluation = evaluation
            $('#update-modal').modal('show')
        },
        showEvaluationCreateModal(){
            this.newEvaluation.classe_id = this.currentClasseId
            this.newEvaluation.matiere_id = this.currentMatiereId
            this.newEvaluation.session_id = this.currentSessionId
            // this.newEvaluation.type_id = 1
            // alert(this.newEvaluation.matiere_id)
            // alert(this.currentMatiere.id)
            $('#create-modal').modal('show')
        },
        createEvaluation(){
            instance.post('create_evaluation',this.newEvaluation).then(res=>{
                console.log(res.data)
                this.loadEvaluations()
                // this.newEvaluation = {}
            }).catch(err=>{
                console.log(err.response.data)
            })
        },
        deleteEvaluation(){
            instance.get('delete_evaluation/'+this.selectedEvaluation.id).then(res=>{
             console.log(res.data)
             this.selectedEvaluation = {}
             this.loadEvaluations()
             })
             .catch(err=>{
             console.log(err.response.data)
             })
        },
        updateEvaluation(){
            instance.put('update_evaluation/'+this.selectedEvaluation.id,this.selectedEvaluation).then(res=>{
                console.log(res.data)
                this.selectedEvaluation = {}
                this.loadEvaluations()
            })
                .catch(err=>{
                    console.log(err.response.data)
                })
        }
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
        releve
    }
})
