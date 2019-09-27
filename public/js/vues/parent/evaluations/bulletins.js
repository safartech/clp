/**
 * Created by User on 22/11/2018.
 */
import { url } from '../../../base_url.js'
let instance = axios.create({
    baseURL: url
})


let bulletins = {
    template: "#bulletins",
    data(){
        return {
            counter: 0,
            selectedSession:{},
            eleves:[],
            datas:[],
            interventions:[],
            classes:[],
            classe:{},
            eleve:{},
            matieres:[],
            matiere:{
                // evaluations:[]
            },
            modules:[],
            sm:{modules:[]},
            current_sm:{},
            firstModule:{},
            otherModules:[],
            sessions : [],
            currentSession:{},
            selectedEleveId: 0,
            selectedSessionId: 0,
            evals:[],
            moysEleve: [],
            moysClasse: [],
            moyenne_de_la_classe:0,

            selectedClasse:{},
            selectedEleve:{},
            conduites:[],
            obs:{},
            abs:{},
            showApprInput:false,
            newConseil:{
                eleve_id:0,
                session_id:0,
                attention:"",
                participation:"",
                rithme:"",
                ecriture:null,
                autonomie:"",
                og:"",
                absences:null,
            },
            selectedEleveConseil:{},
            conseils:[]
        }
    },
    mounted(){
        this.loadDatas()
        this.initView()
    },
    computed:{
        bullLink(){
            // alert(this.eleve.id)
            return url+"bulletin/print/"+this.selectedEleveId+"/"+this.selectedSessionId
        },

        showBulletin(){
            if(this.selectedEleve.id!=null && this.selectedSession.id!=null){
                this.loadNotes()
                return true
            }
            return false
        },

        showElevesList(){
            return this.selectedClasse!=null && this.selectedSession!=null
        }


        /*seeLink(){
            return url+"see_bulletin_of_eleve/"+this.selectedEleveId+"/"+this.selectedSessionId
        },*/



    },
    watch:{

    },
    methods:{

        printLink(see){
            // return url+"print_bulletin_of_eleve/"+this.selectedEleveId+"/"+this.selectedSessionId+"/"+see
        },
        isSelected(eleve){
            return this.selectedEleve==eleve?"primary":""
        },

        reload(){
          this.loadDatas()
        },
        initView(){
            $('#select2-classe')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    // alert($('#select2-classe').val())
                    this.onClasseChange($('#select2-classe').val())
                });

            $('#select2-session')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    // alert($('#select2-session').val())
                    this.onSessionChange($('#select2-session').val())
                });
            $('#select2-eleve')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    // alert($('#select2-classe').val())
                    this.onEleveChange($('#select2-eleve').val())
                });



        },
        loadDatas(){
            instance.get('load_bulletins_datas_from_parent').then(res=>{
                // console.log(res.data.classes)
                this.eleves = res.data.eleves
                this.sessions = res.data.sessions
            }).catch(err=>{
                console.log(err.response.data)

            })
        },

        eleveClick(eleve){
            console.log(eleve.id)
            this.evals = []
            this.selectedEleve = eleve
            this.eleve = eleve
            // alert(this.currentSessionId)
            // this.loadNotes()

        },

        loadNotes(){
            instance.get('load_eleves_notes/'+this.selectedEleve.id+"/"+this.selectedSessionId).then(res=>{
                console.log("00",res.data.abs)
                this.matieres = res.data.matieres
                this.conduites = res.data.conduites
                this.obs = res.data.obs;
                // if (res.data.abs!=null)
                this.abs = res.data.abs
                this.conseils = res.data.conseils
            }).catch(err=>{
                console.log(err.response.data)
            })
        },

        showConseilSetter(){
            // console.log(this.selectedEleveConseil)
            // this.selectedEleve = eleve
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c){
                this.selectedEleveConseil = c
            }else {
                this.selectedEleveConseil = this.newConseil
            }

            $('#conseil-modal').modal('show')
        },
        getRythme(){
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c){
                return c.rythme
            }
        },
        getPresentation(){
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c) return c.presentation
        },
        getAutonomie(){
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c) return c.autonomie
        },
        getAttention(){
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c) return c.attention
        },
        getParticipation(){
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c) return c.participation
        },
        getOg(){
            let c = this.conseils.find(x=>x.eleve_id==this.selectedEleve.id && x.session_id==this.selectedSession.id)
            if(c) return c.og
        },

        getEleveName(){
            if (this.selectedEleve!=null){
                return this.selectedEleve.nom_complet
            }
        },

        onSessionChange(sessionId){
            this.selectedSession = this.sessions.find(x=>x.id==sessionId)
            this.selectedSessionId = sessionId
            if (this.showBulletin){
                // this.loadBulletin()
            }
        },

        validate(){
            // console.log(this.selectedEleveConseil)
            this.selectedEleveConseil.eleve_id = this.selectedEleve.id
            this.selectedEleveConseil.session_id = this.selectedSession.id
            instance.post('set_conseil_for_eleve',this.selectedEleveConseil).then(res=>{
                console.log(res.data)
            }).catch(err=>{
                console.log(err.response.data)
            })
            this.selectedEleveConseil = {}
        },

        onClasseChange(classeId){
            this.selectedClasse = this.classes.find(x=>x.id==classeId)
            this.selectedClasseId = classeId
            // alert(this.classe.nom)
            this.eleves = this.selectedClasse.eleves
            this.reloadEleveSelector()
            // console.log(this.classe)
            // console.log(this.eleves.length)
        },

        conseilModal(){
            $('#conseil-modal').modal('show');
        },

        onEleveChange(eleveId){
            let eleve = this.eleves.find(e=>e.id==eleveId)
            this.selectedEleveId = eleveId
            this.eleveClick(eleve)
        },
        reloadEleveSelector(){
            let options = [{
                id:"null",
                text:"Selectionner un élève",
                disabled:true,
                selected:true
            }]
            this.eleves.forEach(e=>{
                options.push({
                    id:e.id,
                    text:e.nom_complet
                })
            })
            $("#select2-eleve").empty()
            $("#select2-eleve").select2({
                data:options
            })
        },

        hasModule(sm){
            if(sm.modules.length > 0){
                this.current_sm = sm
                this.firstModule = sm.modules[0];
            }else {
                // console.log(this.counter+=1)
            }
            // console.log(sm.modules.length);
            return sm.modules.length > 0;
        },
        hasSousMatiere(matiere){
            // console.log(matiere.intitule,matiere.sous_matieres.length)
            // console.log(matiere.intitule,matiere.sous_matieres.length)
            return matiere.sous_matieres.length > 0
        },
        nombreModules(sm){
            this.modules = sm.modules
            return sm.modules.length
        },

        getMoyBySM(sm){
            // console.log(this.counter+=1)
            // console.log("Sousmatiere",sm.id)
            // console.log("classe",this.classe.id)
            // console.log("session",this.currentSessionId)
            let evalsOfClass = []
            evalsOfClass = sm.evaluations

            if(evalsOfClass.length>0){
                /*this.evals.forEach(e=>{
                 console.log("eval",e.notation)
                 })*/
                // return evals.length
                // return sm.id;
                // console.log(evalsOfClass.length)
                var sum = 0
                var notations = []
                evalsOfClass.forEach(e=>{
                    notations.push(e.notes.find(it=>it.eleve_id == this.eleve.id))
                })
                // console.log(notations)
                var notes = []
                notations.forEach((n)=>{
                    // console.log('note '+i,n.note)
                    if(n && n.note)
                        notes.push(n.note)
                })

                notes.forEach(n=>{
                    sum = parseFloat(sum) + parseFloat(n)
                })
                var moy = sum/notes.length
                if(!isNaN(moy)){
                    // return Math.round(moy)
                    return moy.toFixed(2)
                }/*else {
                 return ""
                 }*/
            }else {
                return "-"
            }



        },
        getMoyByMod(mod){
            let evalsOfClass = []
            evalsOfClass = mod.evaluations
            /*this.evals.forEach(e=>{
             console.log("eval",e.notation)
             })*/
            // return evals.length
            // return sm.id;
            if (evalsOfClass.length>0){
                var sum = 0
                var notations = []
                evalsOfClass.forEach(e=>{
                    notations.push(e.notes.find(it=>it.eleve_id == this.eleve.id))
                })
                var notes = []
                notations.forEach((n,i)=>{
                    // console.log('note '+i,n.note)
                    if(n && n.note)
                        notes.push(n.note)
                })

                notes.forEach(n=>{
                    sum = parseFloat(sum) + parseFloat(n)
                })
                var moy = sum/notes.length
                if(!isNaN(moy)){
                    // return Math.round(moy)
                    return moy.toFixed(2)
                }/*else {
                 return ""
                 }*/
            }else return "-"

        },
        getMoyByMat(matiere){
            // console.log(this.counter+=1,matiere.intitule)
            let evalsOfClass = []
            evalsOfClass = matiere.evaluations.filter(it=>{
                evalsOfClass = matiere.evaluations.filter(it=>it.matiere_id == matiere.id && it.classe_id== this.selectedClasseId && it.session_id == this.selectedSessionId)
            })

            // console.log("LLL",matiere.evaluations.length)

            if (evalsOfClass.length>0){
                /*this.evals.forEach(e=>{
                 console.log("eval",e.notation)
                 })*/
                // return evals.length
                // return sm.id;
                var sum = 0
                var notations = []
                evalsOfClass.forEach(e=>{
                    notations.push(e.notes.find(it=>it.eleve_id == this.eleve.id))
                })
                var notes = []
                notations.forEach((n,i)=>{
                    // console.log('note '+i,n.note)
                    if(n && n.note)
                        notes.push(n.note)
                })

                notes.forEach(n=>{
                    sum = parseFloat(sum) + parseFloat(n)
                })
                var moy = sum/notes.length
                if(!isNaN(moy)){
                    // return Math.round(moy)
                    return moy.toFixed(2)
                }/*else {
                 return ""
                 }*/
            }else {
                return "-"
            }

        },
        getMatiereMoy(m){
            if (m.sous_matieres.length==0){
                var moy = this.getMoyByMat(m)
                if(!isNaN(moy))
                    this.moysEleve.push(moy)
                // console.log("*",this.moysEleve.length)
                return moy
                // moys.push()
            }

            else{
                let matMoy = "-"
                let smMoys = []
                m.sous_matieres.forEach((sm,i)=>{
                    if (sm.modules.length == 0){
                        // alert(i+ "+" + this.getMoyBySM(sm))
                        let temp = this.getMoyBySM(sm);
                        if(!isNaN(temp))
                            smMoys.push(temp)
                    }else
                    {
                        let modMoys = []
                        sm.modules.forEach(mod=>{
                            let temp = this.getMoyByMod(mod)
                            if(!isNaN(temp))
                                modMoys.push(temp)
                        })
                        if (modMoys.length>0){
                            let tot = modMoys.reduce((a,b)=>parseFloat(a)+parseFloat(b))
                            let smMoy = tot/ modMoys.length
                            smMoys.push(smMoy)
                        }

                    }
                });





                if (smMoys.length>0){
                    let total = smMoys.reduce((a,b)=>parseFloat(a)+parseFloat(b))
                    // alert(total)
                    matMoy = total/smMoys.length
                    this.moysEleve.push(matMoy)
                    // return Math.round(matMoy)
                    return matMoy.toFixed(2)
                }

            }
        },

        getSMAppreciation(sm){
            // console.log("SM Analysis",sm)
            // return sm.appreciations[0].appreciation
            var ap = sm.appreciations[0]
            if (ap && ap.id){
                return ap.appreciation
            }
            return ""

        },
        setSMAppreciation(sm){
            var ap = sm.appreciations[0]
            if (ap && ap.id){
                return ap.appreciation
            }
        },
        getMatAppreciation(mat){
            var ap = mat.appreciations[0]
            if (ap){
                // console.log("Appreciation",ap.id)
                return ap.appreciation
            }
            return ""
        },
        getModAppreciation(mod){
            var ap = mod.appreciations[0]
            if (ap && ap.id){
                return ap.appreciation
            }
            return ""
        },

        closeAllInputs(){
            // this.clickedEvaluationColumn = {}
            this.showApprInput = false
        },
        showAppreciationInput(){
            this.showApprInput = true
        },
        appreciationFocus(){
            this.showApprInput = true
        },
        apprBlur(sm){
            alert(sm.appreciations[0].appreciation)
            instance.post('set_appreciation',sm.appreciations[0]).then(res=>{
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
        }


    }
}

let vm = new Vue({
    el:"#app",
    data:{},
    mounted(){},
    components:{ bulletins }
})