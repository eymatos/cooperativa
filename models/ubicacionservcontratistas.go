package models

type UbicacionServContratistas struct {
	Id                  int64  `json:"id"`
	Id_servicessupplier int64  `json:”id_servicesSuplier”`
	Id_country          int64  `json:"id_country"`
	Id_state            int64  `json:"id_state"`
	Id_city             int64  `json:"id_city"`
	Available           string `json:"available"`
}

/*
{
	"date_due": "2022-06-01",
	"id_profile": "99",
	"id_contractor": "500"
	"id_servicesSupplier": "25"
	"notes": ""
	"amount_charged": "5000.00"
}
*/
