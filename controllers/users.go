package controllers

import (
	"encoding/json"
	_ "encoding/json"
	"fmt"
	"io"
	"io/ioutil"
	"net/http"
	"test-app-v1/configuraciones"
	_ "test-app-v1/configuraciones"

	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
	_ "github.com/jmoiron/sqlx"
)

func CreateUsuarios(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde create usuarios")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var user models.Usuarios

	err = json.Unmarshal(body, &user)
	if err != nil {
		panic("fuck")
	}

	/*
		Como encriptar el password, por ahora no se usa.
		hashedPassword, err := security.Hash(user.Password)
			if err != nil {
				return nil, err
				}
			user.Password = string(hashedPassword)
	*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `insert into Users(name, email, username, password, status) 
	          values(:name,
				     :email,
					 case when :username IS NULL or :username ='' then :email else :username end,
					 :password,
					 case when :status IS NULL or :status = '' then 1 else :status end 
					 );`
	result, err := db.NamedExec(query, user)
	if err != nil {
		panic("Here we go")
	}
	_ = result

}

func ActualizaUsuarios(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza usuarios")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var user models.Usuarios

	err = json.Unmarshal(body, &user)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))*/

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `update 
	          Users set 
			  name     = case when :name IS NULL or :name ='' then name else :name end,
			  email    = case when :email IS NULL or :email ='' then email else :email end,,
			  username = case when :username IS NULL or :username ='' then username else :username end,
			  password = case when :password IS NULL or :password = '' then password else :password end
			  status   = case when :status IS NULL or :status = '' then 1 else :status end         
			  where id=:id;`
	result, err := db.NamedExec(query, user)
	_ = result

	db.Close()

}

func DesactivaUsuarios(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Desactiva usuarios")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var user models.Usuarios

	err = json.Unmarshal(body, &user)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `update 
	          Users set 
			  status = 99         
			  where id=:id;`
	result, err := db.NamedExec(query, user)
	_ = result

	db.Close()

}
