/**
 * Created by Aleck on 11/12/2018.
 *
 */

import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Responsables={
    template:"#responsables",
    data(){
        return {
            search:"",
            respFilteredList:[],
            responsables:[

            ],
            newResponsable:{
                nom:'',
                prenoms : '',
                profession:'',
                sexe:'F',
                code_postal:'',
                email:'',
                bureau:'',
                domicile:'',
                adresse:'',
                nom_complet: '',


            },/*newResponsable:{
                nom:'',
                prenoms : 'aezae',
                profession:'zae',
                sexe:'F',
                code_postal:'aze',
                email:'zre',
                bureau:'dsf',
                domicile:'aze',
                adresse:'aze',
                nom_complet: '',


            },*/
            updateResponsable:{},
            deleteResponsable:{},
        }
    },
    watch:{
        search(data){
            // alert(data)
            this.responsables = this.respFilteredList.filter(e=>e.nom_complet.toLowerCase().includes(data))
            // alert(data)
        }
    },
    methods:{

        addResponsable(){
            //console.log(this.newEleve);

            this.newResponsable.nom_complet=this.nomComplet,
            instance.post('add_responsable',this.newResponsable).then(res=> {
                $.gritter.add({
                    title:"Ajout",
                    time:2000,
                    text:"Le Responsable "+this.newResponsable.nom+''+this.newResponsable.prenoms+" a été Ajouté avec Success",
                    class_name:"color success"});
                console.log(res.data);
                this.responsables.push(res.data);
                //this.loadDatas();
            }).catch(err=>{
                $.gritter.add({
                    title:"Erreur !!!!",
                    time:2000,
                    text:"Le Responsable "+this.newResponsable.nom+''+this.newResponsable.prenoms+" n'a pas  été Ajouté avec Success",
                    class_name:"color danger"});
            })


        },

        del(){

            instance.get('delete_responsable/'+this.deleteResponsable.id).then(res=>{
                this.loadDatas()
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Le Responsable "+this.deleteResponsable.nom+' '+this.deleteResponsable.prenoms+" a été supprimer avec Success",
                    class_name:"color success"});

            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Supppression du Responsable"+this.deleteResponsable.nom+' '+this.deleteResponsable.prenoms,
                    class_name:"color danger"});
                console.log(err.response.data);
            })
        },

        showDeleteModal(responsable){
            this.deleteResponsable=responsable;
            $('#mod-danger').modal('show')
        },


        showEditorModal(responsable){

            this.updateResponsable=responsable;
            $('#form-bp2').modal('show')


        },

        updateresponsable(){


            this.updateResponsable.nom_complet=this.nomComplets,
            instance.put('update_Responsable/'+this.updateResponsable.id,this.updateResponsable).then(res=> {

                $.gritter.add({
                    title:"Modification",
                    time:2000,
                    text:"Modification effectué avec Success.",
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

            instance.get('load_responsables').then(res=>{
                console.log(res.data);
                this.respFilteredList = res.data
                this.responsables=res.data
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
            return this.newResponsable.nom+' '+this.newResponsable.prenoms
        },
        nomComplets(){
            return this.updateResponsable.nom+' '+this.updateResponsable.prenoms

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
            Responsables
        }


    }

)
