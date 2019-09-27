/**
 * Created by Aleck on 18/02/2019.
 */
import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Blog={
    template:"#blog",
    data(){
        return {
            Poste:[

            ],
            nom:[],
            comment:[],
            affichage:true,
            ajout:false,
            vue:false,
            modif:false,
            newPoste:{

                title:'',
                body : '',
            },
            newComment:{

                post_id:'',
                content : '',
            },
            updatepost:{},
            deletepost:{},
            infopost:{},
            deletecomment:{},


        }
    },
    methods:{

        showAddPanel(){
            this.affichage=false,
                this.ajout=true,
                this.vue=false,
                this.modif=false
        },
        showAllPost(){
            this.affichage=true,
                this.ajout=false,
                this.vue=false,
                this.modif=false
        },

        addcomment(infopost){
            this.newComment.post_id=infopost.id

            instance.post('add_comment',this.newComment).then(res=> {

                this.newComment.content=''
                $.gritter.add({
                    title:"Commentaire",
                    time:2000,
                    text:"Commentaire faite avec Success",
                    class_name:"color suceess"});
                this.loadDatas();
                this.comment.push(res.data)

            }).catch(err=>{
                $.gritter.add({
                    title:"Erreur!!!!",
                    time:2000,
                    text:"Echec lors du commentaire!",
                    class_name:"color danger"});
                console.log(err.response.data)
            })


        },

        addPoste(){

            this.newPoste.body=($("#editor1").summernote('code'))
            instance.post('add_poste',this.newPoste).then(res=> {
                $.gritter.add({
                    title:"Ajout Article",
                    time:2000,
                    text:"L'Article a été Ajouté avec Success",
                    class_name:"color suceess"});

                this.loadDatas();
                this.newPoste.title='',
                    $("#editor1").summernote('code','')
                this.affichage=true,
                    this.ajout=false,
                    this.vue=false,
                    this.modif=false

            }).catch(err=>{
                $.gritter.add({
                    title:"Erreur!!!!",
                    time:2000,
                    text:"Echec lors du commentaire!",
                    class_name:"color danger"});
                console.log(err.response.data)
            })


        },
        editPoste(post){
            this.affichage=false,
                this.ajout=false,
                this.vue=false,
                this.modif=true
            this.updatepost=post;

            $("#editor2").summernote('code',this.updatepost.body)



        },
        updatePoste(){

            this.updatepost.body=($("#editor2").summernote('code'))
            instance.put('update_poste/'+this.updatepost.id,this.updatepost).then(res=> {

                console.log(res.data);
                $.gritter.add({
                    title:"Modification",
                    time:2000,
                    text:"Modification effectué avec Success.",
                    class_name:"color success"});
                this.affichage=true,
                    this.ajout=false,
                    this.vue=false,
                    this.modif=false

                this.loadDatas();
            }).catch(err=>{

                $.gritter.add({
                    title:"Modification",
                    time:2000,
                    text:"Echec de la Modification de l' Article",
                    class_name:"color danger"});
                console.log(err.response.data)
            })
        },
        plusPost(post){

            this.infopost=post
            instance.put('loadposte_User/'+this.infopost.id,this.infopost).then(res=> {
                this.comment=res.data.comment
                this.nom=res.data.user
                console.log(this.comment)
                this.loadDatas();
            })

            this.affichage=false,
                this.ajout=false,
                this.vue=true,
                this.modif=false
        },

        del(post){
            this.deletepost=post
            instance.get('delete_post/'+this.deletepost.id).then(res=>{
                this.loadDatas()
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Le Poste a été supprimer avec Success",
                    class_name:"color success"});

            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Supppression du Poste",
                    class_name:"color danger"});
            })
        },
        delcomment(com){
            this.newComment.post_id=com.id
            this.deletecomment=com
            instance.get('delete_comment/'+this.deletecomment.id).then(res=>{
                var bb=this.comment.indexOf(5);
                this.comment.split(bb,1)
                this.loadDatas()
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Le commentaire a été supprimer avec Success",
                    class_name:"color success"});


            }).catch(err=>{
                $.gritter.add({
                    title:"Suppresion",
                    time:2000,
                    text:"Erreur de Supppression du commentaire",
                    class_name:"color danger"});
            })

        },

        loadDatas(){

            instance.get('load_poste').then(res=>{
                this.Poste=res.data.listepost




            }).catch(err=>{
                console.log(err.response.data);
            })


        }

    },
    mounted(){
        this.loadDatas();
        $("#editor1").summernote({height: 300})
        $("#editor2").summernote({height: 300})
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
            Blog
        }


    }

)
