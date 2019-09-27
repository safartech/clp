/**
 * Created by User on 22/11/2018.
 */
import { url } from '../../../../../../soochool/public/js/base_url.js'
let instance = axios.create({
    baseURL: url
})


let bulletins = {
    template: "#bulletins",
    data(){
        return{
            classes:[],
            sessions:[],
            eleves:[],
            selectedClasse:null,
            selectedEleve:null,
            selectedEleveId:0,
            selectedSession:null,
            selectedSessionId:0,
            selectedClasseId:0,
            matieres:[],

            obligatoires:[],
            facultatives:[],
            moys_tab:[],
            smallest_moy:0,
            biggest_moy:0,
            moy_of_classe:0,
            moyenne : 0,
            clickedAppreciationMatiere:{},
            tempAppr:"",
            tempRetard:"",
            tempAbs:"",

        }
    },
    mounted(){
        this.loadDatas()
        this.initView()
    },
    computed:{
        showBulletin(){
            return this.selectedEleve!=null && this.selectedSession!=null
        },

        showElevesList(){
            // return this.selectedClasse!=null && this.selectedSession!=null
            return  this.selectedSession!=null
        }


        /*seeLink(){
         return url+"see_bulletin_of_eleve/"+this.selectedEleveId+"/"+this.selectedSessionId
         },*/



    },
    watch:{

    },
    methods:{
        printLink(see){
            return url+"print_bulletin_of_eleve/"+this.selectedEleveId+"/"+this.selectedSessionId+"/"+see
        },

        apprFocus(matiere){
            // alert()
            this.clickedAppreciationMatiere = matiere
            this.tempAppr = matiere.appr
            $('#appr-modal').modal('show')
            $('#appr-text').focus()
        },

        showAppreciationInput(matiere){
            return this.clickedAppreciationMatiere == matiere
        },

        /*ar(m){
         alert()
         },*/

        /*apprFocus(matiere){
         this.clickedAppreciationMatiere = matiere
         },*/

        apprInputFocus(matiere){

        },

        // apprBlur(matiere){
        apprBlur(){
            // alert(this.clickedAppreciationMatiere.appr)
            // alert(this.tempAppr)
            // return 0;
            this.clickedAppreciationMatiere.appreciations[0].appreciation = this.tempAppr
            this.clickedAppreciationMatiere = {
                eleve_id: this.selectedEleve.id,
                session_id: this.selectedSession.id,
                matiere_id: this.clickedAppreciationMatiere.id,
                appreciation: this.tempAppr
            }

            instance.post('set_appreciation',this.clickedAppreciationMatiere).then(res=>{
                console.log(res.data)
                $.gritter.add({
                    title:"Modification",
                    time:2000,
                    text:"Note enrégistrée avec Success pour l'élève "+this.selectedEleve.nom_complet,
                    class_name:"color success"
                });
                this.clickedAppreciationMatiere = {}
            }).catch(err=>{
                console.log(err.response.data)
                $.gritter.add({
                    title:"Erreur d'enrégistrement",
                    time:4000,
                    text:"Veuillez resaisir l'appréciation pour l'élève "+this.selectedEleve.nom_complet,
                    class_name:"color danger"
                });
                this.clickedAppreciationMatiere = {}
            })
            /*let ap = {
             eleve_id: this.selectedEleve.id,
             session_id: this.selectedSession.id,
             matiere_id: matiere.id,
             appreciation: this.tempAppr
             }*/
            // matiere.appreciations[0] = ap
            // alert(ap.appreciation)
            // alert(matiere.appreciations[0].appreciation)
        },

        getAppreciation(matiere){
            // return matiere["appr"]
            //filter by session
            if(matiere.appreciations[0]){
                matiere.appr =  matiere.appreciations[0].appreciation
                return matiere.appr
                // return this.tempAppr
            }
            else {
                matiere.appreciations[0] = {
                    eleve_id: this.selectedEleve.id,
                    session_id: this.selectedSession.id,
                    matiere_id: matiere.id,
                    appreciation: ""
                };
                matiere.appr = matiere.appreciations[0].appreciation
                return matiere.appr
                // return matiere.appreciations[0].appreciation
                // this.tempAppr = "0"
                // return this.tempAppr
            }
            // console.log(matiere.appreciations)
            /*if(matiere.appreciations[0]){
             // return matiere.appreciations[0].appreciation
             return matiere["appr"]
             // return this.tempAppr
             }*/
        },

        initVars(){
            this.obligatoires=[]
            this.facultatives=[]
            this.moys_tab=[]
            this.smallest_moy=0
            this.biggest_moy=0
            this.moy_of_classe=0
        },

        getMoy(){
            let coef_obl = this.total(this.obligatoires,"coef");
            let coef_fac = this.total(this.facultatives,"coef");
            let moys_obls = this.total(this.obligatoires,"moy_coef");
            let moys_facs = this.total(this.facultatives,"moy_coef");
            let moy_fac = (moys_facs/coef_fac).toFixed(2);
            let all_moys= moys_obls
            all_moys = parseFloat(all_moys)+parseFloat(moy_fac)
            let all_coef = coef_obl+1
            let moy = all_moys/all_coef
            // let moy = ((this.sum(this.total(this.obligatoires,"moy_coef"),((this.total(this.facultatives,"moy_coef")/(this.total(this.facultatives,"coef"))))))/(this.sum(this.total(this.obligatoires,"coef"))+1))
            return moy.toFixed(2)
        },

        reload(){
            this.loadDatas()
            this.initVars()
        },
        initView(){
            $('#select2-session')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    // alert($('#select2-classe').val())
                    this.onSessionChange($('#select2-session').val())
                });


        },
        loadDatas(){
            instance.get('load_bulletins_datas_from_parent').then(res=>{
                console.log(res.data.classes)
                this.eleves = res.data.eleves
                this.sessions = res.data.sessions
            }).catch(err=>{
                console.log(err.response.data)

            })
        },

        sum(a,b){
            return parseFloat(a)+parseFloat(b);
        },

        getNbreRetard(eleve){
            let retard = eleve.retard_counts.find(x=>x.eleve_id==eleve.id && session_id==this.selectedSession.id)
            if(retard){
                return retard.nombre
            }else {
                retard = {
                    eleve_id:eleve.id,
                    session_id:this.selectedSession.id,
                    nombre:"0"
                }
                return retard.nombre
            }
        },
        getNbreAbs(){

        },

        setRetard(){
            alert()
        },
        setAbs(){},

        showSetRetardModal(eleve){

        },
        showSetAbsModal(eleve){

        },

        onSessionChange(sessionId){
            this.selectedSession = this.sessions.find(x=>x.id==sessionId)
            this.selectedSessionId = sessionId
            if (this.showBulletin){
                this.loadBulletin()
            }
        },

        getEleveName(){
            if (this.selectedEleve!=null){
                return this.selectedEleve.nom_complet
            }
        },

        eleveClick(eleve){
            this.selectedEleve = eleve;
            this.selectedEleveId = eleve.id;
            // this.initVars()
            if (this.showBulletin){
                this.loadBulletin()
            }
        },



        isSelected(eleve){
            return this.selectedEleve==eleve?"primary":""
        },

        coef(matiere){
            var moyCoef = matiere.moy_gen * matiere.coef
            matiere.moy_coef = moyCoef
            return moyCoef
        },

        total(array,key){
            let sum=0
            if(key==="coef"){
                array.forEach(a=>{
                    // console.log(key,a[key])
                    if(!isNaN(a[key])) sum+=parseInt(a[key])
                })
                return sum
            }
            array.forEach(a=>{
                // console.log(key,a[key])
                if(!isNaN(a[key])) sum+=parseFloat(a[key])
            })
            return sum.toFixed(2)
        },

        getRang(){
            let moy = this.getMoy()
            this.moys_tab.sort()
            this.moys_tab.reverse()
        },

        loadBulletin(){
            $('#loader').modal({backdrop: 'static', keyboard: false})
            /*$('#loader').on('shown.bs.modal', function () {
             $('#loader').trigger('focus')
             });*/
            $('#loader').modal('show')
            instance.get('load_bulletin_of_eleve_from_admin/'+this.selectedEleve.id+"/"+this.selectedSession.id).then(res=>{
                console.log(res.data)
                this.obligatoires = res.data.obligatoires
                this.facultatives = res.data.facultatives
                this.moys_tab = res.data.moys_tab
                this.smallest_moy = res.data.smallest_moy
                this.biggest_moy = res.data.biggest_moy
                this.moy_of_classe = res.data.moy_of_classe
                // console.log(this.moys_tab)
                // console.log(this.moys_tab.sort())
                // console.log(this.moys_tab.reverse())
                $('#loader').modal('hide')
            }).catch(err=>{
                this.initVars()
                this.selectedEleve = null
                $('#loader').modal('hide')
                console.log("bull load:",err.response.data)
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