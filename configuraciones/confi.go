/*
paquete para centralizar variables de configuraciones
db, err := sqlx.Connect("postgres", fmt.Sprintf("user=%s password=%s host=%s port=%s sslmode=%s connect_timeout=%d %s", p.Username, p.Password, p.Host, p.Port, p.SSLmode, p.Timeout, p.Option))

func createDb(spec string) (*sqlx.DB, error) {
	db, err := sqlx.Connect("mysql", spec+"?parseTime=true&charset=utf8mb4,utf8")
	if err != nil {
		return nil, err
	}
	return db, nil
}


*/

package configuraciones

//var ConnectionString string = "root:123456@tcp(172.17.0.2:3306)/testappv1?parseTime=True"

/*pasos para configurar la db remota
1-en linux copiar el certificado a la ruta sudo cp ca.crt /usr/local/share/ca-certificates/
2-ejecutar update ca-certificates
3-con esto la pc que esta ejecutando el programa  ya esta certificada y puede conectarse
*/
var ConnectionString string = "developer:AVNS_-VOrwRcsZd7Xjc_@tcp(db-mysql-arreglatap-do-user-11514964-0.b.db.ondigitalocean.com:25060)/arreglatappdb?parseTime=True"
var SecretKey string = "GuiltyGear-Heaven-or-hell"
var JwtSecretKey = []byte("GuiltyGear-Heaven-or-hell")
var PuertoApp string = ":8081"
