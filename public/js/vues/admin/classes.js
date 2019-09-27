import {url} from '../../base_url.js'

 let instance=axios.create({
     baseURL: url
 })

let classe={

    template: '#classes',
    data(){
        return{
            classe:{},
            classes:[],
            eleves:[],
            eleve:{},
            interventions:[],
            date0:"",
            date1:"",
            date2:"",
        }
    },
    mounted(){
        // alert('hello')
        moment.locale('fr')
        this.init()

    this.loadClasses()
    },
    methods:{
        init(){
            $('select#select2-classe').on('change',(e)=>{
               // this.classeChange($('#select2-classe').val())
                const selVal=$('select#select2-classe').val()
                this.classeChange(selVal)
               // alert(selVal);
            });

            $('#date1').datetimepicker(
                {
                    autoclose: !0,
                    componentIcon: ".mdi.mdi-calendar",
                    viewMode:"years",
//                    useCurrent:true,
                    navIcons: {rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left"}
                }
            )

            /*$('#date1').on('change',(e)=> {
                alert($('#date1').data("date"))
            })*/

        },

        reload(){
            this.loadClasses()
        },

        moment(date){
            return moment(date)
            // return moment(date).format('dd/MM/YYYY')
        },

        loadClasses(){
            instance.get('liste_classes')
                .then((response)=> {
                    this.classes=response.data
                    this.classe = this.classes[0]
                    this.classeClicked(this.classe)
                    console.log(response.data)
                })
                .catch( (error) => {
                    console.log(error.response.data);
                })
        },

        classeClicked(classe){
            this.classe = classe
            this.eleves = this.classe.eleves
            this.interventions = this.classe.interventions
            console.log(this.interventions)

        },

        classeChange(id){
        this.eleves=this.classes[id].eleves
        this.interventions=this.classes[id].interventions
        //this.matieres=this.classes[id].interventions[0].matiere


           // console.log(this.test)
         //  this.eleves=this.classes.filter((e)=>{id = e.id})[0].eleves                //filter((it)=>{it.id === id})[0].eleves;
         //   this.eleves=this.classe.eleves;
        // alert($id)
            /*   instance.get('classes/'+$nom)
                .then((response)=> {
                    this.classes=response.data
                    console.log(response.data)
                })
                .catch( (error) => {
                    console.log(error);
                })*/

        },

        classeSelectedBgColor(classe){
            if(this.isSelectedClasse(classe)) return "primary" ; else return ""
        },

        isSelectedClasse(classe){
            return this.classe.id==classe.id;
        },
    },
    computed:{

    }
}

let vm=new Vue({

    el:'#app',
    data: {},
    mounted(){
    },

    methods:{},
    components:{ classe }

})