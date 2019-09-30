import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Informations={
    template:"#informations",
    data(){
        return {
            search:"",

            newInfo:{
                title : '',
                content:'',
                start_date:'',
                end_date:'',
                is_active:0

            },
            updateInfo:{},
            deleteInfo:{},
            activationInfo:{},
            informations:[],
            informationsFilteredList:[]
        }
    },
    watch:{
        search(data){
            this.informationsFilteredList = this.informations.filter(e=>e.title.toLowerCase().includes(data))
            // alert(data)
        }
    },
    methods:{

        // notnull(classe){
        //     return classe !=null
        // },
        initView(){
            $('#select2-session').select2({
                $dropdownParent: '#form-bp1',
            }),

                // $("#nsce").mask("9999-99-99");
                $('.date').datetimepicker(
                    {
                        autoclose: !0,
                        componentIcon: ".mdi.mdi-calendar",
                        viewMode:"years",
                   //   useCurrent:true,
                        navIcons: {rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left"}
                    }
                )



            $('#start_date_create').on('change',(e)=> {
                this.newInfo.start_date = $('#start_date_create').data('date')
            })
            $('#end_date_create').on('change',(e)=> {
                this.newInfo.end_date = $('#end_date_create').data('date')
            })
            $('#start_date_modif').on('change',(e)=> {
                this.updateInfo.start_date = $('#start_date_modif').data('date')
            })
            $('#end_date_modif').on('change',(e)=> {
                this.updateInfo.end_date = $('#end_date_modif').data('date')
            })

        },

        addInformation(){
            //console.log(this.newEleve);
                instance.post('add_information',this.newInfo).then(res=> {
                    $.gritter.add({
                        title:"Ajout",
                        time:2000,
                        text:"L'information  "+this.newInfo.title+' '+" a été Ajouté avec Success",
                        class_name:"color success"});

                    this.informations.push(res.data);
                    this.loadDatas();

                }).catch(err=>{
                    console.log(err.response.data);
                })


        },

        // activateInformation(info){
        //     console.log(info)
        // if (confirm('Etes -vous sûr de vouloir activer cette information ?')){
        //         this.activationInfo=info
        //
        //     if (info.is_active==0){
        //             this.activationInfo.is_active=1
        //     }else {
        //         this.activationInfo.is_active=0
        //
        //     }
        //
        //     instance.put('activate_information/'+this.activationInfo.id,this.activationInfo).then(res=>{
        //         console.log(res.data)
        //
        //         if(res.data ===1 ){
        //             $.gritter.add({
        //                 title:"Activation",
        //                 time:2000,
        //                 text:"L' Information "+info.title+' '+" a été activé avec Success",
        //                 class_name:"color success"});
        //               //  this.loadDatas();
        //
        //         }else {
        //             $.gritter.add({
        //                 title:"Activation",
        //                 time:8000,
        //                 text:"Erreur d'activation de l'Information "+info.title+' '+'.La période de validité est invalide',
        //                 class_name:"color danger"});
        //         }
        //
        //
        //     }).catch(err=>{
        //         $.gritter.add({
        //             title:"Activation",
        //             time:5000,
        //             text:"Erreur d'activation de l'Information "+info.title,
        //             class_name:"color danger"});
        //     })
        // }
        //
        // },
        del(){

           // instance.get('delete_eleve/'+this.deleteEleve.id).then(res=>{
            instance.get('delete_information/'+this.deleteInfo.id).then(res=>{
                this.loadDatas(),
                    $.gritter.add({
                        title:"Suppresion",
                        time:2000,
                        text:"L' Information "+this.deleteInfo.title+' '+" a été supprimé avec Success",
                        class_name:"color success"});
            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Suppression de l'Information "+this.deleteInfo.title,
                    class_name:"color danger"});
            })
        },

        showDeleteModal(info){
            this.deleteInfo=info;
            $('#mod-danger').modal('show');
        },

        showEditorModal(info){
            this.updateInfo=info;
            // $('#date-nsce2').attr('data-date',eleve.date_nsce)

            $('#form-bp2').modal('show');


        },

        moment(date){
            return moment(date).format('DD MMMM YYYY')
        },

        momento(date){
            return moment(date).format('DD-MM-YYYY')
        },

        UpdateInformation(){
            console.log(this.updateInfo)

             //   instance.put('update_Eleve/'+this.updateEleve.id,this.updateEleve).then(res=> {
                instance.put('update_information/'+this.updateInfo.id,this.updateInfo).then(res=> {
                    $.gritter.add({
                        title:"Modification",
                        time:2000,
                        text:"Modification effectué avec Success.",
                        class_name:"color success"});
                    this.loadDatas();
                }).catch(err=>{
                    console.log(err.response.data)
                    $.gritter.add({
                        title:"Modification",
                        time:2000,
                        text:"Echec de la Modification.",
                        class_name:"color danger"});
                })
        },

        loadDatas(){

//            instance.get('load_eleves').then(res=>{
            instance.get('load_informations').then(res=>{
                this.informations=res.data.informations;
                this.informationsFilteredList = this.informations

            }).catch(err=>{
                console.log(err.response.data);
            })
        }

    },
    mounted(){
        moment.locale('fr')
        this.loadDatas();
        this.initView();
    },

}
new Vue(
    {
        el:"#app",
        data:{

        },
        methods: {

        },
        components:{
            Informations
        }


    },

)
