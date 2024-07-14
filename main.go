package main

import (
	"fmt"
)

func main() {
	fmt.Println("Iniciando Servidor Backend")
	/*La funcion handleRequest esta en el archivo routes y es la que registra las rutas y cotrollers que se usaran.
	  En algunos ejemplos en la web, a esta funcion la pueden llamar RegisterRoutes.
	*/
	handleRequest()

}
