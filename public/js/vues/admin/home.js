window.onload=function(){

    var app = new Vue({
        delimiters: ['${', '}'],
        el: '#homes',
        data: {
            parents:0,
            profs:0,
            eleves:0

        },

        mounted: function () {

            axios.get('/ajax/load_admin_home')
                .then((response)=> {
                    console.log(response.data)
                    this.parents=response.data.parents
                    this.profs=response.data.profs
                    this.eleves=response.data.eleves

                    $('#parents').html(this.parents)
                    $('#profs').html(this.profs)
                    $('#eleves').html(this.eleves)

                })
                .catch( (error) => {
                    console.log(error.response.data);
                })

            // $('#slider_container').html('');
            //
            // ul_container = "<div class='slider'>" +
            //     "<ul class=\"slides\" id='contain'>" +
            //     "</ul>" +
            //     "</div>";
            //
            // $('#slider_container').append(ul_container);
            //
            // li_container1 = "<li>" +
            //     "<img src=\"/"+ +"  \">" +
            //     "</li>";
            // $('#kaba_contain').append(kaba_li_container);
            //
            // // for (i = 0 ; i < side.init_data.kaba_pub.length ; i++){
            // //     kaba_li_container = "<li>" +
            // //         "<img src=\"/"+ side.init_data.kaba_pub[i].name+"  \">" +
            // //         "</li>";
            // //     $('#kaba_contain').append(kaba_li_container);
            // // }
            //
            // $('.slider').slider({
            //     height: 0.3 * $(window).height()
            // });

        },

        methods: {


        }
    })
}

// import {url} from '../../base_url.js'
//
// let instance=axios.create({
//     baseURL: url
// })
//
// let home={
//
//     template: '#homes',
//     data(){
//         return{
//             parents:0,
//             profs:0,
//             eleves:0,
//
//         }
//     },
//     mounted(){
//          alert('hello')
//         moment.locale('fr')
//
//         this.loadDatas()
//     },
//     methods:{
//
//         loadDatas(){
//             this.parents=5
//             this.profs=6
//             this.eleves=7
//             // instance.get('load_admin_home')
//             //     .then((response)=> {
//             //         console.log(response.data)
//             //         this.parents=response.data.parents
//             //         this.profs=response.data.profs
//             //         this.eleves=response.data.eleves
//             //
//             //     })
//             //     .catch( (error) => {
//             //         console.log(error.response.data);
//             //     })
//         },
//
//
//     },
//
// }
//
// let vm=new Vue({
//
//     el:'#app',
//     data: {},
//     mounted(){
//     },
//
//     methods:{},
//     components:{ home }
//
// })