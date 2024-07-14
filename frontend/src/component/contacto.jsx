import PropTypes from "prop-types";
import React, { Component } from "react";

export default class Contacto extends Component {
  constructor(props){
    super(props);
    this.state = {
        conectado: false
    }
  }

  render() {
    return (
      <div>
        <h1>Hola {this.props.name + " " + this.props.apellido}</h1>
        <p>Tu email es: {this.props.email}</p>
        <h2>
          {this.state.conectado
            ? "Esta Contacto En Línea"
            : "Contacto No Disponible"}
        </h2>
      </div>
    );
  }
}

Contacto.propsTypes={
name:PropTypes.string,
apellido:PropTypes.string,
email:PropTypes.string,
conectado:PropTypes.bool
};