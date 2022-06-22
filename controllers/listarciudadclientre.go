package controllers

import (
	"encoding/json"
	_ "encoding/json"
	"net/http"
	"test-app-v1/configuraciones"
	_ "test-app-v1/configuraciones"

	"test-app-v1/models"

	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
	_ "github.com/jmoiron/sqlx"
)

func GetListarCiudadCliente(w http.ResponseWriter, r *http.Request) {

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)
	query := `select cities.id, cities.name, cities.state_id, cities.state_code, cities.country_id, cities.country_code, 
	cities.latitude, cities.longitude, cities.created_at, cities.updated_at, cities.flag, cities.wikidataid
	from cities 
	inner join ProfileAddress on cities.id = ProfileAddress.id_city 
	inner join Profiles on ProfileAddress.id_profile = Profiles.id 
	WHERE Profiles.id = 2;`

	q_ListarCiudadCliente := []models.ListarCiudadCliente{}
	db.Select(&q_ListarCiudadCliente, query)

	if err != nil {
		panic(err)
	}

	//fmt.Println(q_usuarios)
	json.NewEncoder(w).Encode(q_ListarCiudadCliente)
	db.Close()
}

/*
func CreateUbicacionServContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Crea ServContratistas")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var UbicacionServContratistas models.UbicacionServContratistas

	err = json.Unmarshal(body, &UbicacionServContratistas)
	if err != nil {
		panic("fuck")
	}
	/*fmt.Println("id:" + string(user.Id))
	fmt.Println("nombre:" + user.Name)
	fmt.Println("clave:" + user.Password)
	fmt.Println("rol:" + string(user.Idrole))

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `insert into ServicesSupplierLocations (id_servicessupplier, id_country, id_state, id_city, available)
	values(:id_servicessupplier, :id_country, :id_state, :id_city, :available)
	;`
	result, err := db.NamedExec(query, UbicacionServContratistas)
	_ = result

	db.Close()

}

func ActualizaUbicacionServContratistas(w http.ResponseWriter, r *http.Request) {

	fmt.Fprintf(w, "hola desde Actualiza Contratista")
	body, err := ioutil.ReadAll(io.LimitReader(r.Body, 1048576))

	if err != nil {
		panic("crap")
	}

	var UbicacionServContratistas models.UbicacionServContratistas

	err = json.Unmarshal(body, &UbicacionServContratistas)
	if err != nil {
		panic("fuck")
	}

	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	query := `update
	ServicesSupplierLocations set
				id_servicessupplier =case when :id_servicessupplier IS NULL or :id_servicessupplier = '' then id_servicessupplier else :id_servicessupplier end,
				id_country =case when :id_country IS NULL or :id_country = '' then id_country else :id_country end,
				id_state =case when :id_state IS NULL or :id_state = '' then id_state else :id_state end,
				id_city =case when :id_city IS NULL or :id_city = '' then id_city else :id_city end,
				available =case when :available IS NULL or :available = '' then available else :available end
			  where id=:id;`
	result, err := db.NamedExec(query, UbicacionServContratistas)
	_ = result

	db.Close()

}
*/
