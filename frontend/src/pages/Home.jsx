import {useState, useEffect} from "react"
import api from "../api"
import Usuario from "../components/Usuario"
import "../styles/Home.css"
import ActualizarEstatusUsuario from "../components/ActualizarEstatusUsuario"


function Home(){

    const [usuario, setUsuario] = useState([]);
    const [id_user, setId_user] = useState("");
    const [cedula, setCedula] = useState("");
    const [lastname, setLastname] = useState("");
    const [password, setPassword] = useState("");
    const [email, setEmail] = useState("");
    const [telefono, setTelefono] = useState("");
    const [monto_ahorro, setMonto_ahorro] = useState("");
    const [direccion, setDireccion] = useState("");
    const [lugar_trabajo, setLugar_trabajo] = useState("");
    const [salario, setSalario] = useState("");
    const [fecha_ingreso_trabajo, setFecha_ingreso_trabajo] = useState("");
    const [direccion_trabajo, setDireccion_trabajo] = useState("");
    const [telefono_trabajo, setTelefono_trabajo] = useState("");
    const [fecha_ingreso, setFecha_ingreso] = useState("");
    const [fecha_salida, setFecha_salida] = useState("");
    const [estatus, setEstatus] = useState("");
    const [referido_por, setReferido_por] = useState("");
    const [ultima_conexion, setUltima_conexion] = useState("");
    const [tipo_usuario, setTipo_usuario] = useState("");

    useEffect(() => {
        getUsuario();
    }, []);

    const getUsuario = () => {
        api
            .get("/api/usuarios/")
            .then((res) => res.data)
            .then((data) =>
                 {setUsuario(data); 
                console.log(data) 
            })
            .catch((err) => console.log(err));
    };

   const deleteUsuario = (e) => {
    e.preventDefault();
        api
            .patch("/api/actualizar-estatus/", {is_active})
            .then((res) =>{
                if(res.status === 204)alert("Usuario desactivado")
                else alert("Error al desactivar")
                getUsuario();
            })
            .catch((err) => console.log(err))
            
    };

    const createUsuario = (e) => {
        e.preventDefault();
        api
        .post("/api/usuarios/", { cedula, 
            lastname, 
            password, 
            email, 
            telefono, 
            monto_ahorro, 
            direccion, 
            lugar_trabajo, 
            salario, fecha_ingreso_trabajo, 
            direccion_trabajo, telefono_trabajo, 
            fecha_ingreso, 
            fecha_salida, 
            estatus, 
            referido_por, 
            ultima_conexion, 
            tipo_usuario 
        }).then((res) => {
        if(res.status === 201)alert("Usuario creado")
        else alert("Error al crear")
        getUsuario();
    }).catch((err) => console.log(err))
    
};
return <div>
    <div>
        <h2>Usuarios</h2>
        {usuario.map((usuario) => <Usuario usuario={usuario} onDelete={deleteUsuario} key={usuario.id_user}/>)}
    </div>
    <h2>Crear Usuario</h2>
    <form onSubmit={createUsuario}>
        <input type="text" placeholder="Cedula" onChange={(e) => setCedula(e.target.value)} />
        <input type="text" placeholder="Apellido" onChange={(e) => setLastname(e.target.value)} />
        <input type="password" placeholder="Contraseña" onChange={(e) => setPassword(e.target.value)} />
        <input type="email" placeholder="Correo" onChange={(e) => setEmail(e.target.value)} />
        <input type="text" placeholder="Telefono" onChange={(e) => setTelefono(e.target.value)} />
        <input type="text" placeholder="Monto Ahorro" onChange={(e) => setMonto_ahorro(e.target.value)} />
        <input type="text" placeholder="Direccion" onChange={(e) => setDireccion(e.target.value)} />
        <input type="text" placeholder="Lugar Trabajo" onChange={(e) => setLugar_trabajo(e.target.value)} />
        <input type="text" placeholder="Salario" onChange={(e) => setSalario(e.target.value)} />
        <input type="date" placeholder="Fecha Ingreso Trabajo" onChange={(e) => setFecha_ingreso_trabajo(e.target.value)} />
        <input type="text" placeholder="Direccion Trabajo" onChange={(e) => setDireccion_trabajo(e.target.value)} />
        <input type="text" placeholder="Telefono Trabajo" onChange={(e) => setTelefono_trabajo(e.target.value)} />
        <input type="date" placeholder="Fecha Ingreso" onChange={(e) => setFecha_ingreso(e.target.value)} />
        <input type="date" placeholder="Fecha Salida" onChange={(e) => setFecha_salida(e.target.value)} />
        <input type="text" placeholder="Estatus" onChange={(e) => setEstatus(e.target.value)} />
        <input type="text" placeholder="Referido Por" onChange={(e) => setReferido_por(e.target.value)} />
        <input type="date" placeholder="Ultima Conexion" onChange={(e) => setUltima_conexion(e.target.value)} />
        <input type="text" placeholder="Tipo Usuario" onChange={(e) => setTipo_usuario(e.target.value)} />
        <button type="submit">Crear</button>
    </form>
    <h1>Actualizar Estatus del Usuario</h1>
    <ActualizarEstatusUsuario id_user={id_user} />
</div>

}
export default Home