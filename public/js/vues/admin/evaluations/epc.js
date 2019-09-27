/**
 * Created by User on 13/12/2018.
 */
import { url } from '../../../base_url.js'
let instance = axios.create({
    baseURL: url
})

let epc = {
  template:"#epc",
    data(){
        return {
            datas:[],
            classes:[],
            classe:{},
            session:{},
            eleves:[],
            eleve:{},
            sessions:[],
            currentSessionId: 0,
            matieres:[],
            matiere:{},
            niveaux:[],
            acquis:[],
            currentEvaluation:{},
            selectedNiv:{}

        }
    },
    mounted(){
        this.loadDatas()
        this.initView()
    },
    computed:{
        hasMatieres(){
            return this.matieres.length>0
        },

        readyToPrint(){
            return this.classe.id && this.eleve.id;
        },
        ready(){
         return this.classe.id!=null && this.eleve.id!=null
        }
        ,
        printLink(){
            return url+"epc/print/"+this.eleve.id
        },
    },
    methods:{
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
                    // alert($('#select2-classe').val())
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
        reload(){
            this.loadDatas()
        },
        onClasseChange(classeId){
            this.classe = this.classes.find(c=>c.id==classeId)
            this.eleves = this.classe.eleves
            this.reloadEleveSelector()
        },
        onSessionChange(sessionId){
            this.session = this.sessions.find(s=>s.id==sessionId)
        },
        onEleveChange(eleveId){
            this.eleve = this.eleves.find(e=>e.id==eleveId)
            this.matieres = this.eleve.classe.niveau.matieres
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
        loadDatas(){
            instance.get('load_datas_for_epc_from_admin').then(res=>{
                console.log(res.data)
                this.classes = res.data.classes
                this.sessions = res.data.sessions;
                this.niveaux = res.data.niveaux
                this.acquis = res.data.acquis
                this.currentSessionId = this.sessions[0].id
            }).catch(err=>{
                console.log(err.response.data)
            })
        },

        evaluate(domaine,cpt,session){
            // alert()
            if(domaine.par_niveau == 1){
                this.currentEvaluation.eleve_id = this.eleve.id
                this.currentEvaluation.competence_id = cpt.id
                this.currentEvaluation.session_id = session.id
                $('#evaluationModal1').modal('show')
            }else {
                this.currentEvaluation.eleve_id = this.eleve.id
                this.currentEvaluation.competence_id = cpt.id
                this.currentEvaluation.session_id = session.id
                $('#evaluationModal2').modal('show')
            }

        },
        selectEvalution(niveau){
            $('#evaluationModal2').modal('hide')
            $('#evaluationModal1').modal('hide')
            this.currentEvaluation.validation = niveau.designation
            console.log(this.currentEvaluation)
            console.log("NIv",this.selectedNiv)
            instance.post('evaluate',this.currentEvaluation).then(res=>{
                console.log("Response: ",res.data)
                this.eleve = res.data
                // this.loadDatas()
            })
                .catch(err=>{
                    console.log(err.response.data)
                })

        },
        getEleveCpt(cpt,session){
            let c = this.eleve.competences.filter(c=>c.pivot.competence_id==cpt.id && c.pivot.session_id==session.id)[0]
            if(!c){
                return ""
            }else {
                return c.pivot.validation
                // let cpt =  cpts.filter(c=>c.pivot.session_id==session.id)[0]
                //  return cpt.validation
            }
        },
        genId(niv_id){
            return "qdfds"+niv_id
        },
        getCpt(){

        }
    },

};

let vm = new Vue({
    el:"#app",
    data:{},
    components:{epc}
})