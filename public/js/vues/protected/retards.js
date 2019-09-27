/**
 * Created by User on 31/01/2019.
 */
import {url} from '../../base_url.js'
//        alert(baseUrl)
let instance = axios.create({
    baseURL : url
});

let Retard = {
    template:'#retard',
    data(){
        return {
            eleves:[],
            classes:[],
            sessions:[],
            currentDate:null,
            selectedSession:null,
            selectedSessionId:null,
            selectedClasse:null,
            filteredEleves:[]
        }
    },
    mounted(){
        this.initView()
        this.loadDatas()
    },
    computed:{
        isReady(){
            return this.selectedSessionId !=null && this.currentDate!=null
        },
    },
    methods:{
        initView(){
            $('#select2-classe').select2().on('change',e=>{
                // alert($('#select2-classe').val())
                this.onClasseChange($('#select2-classe').val())
            });
            $('#select2-session').select2().on('change',e=>{
                // alert($('#select2-session').val())
                this.selectedSessionId = $('#select2-session').val()
                this.onSessionChange($('#select2-session').val())
            });

            $('#date').datetimepicker(
                {
                    autoclose: !0,
                    componentIcon: ".mdi.mdi-calendar",
                    viewMode:"years",
//                    useCurrent:true,
                    navIcons: {rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left"}
                }
            );
            $('#date').on('change',(e)=> {
                this.currentDate = $('#date').data('date')
                // alert($('#date').data('date'))
                // console.log(this.newEleve.date_nsce)
            })
        },
        reload(){
            instance.get('load_retards_datas').then(res=>{
                this.eleves = res.data.eleves
                // console.log(res.data)
            }).catch(err=>{
                console.log(err.reponse.data)
            })
        },

        loadDatas(){
            instance.get('load_retards_datas').then(res=>{
                this.eleves = res.data.eleves
                this.filteredEleves = res.data.eleves
                this.classes = res.data.classes
                this.sessions = res.data.sessions
                // console.log(res.data)
            }).catch(err=>{
                console.log(err.reponse.data)
            })
        },

        onClasseChange(classeId){
            this.selectedClasseId = classeId
            if(classeId==0){
                this.filteredEleves = this.eleves
            }else {
                this.filteredEleves = this.eleves.filter(x=>x.classe_id==classeId)
            }
        },
        onSessionChange(sessionId){
            this.selectedSessionId = sessionId
        },
        wasLate(eleve){
            // var eleve = this.eleves.find(e=>e.id==eleveId)
            let retards = eleve.retards
            let r = retards.find(r=>r.eleve_id==eleve.id && r.date==this.currentDate)
            return !!r;

        },
        setRetard(eleve){
            let retard = {
                eleve_id:eleve.id,
                date:this.currentDate,
                session_id:this.selectedSessionId,
                isLate: this.wasLate(eleve),

            };
            instance.post('set_eleve_as_late',retard).then(res=>{
                console.log(res.data)
                this.reload()
            }).catch(err=>{
                console.log(err.response.data)
            })
        },
        countRetardBySession(eleve){
            let retards = eleve.retards.filter(r=>r.session_id==this.selectedSessionId)
            return retards.length
        }
    }
};

let vm = new Vue({
    el:'#app',
    data:{},
    components:{ Retard }
})