package models

type FeedbackCalificacionContratista struct {
	Id_servicesContract int64  `json:”id_servicescontract”`
	Id_profile          int64  `json:"id_profile"`
	Id_contractor       int64  `json:"id_contractor"`
	Customer_review     string `json:"customer_review"`
	Contractor_review   string `json:"contractor_review"`
	Customer_rating     int64  `json:"customer_rating"`
	Contractor_rating   int64  `json:"contractor_rating"`
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
