// Crear elementos con atributos e hijo
export const createCustomElement = (element,attributes,children) => {
    let customElement = document.createElement(element);
    if (children !== undefined) children.forEach(el => {
        if (el.nodeType) {
            if (el.nodeType === 1 || el.nodeType === 11) customElement.appendChild(el);
        } else {
            customElement.innerHTML += el;
        }
    });
    addAttributes(customElement,attributes);
    return customElement;
};
// Añadir un objeto de atributos a un elemento
export const addAttributes = (element, attrObj) => {
    for (let attr in attrObj) {
        if (attrObj.hasOwnProperty(attr)) element.setAttribute(attr,attrObj[attr])
    }
};

//funcion que imprime el modal
const modalShow= content => {
    //crreando el contenedor interno del contenido del modal
    const modalContenidoElemento= createCustomElement('div', {
        id:'modalContenido', class: 'modalContenido'
    },[content]),
        //crreando el contenedor prinncipal del contenido del modal
    modalContainerElement=createCustomElement('div',{
        id:'modalContainer', class:'modal_container'
    },[modalContenidoElemento]);

    //imprimiendo el modal
    document.body.appendChild(modalContainerElement);
    //remover modal
    const  removeModal=()=>document.body.removeChild(modalContainerElement);
    modalContainerElement.addEventListener(
        'button', e=>{

    })
}
