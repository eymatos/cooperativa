from django.shortcuts import render
from django.http import HttpResponse 
# Create your views here.
def inicio(request):
    return render(request, 'paginas/inicio.html')
def libros(request):
    return render(request, 'paginas/libros.html')
def nosotros(request):
    return render(request, 'paginas/nosotros.html')


def crear(request):
    return render(request, 'paginas/crear.html')
def editar(request):
    return render(request, 'paginas/editar.html')
def form(request):
    return render(request, 'paginas/form.html')


def crear_usuario(request):
    return render(request, 'paginas/crear_usuario.html')
def editar_usuario(request):
    return render(request, 'paginas/editar_usuario.html')
def formulario_usuario(request):
    return render(request, 'paginas/formulario_usuario.html')

def crear_ahorro(request):
    return render(request, 'paginas/crear_ahorro.html')
def editar_ahorro(request):
    return render(request, 'paginas/editar_ahorro.html')
def formulario_ahorro(request):
    return render(request, 'paginas/formulario_ahorro.html')

def crear_retiro(request):
    return render(request, 'paginas/crear_retiro.html')
def editar_retiro(request):
    return render(request, 'paginas/editar_retiro.html')
def formulario_retiro(request):
    return render(request, 'paginas/formulario_retiro.html')

def crear_prestamo(request):
    return render(request, 'paginas/crear_prestamo.html')
def editar_prestamo(request):
    return render(request, 'paginas/editar_prestamo.html')
def formulario_prestamo(request):
    return render(request, 'paginas/formulario_prestamo.html')


def crear_pago(request):
    return render(request, 'paginas/crear_pago.html')
def editar_pago(request):
    return render(request, 'paginas/editar_pago.html')
def formulario_pago(request):
    return render(request, 'paginas/formulario_pago.html')

def crear_tipopago(request):
    return render(request, 'paginas/crear_tipopago.html')
def editar_tipopago(request):
    return render(request, 'paginas/editar_tipopago.html')
def formulario_tipopago(request):
    return render(request, 'paginas/formulario_tipopago.html')

def crear_tipoprestamo(request):
    return render(request, 'paginas/crear_tipoprestamo.html')
def editar_tipoprestamo(request):
    return render(request, 'paginas/editar_tipoprestamo.html')
def formulario_tipoprestamo(request):
    return render(request, 'paginas/formulario_tipoprestamo.html')