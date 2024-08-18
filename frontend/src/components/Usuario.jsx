import React from "react"
import "../styles/Usuario.css"

function Usuario({usuario, onDelete}){

    const formatDate = new Date(usuario.created_at).toLocaleDateString("en-US")

    return (
        <div className="usuario-container">
        <p className="usuario-cedula">{usuario.cedula}</p>
        <p className="usuario-lastname">{usuario.lastname}</p>
        <p className="usuario-email">{usuario.email}</p>
        <p className="usuario-telefono">{usuario.telefono}</p>
        <p className="usuario-monto_ahorro">{usuario.monto_ahorro}</p>
        <p className="usuario-direccion">{usuario.direccion}</p>
        <p className="usuario-lugar_trabajo">{usuario.lugar_trabajo}</p>
        <p className="usuario-salario">{usuario.salario}</p>
        <p className="usuario-fecha_ingreso_trabajo">{usuario.fecha_ingreso_trabajo}</p>
        <p className="usuario-direccion_trabajo">{usuario.direccion_trabajo}</p>
        <p className="usuario-telefono_trabajo">{usuario.telefono_trabajo}</p>
        <p className="usuario-fecha_ingreso">{usuario.fecha_ingreso}</p>
        <p className="usuario-fecha_salida">{usuario.fecha_salida}</p>
        <p className="usuario-estatus">{usuario.estatus}</p>
        <p className="usuario-referido_por">{usuario.referido_por}</p>
        <p className="usuario-ultima_conexion">{usuario.ultima_conexion}</p>
        <p className="usuario-tipo_usuario">{usuario.tipo_usuario}</p>
        <p className="usuario-date">{formatDate}</p>
        <button onClick={() => onDelete(usuario.id_user)}>Eliminar</button>
    </div>
    );
}

export default Usuario;