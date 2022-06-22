package models

import "time"

type ListarProvinciaCliente struct {
	Id           int64     `json:"id"`
	Name         string    `json:"name"`
	Country_id   int64     `json:"country_id"`
	Country_code string    `json:"country_code"`
	Fips_code    string    `json:"fips_code"`
	Iso2         string    `json:"iso2"`
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
