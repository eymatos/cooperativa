/*
github.com/lib/pq libreria de p(postgres)q(query)
*/

package main

import (
	"context"
	"database/sql"
	"fmt"

	"github.com/jmoiron/sqlx"

	"test-app-v1/configuraciones"

	_ "github.com/go-sql-driver/mysql"
)

//func createConnection() (*sql.DB, error) {
func createConnection() (*sqlx.DB, error) {

	//db, err := sql.Open("mysql", configuraciones.ConnectionString)
	db, err := sqlx.Connect("mysql", configuraciones.ConnectionString)

	if err != nil {
		panic(err)
	}

	db.SetMaxOpenConns(10)

	err = db.Ping()

	if err != nil {
		panic(err)
	}

	return db, nil
}

func insertaUsuarios(ctx context.Context, db *sql.DB) error {

	query := `INSERT INTO Users(name,password) values(?,?)`
	result, err := db.ExecContext(ctx, query, "dev4", "4567")

	if err != nil {
		panic(err)
	}

	id, err := result.LastInsertId()
	fmt.Println("insert id:", id)

	return nil
}
