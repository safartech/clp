/**
 * Created by Aleck on 20/02/2019.
 */
import {url} from '../../base_url.js'
let instance = axios.create({
    baseURL : url
});

let Account={
    template:"#account",
    data(){
        return {
            seting:{

                email:'',
                emailold:'',
                password : '',
                passwordold : '',
            },
            userId:{},
        }
    },
    methods:{





        para(az){
            this.userId=az



        },

        para(){

            instance.put('update_settingUser',this.seting).then(res=> {
                if(res.data == 200){
                    $.gritter.add({
                        title:"Modification",
                        time:2000,
                        text:"Mdification avec success",
                        class_name:"color success"});
                }else if(res.data == 0) {
                    $.gritter.add({
                        title:"Modification",
                        time:4000,
                        text:"Ancien mot de passe incorrecte",
                        class_name:"color danger"});
                }else {
                    $.gritter.add({
                        title:"Modification",
                        time:2000,
                        text:"Une erreur s'est produite",
                        class_name:"color danger"});
                }



            }).catch(err=>{

                $.gritter.add({
                    title:"Modification",
                    time:2000,
                    text:"Echec de la Modification de l' Article",
                    class_name:"color danger"});
                console.log(err.response.data)
            })
        },

        loadDatas(){
            instance.get('load_mail').then(res=>{
                this.seting.email=res.data

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
            Account
        }


    }

)

