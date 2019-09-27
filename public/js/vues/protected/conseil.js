/**
 * Created by User on 18/01/2019.
 */
import {url} from '../../base_url.js'
let ajax = axios.create({
    baseURL : url
});

let Conseil = {
    template:'#conseil',
    data(){
        return {
            sessions:[],
            classes:[],
            eleves:[],
            conseils:[],
            selectedSession:{},
            selectedClasse:{},
            selectedEleve:{},
            newConseil:{
                eleve_id:0,
                session_id:0,
                rythme:"",
                autonomie:"",
                attention:null,
                participation:null,
                og:null,
                absences:null
            },
            selectedEleveConseil:{},
        }
    },
    mounted(){
        this.initView()
        this.loadDatas()
    },
    computed:{
        isReady(){
            return this.selectedSession.id!=null && this.selectedClasse.id!=null
        }
    },
    methods:{
        reload(){
            ajax.get('load_conseil_datas').then(res=>{
                console.log(res.data)
                this.sessions = res.data.sessions
                this.classes = res.data.classes
                this.conseils = res.data.conseils

                this.selectedClasse = this.classes.find(c=>c.id==this.selectedClasse.id);
                this.eleves = this.selectedClasse.eleves
            }).catch(err=>{
                console.log(err.response.data)
            })
        },
        loadDatas(){
            ajax.get('load_conseil_datas').then(res=>{
                console.log(res.data)
                this.sessions = res.data.sessions
                this.classes = res.data.classes
                this.conseils = res.data.conseils
            }).catch(err=>{
                console.log(err.response.data)
            })
        },
        initView(){
            $('#select2-classes')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    this.onClasseChange($('#select2-classes').val())
                });
            $('#select2-sessions')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    this.onSessionChange($('#select2-sessions').val())
                });

        },
        onClasseChange(classeId){
            this.selectedClasse = this.classes.find(c=>c.id==classeId);
            this.eleves = this.selectedClasse.eleves
        },
        onSessionChange(sessionId){
            this.selectedSession = this.sessions.find(s=>s.id==sessionId)
        },
        showAssiduiteSetter(eleve){
            // console.log(this.selectedEleveConseil)
            this.selectedEleve = eleve
            let c = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(c){
                this.selectedEleveConseil = c
            }else {
                this.selectedEleveConseil = this.newConseil
            }

            $('#conseil-modal').modal('show')
        },
        getEleveOG(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.og
        },
        getEleveAttention(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.attention
        },
        getEleveParticipation(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.participation
        },
        getEleveRythme(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.rythme
        },
        getEleveEcriture(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.ecriture
        },
        getEleveAutonomie(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.autonomie
        },
        getEleveAbsences(eleve){
            let conseil = eleve.conseils.find(x=>x.eleve_id==eleve.id && x.session_id==this.selectedSession.id)
            if(conseil)return conseil.absences
        },

        validate(){
            // console.log(this.selectedEleveConseil)
            this.selectedEleveConseil.eleve_id = this.selectedEleve.id
            this.selectedEleveConseil.session_id = this.selectedSession.id
            ajax.post('set_conseil_for_eleve',this.selectedEleveConseil).then(res=>{
                console.log(res.data)
                this.reload()
            }).catch(err=>{
                console.log(err.response.data)
            })
            this.selectedEleveConseil = {}
        }


    }
}

new Vue(
    {
        el:"#app",
        data:{
        },
        methods: {

        },
        components:{
            Conseil
        }
    },
);