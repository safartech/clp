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
        // alert('hello')
        moment.locale('fr')
        this.init()

        this.loadClasses()
    },
    methods:{

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
    components:{ home }

})