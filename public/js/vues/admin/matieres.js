/**
 * Created by Aleck on 11/12/2018.
 *
 */

import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Matieres={
    template:"#matieres",
    data(){
        return {
            matieres:[

            ],
            mat:[

            ],
            newMatiere:{
                intitule:'',
                couleur : '',
            },/*newMatiere:{
                intitule:'df',
                couleur : '#8b0000',
            },*/
            updateMatiere:{},
            deleteMatiere:{},
        }
    },
    methods:{

        addMatiere(){
            //console.log(this.newPersonnel);
            instance.post('add_matiere',this.newMatiere).then(res=> {
                $.gritter.add({
                    title:"Ajout Matiere",
                    time:2000,
                    text:"La Matiere "+this.newMatiere.intitule+" a été Ajouté avec Success",
                    class_name:"color suceess"});
                console.log(res.data);
                this.matieres.push(res.data);
                //this.loadDatas();
            }).catch(err=>{
                $.gritter.add({
                    title:"Erreur!!!!",
                    time:2000,
                    text:"La Matiere "+this.newMatiere.intitule+" n'a pas été Ajouté. Réesayer SVP!",
                    class_name:"color danger"});
            })


        },
        del(){

            instance.get('delete_matiere/'+this.deleteMatiere.id).then(res=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"La Matiere "+this.deleteMatiere.intitule+" a été supprimer avec Success",
                    class_name:"color success"});
                this.loadDatas()
            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Supppression de la Matiere "+this.deleteMatiere.intitule,
                    class_name:"color danger"});
            })
        },

        showDeleteModal(matiere){
            this.deleteMatiere=matiere;
            $('#mod-danger').modal('show')
        },
        showEditorModal(matiere){
            this.updateMatiere=matiere;
            $('#form-bp2').modal('show')


        },

        updatematiere(){
            console.log(this.updateMatiere.id)
            instance.put('update_matiere/'+this.updateMatiere.id,this.updateMatiere).then(res=> {

                console.log(res.data);
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

                instance.get('load_matieres').then(res=>{
                    console.log(res.data);
                    this.matieres=res.data
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
             Matieres
         }


     }

 )
