/*
En este archivo se definen las rutas de la aplicacion de backend


*/

package main

import (
	"log"
	"net/http"
	"test-app-v1/configuraciones"
	c "test-app-v1/controllers"
	"test-app-v1/seguridad"
	"time"

	"github.com/gorilla/mux"
)

func handleRequest() {

	myRouter := mux.NewRouter().StrictSlash(true)
	publica := myRouter.NewRoute().Subrouter()
	privada := myRouter.NewRoute().Subrouter()

	/*Logica Middleware para aplicar reglas a todas las rutas*/
	myRouter.Use(requestIDHandler)
	//myRouter.Use(loggingMiddleware)

	/*Logica Middleware para aplicar reglasd solo a rutas protegidas ex: la funcion authMiddleware esta definida en middleware.go*/
	privada.Use(authMiddleware)
	//privada.Use(RolesMiddleware)

	/*Listado de Rutas Publicas que no requieren login o permisos*/
	publica.HandleFunc("/", homePage)
	publica.HandleFunc("/login", seguridad.Login).Methods("POST")
	publica.HandleFunc("/usuarios", getqueryUsuarios).Methods("GET")
	publica.HandleFunc("/usuarios", c.CreateUsuarios).Name("CrearUsuarios").Methods("POST")
	publica.HandleFunc("/usuarios", c.ActualizaUsuarios).Methods("PUT")
	publica.HandleFunc("/roles", c.GetRoles).Methods("GET")
	publica.HandleFunc("/roles", c.CreateRoles).Methods("POST")
	publica.HandleFunc("/roles", c.ActualizaRoles).Methods("PUT")
	publica.HandleFunc("/contratistas", c.GetContratistas).Methods("GET")
	publica.HandleFunc("/contratistas", c.CreateContratistas).Methods("POST")
	publica.HandleFunc("/contratistas", c.ActualizaContratistas).Methods("PUT")
	publica.HandleFunc("/seviciocontratistas", c.GetServContratistas).Methods("GET")
	publica.HandleFunc("/seviciocontratistas", c.CreateServContratistas).Methods("POST")
	publica.HandleFunc("/seviciocontratistas", c.ActualizaServContratistas).Methods("PUT")
	publica.HandleFunc("/ubicacionservcontratistas", c.GetUbicacionServContratistas).Methods("GET")
	publica.HandleFunc("/ubicacionservcontratistas", c.CreateUbicacionServContratistas).Methods("POST")
	publica.HandleFunc("/ubicacionservcontratistas", c.ActualizaUbicacionServContratistas).Methods("PUT")

	publica.HandleFunc("/listarticketscontratistas", c.GetListarTicketsContratistas).Methods("GET")

	/*FeedBack y Clasificacion*/

	publica.HandleFunc("/feedbackcalificacioncr", c.CreateFeedbackCalificacionContratista).Methods("POST")
	publica.HandleFunc("/feedbackcalificacioncl", c.CreateFeedbackCalificacionCliente).Methods("POST")

	/*Perfil Cliente*/
	publica.HandleFunc("/feedbackcalificacion", c.GetFeedbackCalificacion).Methods("GET")
	publica.HandleFunc("/listarpaisescliente", c.GetListarPaisesCliente).Methods("GET")
	publica.HandleFunc("/listarciudadcliente", c.GetListarCiudadCliente).Methods("GET")
	publica.HandleFunc("/listarprovinciacliente", c.GetListarProvinciaCliente).Methods("GET")
	publica.HandleFunc("/listarhistoricocompletadocliente", c.GetListarHistoricoCompletadoCliente).Methods("GET")
	publica.HandleFunc("/listaractivoscliente", c.GetListarActivosCliente).Methods("GET")

	/*Listado de rutas Protegidas en la aplicacion

	Notas: Se esta implementando el Handle wrapper para HandlerFunc para poder pasar parametros.
	Para todas las funciones se debe implementar el argumento: Funcion(Permisos String)
	Se esta usando string por la facilidad, pero se debe considerar usar otro tipo de variable
	*/
	privada.HandleFunc("/health", HealthCheckHandler)
	privada.Handle("/time", timeHandler(time.RFC1123)).Methods("GET")
	publica.Handle("/ActualizaRoles", c.ActualizaRoles2("Super sayayin 2")).Methods("PUT")
	publica.Handle("/CrearReclamos", c.ActualizaRoles2("cliente,Administrado,backoffice")).Methods("PUT")

	//esta linea inicia el servidor
	log.Fatal(http.ListenAndServe(configuraciones.PuertoApp, myRouter))
}
