/*

El  Middleware se encarga de agregar logica personalizada al manejo de rutas, como manejo de roles y jwt validation.

*/

package main

import (
	"fmt"
	"log"
	"net/http"
	"strings"
	"test-app-v1/configuraciones"
	"time"

	"github.com/dgrijalva/jwt-go"
	mux "github.com/gorilla/mux"

	"github.com/google/uuid"
)

var users = map[string]string{"user1": "password1", "user2": "password2"}

func requestIDHandler(next http.Handler) http.Handler {

	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-type", "application/json; charset=UTF8")
		requestID := r.Header.Get("x-Request-ID")

		if len(requestID) == 0 {
			requestID = uuid.NewString()
			w.Header().Set("x-Request-ID", requestID)
		}
		next.ServeHTTP(w, r)
	})

}

func loggingMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		// Do stuff here
		log.Println("Request==>")
		log.Println(r)
		log.Println("Response==>")
		log.Println(w)
		// Call the next handler, which can be another middleware in the chain, or the final handler.
		next.ServeHTTP(w, r)
	})
}

var secretKey = configuraciones.JwtSecretKey

func authMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		// Do stuff here

		authorizationHeader := r.Header.Get("Authorization")

		if authorizationHeader != "" {
			bearerToken := strings.Split(authorizationHeader, " ")
			if len(bearerToken) == 2 {
				token, err := jwt.Parse(bearerToken[1], func(token *jwt.Token) (interface{}, error) {
					if _, ok := token.Method.(*jwt.SigningMethodHMAC); !ok {
						return nil, fmt.Errorf("Unauthorized")
					}
					return secretKey, nil

				})
				if err != nil {
					w.WriteHeader(http.StatusUnauthorized)
					w.Write([]byte(err.Error()))
					return
				}
				if token.Valid {
					//endpoint(w, r)
					next.ServeHTTP(w, r)
				}
			}
		} else {
			w.WriteHeader(http.StatusUnauthorized)
			w.Write([]byte("Unauthorized"))
		}

		/*
			fmt.Println("My simple client")
			tokenString, err := GenerateJWT()
			if err != nil {
				fmt.Println("Error Generating Token String")
			}
			fmt.Println(tokenString)
		*/

		// Call the next handler, which can be another middleware in the chain, or the final handler.
		//next.ServeHTTP(w, r)
		w.WriteHeader(http.StatusUnauthorized)
		w.Write([]byte("Unauthorized"))
	})
}

func RolesMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		// Do stuff here
		currentRoute := mux.CurrentRoute(r)
		if currentRoute != nil {
			fmt.Println(currentRoute.GetName())
		}

		// Call the next handler, which can be another middleware in the chain, or the final handler.
		next.ServeHTTP(w, r)
	})
}

func timeHandler(format string) http.Handler {
	fn := func(w http.ResponseWriter, r *http.Request) {
		tm := time.Now().Format(format)
		w.Write([]byte("The time is: " + tm))
	}
	return http.HandlerFunc(fn)
}
