(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-32e82679"],{4650:function(e,t,n){},a3e1:function(e,t,n){"use strict";n("4650")},c024:function(e,t,n){"use strict";n.r(t);var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("div",{style:{display:"flex","justify-content":"center","padding-bottom":"15px"}},[n("v-btn",{attrs:{disabled:!(e.selectedJobs.length>0),color:"green"},on:{click:function(t){e.dialog=!0}}},[e._v("Assigner")])],1),e._v(" "),n("v-data-table",{ref:"table",attrs:{headers:e.headers,items:e.jobs,"item-key":"id","show-select":""},scopedSlots:e._u([{key:"header.data-table-select",fn:function(){},proxy:!0},{key:"item.job_category",fn:function(t){var n=t.item;return[e._v("\n      "+e._s(n.job_category.name)+"\n    ")]}},{key:"item.created_at",fn:function(t){var a=t.item;return[n("v-tooltip",{attrs:{bottom:"",disabled:e.isTouchscreen},scopedSlots:e._u([{key:"activator",fn:function(t){var s=t.on,i=t.attrs;return[n("span",e._g(e._b({},"span",i,!1),s),[e._v(e._s(e.moment(a.created_at).fromNow()))])]}}],null,!0)},[e._v(" "),n("span",[e._v("Déposé le "+e._s(e.moment(a.created_at).format("DD/MM/YYYY")))])])]}},{key:"item.deadline",fn:function(t){var a=t.item;return[n("v-tooltip",{attrs:{bottom:"",disabled:e.isTouchscreen},scopedSlots:e._u([{key:"activator",fn:function(t){var s=t.on,i=t.attrs;return[n("span",e._g(e._b({},"span",i,!1),s),[e._v(e._s(e.moment(a.deadline).fromNow()))])]}}],null,!0)},[e._v(" "),n("span",[e._v("Jusqu'au "+e._s(e.moment(a.deadline).format("DD/MM/YYYY")))])])]}},{key:"item.client_name",fn:function(t){var a=t.item;return[n("v-tooltip",{attrs:{bottom:"",disabled:e.isTouchscreen},scopedSlots:e._u([{key:"activator",fn:function(t){var s=t.on,i=t.attrs;return[n("span",e._g(e._b({},"span",i,!1),s),[e._v(e._s(a.client.name.charAt(0)+"."+a.client.surname))])]}}],null,!0)},[e._v(" "),n("span",[e._v(e._s(a.client.name+" "+a.client.surname))])])]}},{key:"item.description",fn:function(t){var a=t.item;return["null"!==a.description?n("v-dialog",{attrs:{"max-width":"80%","content-class":"comment"},scopedSlots:e._u([{key:"activator",fn:function(t){var a=t.on,s=t.attrs;return[n("v-btn",e._g(e._b({attrs:{text:""}},"v-btn",s,!1),a),[n("v-icon",[e._v(e._s(e.mdiCommentEyeOutline))])],1)]}}],null,!0)},[e._v(" "),n("v-card",[n("v-card-title",{staticClass:"text-h5"},[e._v(" Commentaire ")]),e._v(" "),n("v-card-text",[e._v(e._s(a.description))])],1)],1):n("span",[e._v("Aucun")])]}}]),model:{value:e.selectedJobs,callback:function(t){e.selectedJobs=t},expression:"selectedJobs"}}),e._v(" "),n("v-dialog",{attrs:{width:"450"},model:{value:e.dialog,callback:function(t){e.dialog=t},expression:"dialog"}},[n("v-card",[n("v-card-title",{staticClass:"headline grey lighten-2"},[e._v("\n        Attribution des demandes\n      ")]),e._v(" "),n("v-card-text",[n("br"),e._v(" "),n("br"),e._v("\n        "+e._s(e.assignText)+"\n      ")]),e._v(" "),n("v-divider"),e._v(" "),n("v-card-actions",[n("v-spacer"),e._v(" "),n("v-btn",{attrs:{color:"red",text:""},on:{click:function(t){e.dialog=e.loading=!1}}},[e._v("\n          Annuler\n        ")]),e._v(" "),n("v-btn",{attrs:{color:"primary",text:"",loading:e.loading},on:{click:e.assign}},[e._v("\n          Valider\n        ")])],1)],1)],1)],1)},s=[],i=n("5530"),o=(n("d3b7"),n("d81d"),n("4de4"),n("2f62")),r=n("94ed"),c=n("c1df"),l=n.n(c),d={data:function(){return{headers:[{text:"Travail",value:"job_category"},{text:"Date de création",value:"created_at"},{text:"Échéance",value:"deadline"},{text:"Client",value:"client_name"},{text:"Commentaire",value:"description",align:"center",sortable:!1}],dialog:!1,loading:!1,selectedJobs:[],mdiCommentEyeOutline:r["f"],moment:l.a}},methods:Object(i["a"])(Object(i["a"])({},Object(o["b"])(["retrieveUnassignedJobs","assignJob"])),{},{assign:function(){var e=this;this.loading=!0,this.assignJob(this.selectedJobs.map((function(e){return e.id}))).then((function(t){e.$notify("success filled","Demandes assignées !","Les demandes vous ont été assignés",{duration:4e3,permanent:!1}),e.dialog=!1})).catch((function(t){console.log(t),e.$notify("error filled","Échec de l'assignation !","Les demandes n'ont pas pu vous être assignées",{duration:4e3,permanent:!1})})).finally((function(){e.loading=!1}))}}),computed:Object(i["a"])(Object(i["a"])({},Object(o["c"])({jobs:"getUnassignedJobs"})),{},{isTouchscreen:function(){return"ontouchstart"in window},assignText:function(){var e=" demandes vont vous être attribuées.";return 1===this.selectedJobs.length&&(e=" demande va vous être attribuée."),this.selectedJobs.length+e+" Souhaitez-vous continuer ?"}}),watch:{jobs:function(){var e=this;this.selectedJobs=this.jobs.filter((function(t){return e.$refs.table.isSelected(t)})),this.dialog&&0===this.selectedJobs.length&&(this.dialog=this.loading=!1)}},mounted:function(){this.retrieveUnassignedJobs()}},u=d,v=(n("a3e1"),n("2877")),m=Object(v["a"])(u,a,s,!1,null,null,null);t["default"]=m.exports}}]);