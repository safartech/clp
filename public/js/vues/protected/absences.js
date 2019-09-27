/**
 * Created by User on 31/01/2019.
 */
import {url} from '../../base_url.js'
//        alert(baseUrl)
let instance = axios.create({
    baseURL : url
});

let Absence = {
    template:'#absence',
    data(){
        return {
            sessions:[],
            selectedSession:{},
            selectedSessionId:null,
            currentAbsents:[],
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
            // currentCours:{},
            currentHeure:{},
            currentJour:{},
            showHoraires:0,
            showProfs:0,
            showWeekends:0,
            selectedCours:{},
            selectedEvent:{
                start:{
                    format:function(){},
                },
                end:{
                    format:function(){},
                },
                appels:[],
                appel:{}
            },
            selectedappelId:0,
            hooveredCoursId:0,

            fc_options :   {
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    // right: 'month,basicWeek,basicDay',
                    right: 'custom1,custom2,month,agendaWeek,agendaDay',
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

                defaultView:'agendaWeek',
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
                    // console.log(view.type)
                    if(view.type!="listWeek"){
                        element.css('background-color', '#01579b');
                        // var cours = event.cours
                        // var moment = $('#cdt-calendar').fullCalendar('getDate');
                        // console.log(moment(event.start).format('YYYY-MM-DD'))
                        var s = event.appels.find(s=>s.cours_id == event.id && s.date == event.start.format("YYYY-MM-DD"))
                        // console.log(event.id+"/"+event.matiere+"/"+"------->"+ event.appels.length)
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
                    // alert(ev.appels.length)
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

    },
    methods:{
        reload(){
            instance.get('load_planning_for_classes_with_absences').then(resp=>{
                console.log(resp.data)
                this.classes = resp.data.classes
                this.onClasseChange(this.selectedClasseId)

                // $('#cdt-calendar').fullCalendar(this.fc_options)
            }).catch(err=>{
                console.log(err.response.data)
            })
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
            $('#select2-session').select2().on('change',(e)=>{
                let sessionId = $('#select2-session').val()
                this.selectedSession = this.sessions.find(s=>s.id==sessionId)
                this.selectedSessionId = this.selectedSession.id
            })
        },
        loadDatas(){
            instance.get('load_planning_for_classes_with_absences').then(resp=>{
                console.log(resp.data)
                this.classes = resp.data.classes
                this.sessions = resp.data.sessions

                $('#cdt-calendar').fullCalendar(this.fc_options)
            }).catch(err=>{
                console.log(err.response.data)
            })
        },
        onClasseChange(classeId){
            // alert(classeId)
            this.selectedClasseId = classeId
            this.selectedClasse = this.classes.find(it=>it.id==classeId)
            this.cours = this.selectedClasse.cours
            this.fc_options.events = [];
            this.cours.forEach(c=>{
                // console.log(c.jour.nom)
                this.fc_options.events.push({
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
                    horaire: c.horaire.nom,
                    horaires: c.horaire.debut+" - "+c.horaire.fin,
                    appel:0,
                    appels:c.appels

                })
            })

            $('#cdt-calendar').fullCalendar("destroy");
            $('#cdt-calendar').fullCalendar(this.fc_options)
            // this.loadPlanning()
            // alert(this.selectedClasse.nom)
        },

        getCall(){
            return this.selectedEvent.appels.find(s=>s.cours_id == this.selectedEvent.id && s.date == this.selectedEvent.start.format("YYYY-MM-DD"))
        },

        callDone(){
            let appel = this.selectedEvent.appels.find(it=>it.cours_id==this.selectedEvent.id && moment(it.date).format("YYYY-MM-DD") == this.selectedEvent.start.format("YYYY-MM-DD"))
            // console.log(!!appel)
            return !!appel;
        },

        cdtEventClick(ev){
            this.selectedEvent = ev
            this.currentAbsents = []

            console.log(this.callDone())
            if(this.callDone()){
                let appel = this.getCall()
                // console.log(appel.absences.length)
                this.selectedEvent.appel = appel
                this.selectedappelId = appel.id
                let absts = []
                appel.absences.forEach(abs=>{
                    absts.push(abs.id)
                })
                this.currentAbsents = absts
            }else {
                this.selectedEvent.appel = {}
            }

            $('#list-modal').modal('show')
        },
        saveAbsents(){
            console.log(this.currentAbsents)
            var appel = {
                cours_id: this.selectedEvent.id,
                session_id:this.selectedSessionId,
                date: this.selectedEvent.start.format("YYYY-MM-DD"),
                absents: this.currentAbsents
            }
            instance.post('set_absents',appel).then(res=>{
                console.log(res.data)
                this.reload()
                $.gritter.add({
                    title:"Liste de présence ",
                    time:2000,
                    text:"Liste de présence enregistrée avec success",
                    class_name:"color success"
                });
            }).catch(err=>{
                console.log(err.response.data)
                this.reload()
                $.gritter.add({
                    title:"Liste de présence ",
                    time:4000,
                    text:"Liste de présence non enregistrée",
                    class_name:"color danger"
                });
            })

        }
    }
};

let vm = new Vue({
    el:'#app',
    data:{},
    components:{ Absence }
})