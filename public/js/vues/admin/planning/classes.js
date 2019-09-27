/**
 * Created by User on 06/12/2018.
 */
import {url} from '../../../base_url.js'
//        alert(baseUrl)
let instance = axios.create({
    baseURL : url
});


let classes = {
    template:'#classes',
    data(){
        return {
            cycles:[],
            niveaux:[],
            classes:[],
            cours: [],
            currentCours : {
                id:0,
            },
            selectedCycle:{},
            selectedNiveau:{},
            selectedClasse:{},
            selectedCycleId:null,
            selectedNiveauId:null,
            selectedClasseId:null,
            jours:[],
            horaires:[],
            matieres:[],
            profs:[],
            salles:[],
            newCours:{
                classe_id:null,
                jour_id:null,
                horaire_id:null,
                matiere_id:null,
                personnel_id:null,
                salle_id:null,
            },
            dm:{},
            has_dm:false,
            // currentCours:{},
            currentHeure:{},
            currentJour:{},
            showHoraires:0,
            showProfs:0,
            showWeekends:0,
            selectedCours:{
                /*classe_id:0,
                matiere_id:0,
                personnel_id:0,
                salle_id:0,
                jour_id:0,
                horaire_id:0,*/
            },
            selectedEvent:{
                start:{
                    format:function(){},
                },
                end:{
                    format:function(){},
                },
                seances:[],
                seance:{}
            },
            selectedSeanceId:0,
            hooveredCoursId:0,

            cdt_fc_options :   {
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    // right: 'month,basicWeek,basicDay',
                    right: 'custom1,custom2,month,agendaWeek,agendaDay,listWeek',
                    // right: 'custom2, month,basicWeek,basicDay,listWeek',
                },

                customButtons: {
                    custom1: {
                        text: 'Sem.Séances',
                        click: function() {
                            $('#cdt-calendar').fullCalendar('changeView', 'basicWeek');
                        }
                    },
                    custom2: {
                        text: 'Journ.Séances',
                        click: function() {
                            $('#cdt-calendar').fullCalendar('changeView', 'basicDay');
                        }
                    }
                },

                defaultView:'listWeek',
                height: 700,
//            contentHeight: 800,

                selectable: true,
                nowIndicator: true,
                selectHelper: true,
                unselectAuto: true,

                fixedWeekCount: false,
                showNonCurrentDates: true,
                slotDuration: '00:30:00',
                slotLabelFormat: 'h(:mm)a',
                minTime: "07:00:00",
                maxTime: "18:00:00",
                // noEventsMessage: "0 events",
                // dayPopoverFormat:"DD",
                // scrollTime: "10:00:00",
                /*slotLabelInterval:{
                 duration:"01:00"
                 },*/


                allDaySlot: true,
                allDayText: "Toute la journée",
                slotEventOverlap: true,

                titleFormat: "D MMMM YYYY",
                today:    'Aujourd\'hui',
                month:    'mois',
                week:     'semaine',
                day:      'jour',
                list:     'list',

                firstDay: 1,
                locale: 'fr',
                weekends: false,
                timeFormat: 'H:mm',
                displayEventTime: true,
                displayEventEnd: true,

                eventRender:function (eb,el) {

                },

                eventAfterRender: function(event, element) {
                    // event.color = '#0ff'
                   // console.log(element)
                    // event.matiere = "Farid"
                    // color: "#01579b",
                    // color: "#00897b",
                    var view = $('#cdt-calendar').fullCalendar('getView');
                    console.log(view.type)
                    if(view.type!="listWeek"){
                        element.css('background-color', '#01579b');
                        var cours = event.cours
                        // var moment = $('#cdt-calendar').fullCalendar('getDate');
                        // console.log(moment(event.start).format('YYYY-MM-DD'))
                        var s = event.seances.find(s=>s.cours_id == event.id && s.date == event.start.format("YYYY-MM-DD"))
                        // console.log(event.id+"/"+event.matiere+"/"+"------->"+ event.seances.length)
                        // console.log(s.length)
                        if(s){
                            if(s.cours_id==event.id && s.date == event.start.format("YYYY-MM-DD")){
                                element.css('background-color', '#b71c1c');
                            }
                        }
                    }/*else {
                        element.css('color', event.couleur);
                    }*/

                    if (event.customRender == true)
                    {

                        // var el = element.html();
                        // element.html("<div style='width:90%;float:left;'>" +  el + "</div><div style='text-align:right;' class='close'><span class='mdi mdi-print'></span></div>");
                        //...etc
                    }
                },
                select: function(startDate, endDate) {
                    // alert('selected ' + startDate.format() + ' to ' + endDate.format());
//                swal(startDate.format()+"");
                },
                eventDestroy:function(event, element){},
                dayClick: function(date, jsEvent, view) {
                    // alert('Clicked on: ' + date.format());
                    // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                    // alert('Current view: ' + view.name);
                    // change the day's background color just for fun
                    // $(this).css('background-color', 'red');
                },
                /*navLinkDayClick: function(date, jsEvent) {
                 //                            $('#classe-planning').fullCalendar('changeView', 'agendaDay');
                 // console.log('day', date.format()); // date is a moment
                 // console.log('coords', jsEvent.pageX, jsEvent.pageY);
                 },*/
                navLinkWeekClick: function(weekStart, jsEvent) {
                    // alert('week start', weekStart.format()); // weekStart is a moment
                    // alert('coords', jsEvent.pageX, jsEvent.pageY);
                },

                //is triggered when external events ers dropped in fullcalendar
                drop: function(date, jsEvent, ui, resourceId ) {
                    // is the "remove after drop" checkbox checked?
//                            alert(date.format())
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },

                //Called when a valid external jQuery UI draggable, containing event data, has been dropped onto the calendar.
                eventReceive:function( event, view){
                    console.log(event.start)
//                            $('#createCourseModal').openModal()
                    /*event.title = "FORA"
                     //                            event.rendering =  "background"
                     event.color = "#ffe688"
                     event.start = new Date("2018-05-17T09:30")
                     event.end = new Date("2018-05-17T10:30")
                     //                        event.start = moment(new Date("2018-05-17T09:30"))
                     //                        event.end = moment("2018-05-17T10:30")
                     console.log("new Date()",new Date())
                     console.log("new Date()",new Date("2018-05-17T09:30"))
                     console.log("moment()",moment())
                     console.log("moment(new DAte())",moment(new Date()))*/

//                            $('#classe-planning').fullCalendar('updateEvent', event);
//                            $('#classe-planning').fullCalendar('renderEvent', event);
//                                alert(event.start)
                },

                //Triggered when dragging stops and the inner calendar event has moved to a different day/time.
                eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ){
//                            console.log(event.start)
                },

                eventClick:(ev,jsEvent,view)=>{
                    // alert()
                    // this.showEventDetails(ev);
                    this.cdtEventClick(ev)
                },


                views: {
                    agendaFourDay: {
                        type: 'agenda',
                        duration: { days: 4 },
                        buttonText: '4 day',
                        dayCount: 4,
                    },
                    basic: {
                        // options apply to basicWeek and basicDay views
                    },
                    agenda: {
                        // options apply to agendaWeek and agendaDay views
                    },
                    month:{
                        // titleFormat: 'YYYY, MM, DD'
                    },
                    week: {
                        // options apply to basicWeek and agendaWeek views
                    },
                    day: {
                        // options apply to basicDay and agendaDay views
                    }
                },

//            defaultDate: '2018-05-12',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                droppable: true, // this allows things to be dropped onto the calendar
                eventLimit: true, // allow "more" link when too many events
                // businessHours: true,
                eventLimitClick: "popover",

                events:[]

            },
        }
    },
    mounted(){
        moment.locale('fr')
        this.loadDatas()
        this.initView()
    },
    computed:{
        isReady(){
            return this.selectedClasseId !=0
        },
        readyToCreateCours(){
            return this.newCours.classe_id!==null
            && this.newCours.jour_id!==null
            && this.newCours.horaire_id!==null
            && this.newCours.matiere_id!==null
            && this.newCours.personnel_id!==null
            // && this.newCours.salle_id!==0
        },
        showWeekend(j){
            return true
        },
        cdtExists(){
            return this.selectedEvent.seance.id != null
        }


    },
    methods:{
        moment(date){
            return new moment(date).locale('fr')
        },
        hooveredTd(jour,h){
            var c = this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)
            if(c){
                if (this.hooveredCoursId == c.id){
                    return "primary"
                }
            }
        },
        hooverCoursTd(jour,h){
            var c = this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)
            if(c) this.hooveredCoursId = c.id
        },
        isWeekend(jour){
            if(jour.is_week_end){
                return jour.is_week_end == this.showWeekends
            }
            return true
        },
        reload(){
            this.loadDatas()
            this.onClasseChange(this.selectedClasseId)
        },
        getAccordionEncorId(jour){
            return "#"+jour.nom
        },
        getParsedCours(j){
            var cours = []
            if(this.selectedClasseId){
                cours = j.cours.filter(x=>x.classe_id==this.selectedClasseId)
                return cours
            }
            return cours

        },
        initView(){
            $('#select2-classe')
            // init select2
                .select2()
                .trigger('change')
                // emit event on change.
                .on('change',(e)=> {
                    // alert($('#select2-classe').val())
                    this.onClasseChange($('#select2-classe').val())
                });
            $('#select2-cours-classe').select2().trigger('change').on('change',(e)=>{this.newCours.classe_id = $('#select2-cours-classe').val()})
            $('#select2-cours-jour').select2().trigger('change').on('change',(e)=>{this.newCours.jour_id = $('#select2-cours-jour').val()})
            $('#select2-cours-horaire').select2().trigger('change').on('change',(e)=>{this.newCours.horaire_id = $('#select2-cours-horaire').val()})
            $('#select2-cours-matiere').select2().trigger('change').on('change',(e)=>{this.newCours.matiere_id = $('#select2-cours-matiere').val()})
            $('#select2-cours-prof').select2().trigger('change').on('change',(e)=>{this.newCours.personnel_id = $('#select2-cours-prof').val()})
            $('#select2-cours-salle').select2().trigger('change').on('change',(e)=>{this.newCours.salle_id = $('#select2-cours-salle').val()})
        },
        createNewCours(){
          instance.post("create_cours",this.newCours).then(res=>{
              this.cours.push(res.data);
              $.gritter.add({
                  // (string | mandatory) the heading of the notification
                  title: 'Nouveau cours ajouter avec success',
                  // (string | mandatory) the text inside the notification
                  class_name: 'color success',
                  time: 3000,
                  position: 'top-right',
                  sticky: false
              });
              // this.cours.push(this.newCours)
              this.reload()
          }).catch(err=>{
              console.log(err.response.data)
              $.gritter.add({
                  // (string | mandatory) the heading of the notification
                  title: 'Echec',
                  // (string | mandatory) the text inside the notification
                  class_name: 'color danger',
                  time: 3000,
                  position: 'top-right',
                  sticky: false
              });

          })
        },
        loadDatas(){
            instance.get('load_planning_for_classes_from_admin').then(resp=>{
                // console.log(resp.data)
                this.classes = resp.data.classes
                this.jours = resp.data.jours
                this.horaires = resp.data.horaires
                this.matieres = resp.data.matieres
                this.salles = resp.data.salles
                this.profs = resp.data.profs

                $('#cdt-calendar').fullCalendar(this.cdt_fc_options)
            }).catch(err=>{
                console.log(err.response.data)
            })
        },
        /*loadPlanning(){
            instance.get('load_classe_horaire/'+this.selectedClasseId)
                .then(resp=>{
                    console.log(resp.data)
                    this.horaires = resp.data.horaires
                })
                .catch(err=>{
                    console.log(err.response.data)
                })
        },*/
        getCoursMatiere(jour,h){
            var c = this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)
            if(c)
                return c.matiere.intitule
            return ""
        },
        getCoursMatiereColor(jour,h){
            var c = this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)
            if(c)
                return c.matiere.couleur
            return ""
        },
        getCoursProf(jour,h){
            var c = this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)
            if(c)
                return c.prof.nom_complet
            return ""
        },
        getCoursMatiereColor(jour,h){
            // console.log("MAMA",jour)
            var c = this.cours.find(x=>x.jour_id==jour && x.horaire_id == h)
            if(c){
                // console.log(c.matiere.couleur)
                return c.matiere.couleur
            }
            return ""
        },
        onClasseChange(classeId){
            // alert(classeId)
            this.selectedClasseId = classeId
            this.selectedClasse = this.classes.find(it=>it.id==classeId)
            this.cours = this.selectedClasse.cours
            this.cdt_fc_options.events = [];
            this.cours.forEach(c=>{
                // console.log(c.jour.nom)
                this.cdt_fc_options.events.push({
                    //basic properties
                    id:c.id,
                    title:c.matiere.intitule,
                    // color: "#01579b",
                    color: "#01579b",
                    couleur: c.matiere.couleur,
                    textColor:"#fff",
                    // textColor:"#000",
                    start: c.horaire?c.horaire.debut:"",
                    end:c.horaire?c.horaire.fin:"",
                    allDay: false,
                    eventStartEditable: false,
                    eventDurationEditable: false,
                    dow:[c.jour.dow],
                    customRender: true,
                    //extra properties
                    classe:c.classe.nom,
                    matiere:c.matiere.intitule,
                    prof:c.prof.nom_complet,
                    salle:c.salle?c.salle.nom:"",
                    horaire: c.horaire.debut+" - "+c.horaire.fin,
                    appel:0,
                    seances:c.seances

                })
            })

            $('#cdt-calendar').fullCalendar("destroy");
            $('#cdt-calendar').fullCalendar(this.cdt_fc_options)
            // this.loadPlanning()
            // alert(this.selectedClasse.nom)
        },

        cdtEventClick(ev){

            this.selectedEvent = ev
            if(this.selectedEvent.seances.length>0){
                let seance = this.selectedEvent.seances.find(s=>s.cours_id == this.selectedEvent.id && s.date == this.selectedEvent.start.format("YYYY-MM-DD"))
                if(seance){
                    this.selectedEvent.seance = seance
                    this.selectedSeanceId = seance.id
                    this.has_dm = seance.dm
                }else {
                    this.selectedEvent.seance = {dm:false}
                }
            }else {
                this.selectedEvent.seance = {
                    dm:false
                }
            }
            console.log(this.selectedEvent.seance)
            $('#cdt-create-modal').modal('show')
        },

        showCdtCreatorModal(ev){

        },

        showCdtUpdatorModal(ev){

        },

        showCoursUpdatorModal(jour,h){
            // this.selectedCours = this.cours.filter(x=>x.jour_id==jour.id && x.horaire_id == h.id)[0]
            this.currentHeure = h
            this.currentJour = jour
            if (this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)){
                this.selectedCours = this.cours.find(x=>x.jour_id==jour.id && x.horaire_id == h.id)
                $('#update-cours-modal').modal('show')
            }else {
                this.newCours.classe_id = this.selectedClasseId
                this.newCours.jour_id = this.currentJour.id
                this.newCours.horaire_id = this.currentHeure.id
                $('#create-cours-modal').modal('show')
            }

        },
        updateCours(){
            // console.log(this.selectedCours)
            instance.put('update_cours/'+this.selectedCours.id,this.selectedCours).then(res=>{
                console.log(res.data)
                $.gritter.add({
                    title:"Cours mis à jour",
                    class_name:'color success',
                    time:1000,
                    position:'top-right'
                })
            }).catch(err=>{
                console.log(err.response.data)
                $.gritter.add({
                    title:"Erreur",
                    class_name:'color danger',
                    time:3000,
                    position:'top-right'
                })
            })
        },
        deleteCours(){
            instance.get('delete_cours/'+this.selectedCours.id).then(res=>{
                console.log(res.data)
                this.cours.splice(this.cours.indexOf(this.selectedCours),1)
                $.gritter.add({
                    title:"Cours supprimé",
                    class_name:'color success',
                    time:1000,
                    position:'top-right'
                })
                this.reload()
            }).catch(err=>{
                console.log(err.response.data)
                $.gritter.add({
                    title:"Erreur",
                    class_name:'color danger',
                    time:3000,
                    position:'top-right'
                })
            })
        },
        createSeance(){
            let data = {};
            let cdt = {
                cours_id:this.selectedEvent.id,
                date: this.selectedEvent.start.format("YYYY-MM-DD"),
                titre:this.selectedEvent.seance.titre,
                contenu:this.selectedEvent.seance.contenu,
                dm:this.has_dm,
                echeance: this.selectedEvent.seance.echeance,
                desc: this.selectedEvent.seance.desc,
            };
            data['cdt'] = cdt
            // if(this.has_dm) data['dm'] = this.dm
            instance.post('store_cdt',data).then(res=>{
                console.log(res.data)
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'Cahier de texte enrégistrer avec success',
                    // (string | mandatory) the text inside the notification
                    class_name: 'color success',
                    time: 2000,
                    position: 'top-right',
                    sticky: false
                });
            }).catch(err=>{
                console.log(err.response.data)
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: "Erreur d'enrégistement",
                    // (string | mandatory) the text inside the notification
                    class_name: 'color danger',
                    time: 3000,
                    position: 'top-right',
                    sticky: false
                });
            })
        },
        updateSeance(){
            let data = {};
            let cdt = {
                id:this.selectedEvent.seance.id,
                cours_id:this.selectedEvent.id,
                date: this.selectedEvent.start.format("YYYY-MM-DD"),
                titre:this.selectedEvent.seance.titre,
                contenu:this.selectedEvent.seance.contenu,
                dm:this.has_dm,
                echeance: this.selectedEvent.seance.echeance,
                desc: this.selectedEvent.seance.desc,
            };
            data['cdt'] = cdt
            // if(this.has_dm) data['dm'] = this.dm
            instance.put('update_cdt/'+cdt.id,data).then(res=>{
                console.log(res.data)
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'Cahier de texte enrégistrer avec success',
                    // (string | mandatory) the text inside the notification
                    class_name: 'color success',
                    time: 2000,
                    position: 'top-right',
                    sticky: false
                });
            }).catch(err=>{
                console.log(err.response.data)
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: "Erreur d'enrégistement",
                    // (string | mandatory) the text inside the notification
                    class_name: 'color danger',
                    time: 3000,
                    position: 'top-right',
                    sticky: false
                });
            })
        },
    }
};

let vm = new Vue({
    el:"#app",
    data:{},
    components:{ classes },
    mounted(){}
})