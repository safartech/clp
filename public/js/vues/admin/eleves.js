/**
 * Created by Aleck on 11/12/2018.
 *
 */

import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Eleves={
    template:"#eleves",
    data(){
        return {
            search:"",
            eleves:[


            ],
            newEleve:{
                nom : '',
                prenoms:'',
                sexe:'F',
                date_nsce:'',
                adresse:'',
                nationalite:'',
                pays_nsce:'',
                telephone:'',
                classe_id:'',
                nom_complet:'',
                lieu_nsce:'',

            },/*newEleve:{
                nom : 'aezae',
                prenoms:'zae',
                sexe:'F',
                date_nsce:'1999-02-12',
                adresse:'eaze',
                nationalite:'aze',
                pays_nsce:'zre',
                telephone:'dsf',
                classe_id:'',
                nom_complet:'',
                lieu_nsce:'rfg',
                nom_complet:'',

            },*/
            updateEleve:{},
            deleteEleve:{},
            classes:[
            ],
            elevesFilteredList:[]
        }
    },
    watch:{
      search(data){
          this.elevesFilteredList = this.eleves.filter(e=>e.nom_complet.toLowerCase().includes(data))
          // alert(data)
      }
    },
    methods:{

        notnull(classe){
            return classe !=null
        },
        initView(){
          $('#select2-session').select2({
              $dropdownParent: '#form-bp1',
          }),

            // $("#nsce").mask("9999-99-99");
            $('#date-nsce1').datetimepicker(
                {
                    autoclose: !0,
                    componentIcon: ".mdi.mdi-calendar",
                    viewMode:"years",
//                    useCurrent:true,
                    navIcons: {rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left"}
                }
            )
            $('#date-nsce2').datetimepicker(
                {
                    autoclose: !0,
                    componentIcon: ".mdi.mdi-calendar",
                    viewMode:"years",
//                    useCurrent:true,
                    navIcons: {rightIcon: "mdi mdi-chevron-right", leftIcon: "mdi mdi-chevron-left"}
                }
            )


            $('#date-nsce1').on('change',(e)=> {
                this.newEleve.date_nsce = $('#date-nsce1').data('date')
                // console.log(this.newEleve.date_nsce)
             })
            $('#date-nsce2').on('change',(e)=> {
                this.updateEleve.date_nsce = $('#date-nsce2').data('date')
                // console.log(this.updateEleve.date_nsce)
             })


        },

        addEleve(){
                //console.log(this.newEleve);
                this.newEleve.nom_complet=this.nomComplet,

                    instance.post('add_eleve',this.newEleve).then(res=> {
                        $.gritter.add({
                            title:"Ajout",
                            time:2000,
                            text:"L'Eleve  "+this.newEleve.nom+' '+this.newEleve.prenoms+" a été Ajouté avec Success",
                            class_name:"color success"});

                    this.eleves.push(res.data);
                    this.loadDatas();

                }).catch(err=>{
                        console.log(err.response.data);
                })


            },

        del(){

            instance.get('delete_eleve/'+this.deleteEleve.id).then(res=>{
                this.loadDatas(),
                    $.gritter.add({
                        title:"Suppresion",
                        time:2000,
                        text:"L' Eleve "+this.deleteEleve.nom+' '+this.deleteEleve.prenoms+" a été supprimer avec Success",
                        class_name:"color success"});
            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Supppression de l'Eleve "+this.deleteEleve.nom+' '+this.deleteEleve.prenoms,
                    class_name:"color danger"});
            })
        },

        showDeleteModal(eleve){
            this.deleteEleve=eleve;
            $('#mod-danger').modal('show');
        },

        showEditorModal(eleve){

            this.updateEleve=eleve;
            // $('#date-nsce2').attr('data-date',eleve.date_nsce)

            $('#form-bp2').modal('show');


        },

        moment(date){
            return moment(date).format('DD MMMM YYYY')
        },

        momento(date){
            return moment(date).format('DD-MM-YYYY')
        },

        UpdateEleves(){
            console.log(this.updateEleve)
            this.updateEleve.nom_complet=this.u_nomComplet,

                instance.put('update_Eleve/'+this.updateEleve.id,this.updateEleve).then(res=> {
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

            instance.get('load_eleves').then(res=>{
                console.log(res.data.eleves[0].classe.nom);
                this.eleves=res.data.eleves;
                this.elevesFilteredList = this.eleves
                this.classes=res.data.classes;

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


    computed:{
        nomComplet(){
            return this.newEleve.nom+' '+this.newEleve.prenoms;
        },
        u_nomComplet(){
            return this.updateEleve.nom+' '+this.updateEleve.prenoms;

        },
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
            Eleves
        }


    },

)
