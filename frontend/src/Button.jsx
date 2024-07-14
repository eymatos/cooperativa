import PropTypes from 'prop-types'

export function Button ({text}){
    console.log(text)
    return <button>{text}</button>
}

/* Button.PropTypes usa la libreria instalada con npm prop-types,
 que se installa con npm i prop-types y sirve para definir reglas
 en el uso de un componente, como por ejemplo el componente Button
 Que utilizando la libreria PropTypes, podemos ponerle reglas a la
 propiedad text, haciendo que text pueda solo ser tipo string
 y que sea requerido ponerle un valor, en caso de no cumplirse
 esta regla, la consola muestra los errores especificos.
*/

Button.propTypes = {
    text: PropTypes.string.isRequired
}