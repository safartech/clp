/**
 * Created by Aleck on 17/12/2018.
 */


import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Personnels={
    template:"#Personnels",

    data(){
        return {

            persFilteredList:[],
            search:"",
            personnels:[

            ],

            newPersonnel:{
                nom: '',
                prenoms : '',
                sexe:'F',
                diplomes:'',
                adresse:'',
                nom_complet:'',
                quartier:'',
                tel_mobile:'',
                tel_domicile:'',




            },/*newPersonnel:{
                nom: 'fdf',
                prenoms : 'fef',
                sexe:'F',
                diplomes:'dsf',
                adresse:'dsf',
                nom_complet:'',
                quartier:'sdf',
                tel_mobile:'sdf',
                tel_domicile:'sdf',




            },*/
            updatePersonnel:{},
            deletePersonnel:{},
        }
    },
    watch:{
        search(data){
            // alert(data)
            this.personnels = this.persFilteredList.filter(e=>e.nom_complet.toLowerCase().includes(data))
            // alert(data)
        }
    },
    methods:{

        addPersonnel(){
            //
            this.newPersonnel.nom_complet=this.nomComplet,
            instance.post('add_personnel',this.newPersonnel).then(res=> {
                $.gritter.add({
                    title:"Ajout Personnel",
                    time:2000,
                    text:"Le Personnel "+this.newPersonnel.nom+'  '+this.newPersonnel.prenoms+" a été Ajouté avec Success",
                    class_name:"color success"});
                this.personnels.push(res.data);
                //this.loadDatas();
            }).catch(err=>{
                console.log(err.response.data);
            })


        },

        del(){

            instance.get('delete_personnel/'+this.deletePersonnel.id).then(res=>{
                this.loadDatas(),
                    $.gritter.add({
                        title:"Suppresion",
                        time:2000,
                        text:"Le Personnel "+this.deletePersonnel.nom+' '+this.deletePersonnel.prenoms+" a été supprimer avec Success",
                        class_name:"color success"});
            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Supppression du Responsable"+this.deletePersonnel.nom+' '+this.deletePersonnel.prenoms,
                    class_name:"color danger"});
            })
        },

        showDeleteModal(responsable){
            this.deletePersonnel=responsable;
            $('#mod-danger').modal('show')
        },


        showEditorModal(personnel){

            this.updatePersonnel=personnel;
            $('#form-bp2').modal('show')


        },
        updatepersonnel(){

            this.updatePersonnel.nom_complet=this.nomComplets,
                instance.put('update_personnel/'+this.updatePersonnel.id,this.updatePersonnel).then(res=> {
                    $.gritter.add({
                        title:"Modification",
                        time:2000,
                        text:"Modification effectuée avec Success.",
                        class_name:"color success"});
                    this.loadDatas();
                }).catch(err=>{
                    $.gritter.add({
                        title:"Modification",
                        time:2000,
                        text:"Echec de la Modification.",
                        class_name:"color danger"});
                })
        },

        loadDatas(){

            instance.get('load_personnels').then(res=>{
                console.log(res.data);
                this.persFilteredList=res.data
                this.personnels=res.data
            }).catch(err=>{
                console.log(err.response.data);
            })
        }

    },
    mounted(){
        this.loadDatas();
    }

    ,
    computed:{
        nomComplet(){
            return this.newPersonnel.nom+' '+this.newPersonnel.prenoms
        },
        nomComplets(){
            return this.updatePersonnel.nom+' '+this.updatePersonnel.prenoms

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
            Personnels
        }
    }

)

