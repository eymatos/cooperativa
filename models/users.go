package models

/*

Notas: Usando sqlx se puede enviar un array de struct directo a json, se debe tener en cuenta que si el campo en la tabla es null el struct debe estar
definido como sql.Null, ejemplo sql.NullString. La mejor practica es evitar enviar valores nulos a las tablas

*/

import "time"

type Article struct {
	Tittle  string `json:"Tittle"`
	Desc    string `json:"desc"`
	Content string `json:"content"`
}

type Usuarios struct {
	Id          int64     `json:"id"`
	Name        string    `json:"name"`
	Email       string    `json:"email"`
	UserName    string    `json:"username"`
	Password    string    `json:"password"`
	Status      string    `json:"status"`
	Created     time.Time `json:"created"`
	Created_by  string    `json:"created_by"`
	Modified    time.Time `json:"modified"`
	Modified_by string    `json:"modified_by"`
}

type ResultadotoJson struct {
	Resultado string `json:"resultado"`
}
