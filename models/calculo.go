package models

/*

Notas: Usando sqlx se puede enviar un array de struct directo a json, se debe tener en cuenta que si el campo en la tabla es null el struct debe estar
definido como sql.Null, ejemplo sql.NullString. La mejor practica es evitar enviar valores nulos a las tablas

*/

type Calculo struct {
	Deuda   float64 `json:"deuda"`
	Anos    int64   `json:"anos"`
	Interes int64   `json:"interes"`
}
