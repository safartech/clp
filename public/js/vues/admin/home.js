import {url} from '../../base_url.js'

let instance=axios.create({
    baseURL: url
})

let home={

    template: '#homes',
    data(){
        return{
            parents:0,
            profs:0,
            eleves:0,

        }
    },
    mounted(){
         alert('hello')
        moment.locale('fr')

        this.loadDatas()
    },
    methods:{

        loadDatas(){
            this.parents=5
            this.profs=6
            this.eleves=7
            // instance.get('load_admin_home')
            //     .then((response)=> {
            //         console.log(response.data)
            //         this.parents=response.data.parents
            //         this.profs=response.data.profs
            //         this.eleves=response.data.eleves
            //
            //     })
            //     .catch( (error) => {
            //         console.log(error.response.data);
            //     })
        },


    },

}

let vm=new Vue({

    el:'#app',
    data: {},
    mounted(){
    },

    methods:{},
    components:{ home }

})