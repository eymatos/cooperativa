package models

import "time"

type ListarCiudadCliente struct {
	Id           int64     `json:"id"`
	Name         string    `json:"name"`
	State_id     int64     `json:"state_id"`
	State_code   string    `json:"state_code"`
	Country_id   int64     `json:"country_id"`
	Country_code string    `json:"country_code"`
	Latitude     float32   `json:"latitude"`
	Longitude    float32   `json:"longitude"`
	Created_at   time.Time `json:"created_at"`
	Updated_at   time.Time `json:"updated_at"`
	Flag         int64     `json:"flag"`
	WikiDataId   string    `json:"wikidataid"`
}

/*{
	"date_due": "2022-06-01",
	"id_profile": "99",
	"id_contractor": "500"
	"id_servicesSupplier": "25"
	"notes": ""
	"amount_charged": "5000.00"
}
*/
