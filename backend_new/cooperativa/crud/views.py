from django.shortcuts import render, redirect
from django.http import HttpResponse
from django.urls import reverse_lazy
from rest_framework import viewsets
from .serializer import LibroSerializer, UsuarioSerializer, AhorroSerializer, RetiroSerializer, TipoPrestamoSerializer, PrestamoSerializer, TipoPagoSerializer, PagoSerializer
from .models import Libro, Pago, Retiro, Prestamo, Usuario, Ahorro, TipoPago, TipoPrestamo
from .forms import LibroForm, PagoForm, UsuarioForm, AhorroForm, PrestamoForm, TipoPagoForm, TipoPrestamoForm, RetiroForm

# Create your views here.
def inicio(request):
    return render(request, 'paginas/inicio.html')
def libros(request):
    libros=Libro.objects.all()
    return render(request, 'paginas/libros.html', {'libros': libros})
def nosotros(request):
    return render(request, 'paginas/nosotros.html')
def usuarios(request):
    usuarios=Usuario.objects.all()
    return render(request, 'paginas/usuarios.html', {'usuarios': usuarios})
def ahorro(request):
    ahorro=Ahorro.objects.all()
    return render(request, 'paginas/ahorro.html', {'ahorro': ahorro})
def prestamo(request):
    prestamos=Prestamo.objects.all()
    return render(request, 'paginas/prestamo.html', {'prestamos': prestamos})
def tipo_prestamo(request):
    tipo_prestamo=TipoPrestamo.objects.all()
    return render(request, 'paginas/tipo_prestamo.html', {'tipo_prestamo': tipo_prestamo})
def pagos(request):
    pagos=Pago.objects.all()
    return render(request, 'paginas/pagos.html', {'pagos': pagos})
def tipopago(request):
    tipopago= TipoPago.objects.all()
    return render(request, 'paginas/tipopago.html', {'tipopago': tipopago})
def retiros(request):
    retiros=Retiro.objects.all()
    return render(request, 'paginas/retiros.html', {'retiros': retiros})

def crear(request):
    formulario = LibroForm(request.POST or None, request.FILES or None)
    if formulario.is_valid():
        formulario.save()
        return redirect('libros')
    return render(request, 'paginas/crear.html', {'formulario': formulario})
def crear_usuario(request):
    form_usuario = UsuarioForm(request.POST or None, request.FILES or None)
    if form_usuario.is_valid():
        form_usuario.save()
        return redirect('usuarios')    
    return render(request, 'paginas/crear_usuario.html', {'form_usuario': form_usuario})
def crear_ahorro(request):
    form_ahorro = AhorroForm(request.POST or None, request.FILES or None)
    if form_ahorro.is_valid():
        form_ahorro.save()
        return redirect('ahorro')    
    return render(request, 'paginas/crear_ahorro.html', {'form_ahorro': form_ahorro})
def crear_prestamo(request):
    formulario_prestamo = PrestamoForm(request.POST or None, request.FILES or None)
    if formulario_prestamo.is_valid():
        formulario_prestamo.save()
        return redirect('prestamo') 
    return render(request, 'paginas/crear_prestamo.html', {'formulario_prestamo': formulario_prestamo})
def crear_tipo_prestamo(request):
    form_tipo_prestamo = TipoPrestamoForm(request.POST or None, request.FILES or None)
    if form_tipo_prestamo.is_valid():
        form_tipo_prestamo.save()
        return redirect('tipo_prestamo') 
    return render(request, 'paginas/crear_tipo_prestamo.html', {'form_tipo_prestamo': form_tipo_prestamo})
def crear_pago(request):
    form_pago = PagoForm(request.POST or None, request.FILES or None)
    if form_pago.is_valid():
        form_pago.save()
        return redirect('pagos')    
    return render(request, 'paginas/crear_pago.html', {'form_pago': form_pago})
def crear_tipopago(request):
    form_tipopago = TipoPagoForm(request.POST or None, request.FILES or None)
    if form_tipopago.is_valid():
        form_tipopago.save()
        return redirect('tipopago')    
    return render(request, 'paginas/crear_tipopago.html', {'form_tipopago': form_tipopago})
def crear_retiro(request):
    form_retiro = RetiroForm(request.POST or None, request.FILES or None)
    if form_retiro.is_valid():
        form_retiro.save()
        return redirect('retiros')   
    return render(request, 'paginas/crear_retiro.html', {'form_retiro': form_retiro})

def editar(request,id):
    libro = Libro.objects.get(id=id)
    formulario = LibroForm(request.POST or None, request.FILES or None, instance = libro)
    if formulario.is_valid() and request.POST:
        formulario.save()
        return redirect('libros')
    return render(request, 'paginas/editar.html', {'formulario': formulario})
def editar_ahorro(request,id):
    ahorro = Ahorro.objects.get(id_ahorro=id)
    form_ahorro = AhorroForm(request.POST or None, request.FILES or None, instance = ahorro)
    if form_ahorro.is_valid() and request.POST:
        form_ahorro.save()
        return redirect('ahorro')
    return render(request, 'paginas/editar_ahorro.html', {'form_ahorro': form_ahorro})
def editar_prestamo(request,id):
    prestamo = Prestamo.objects.get(id_prestamo=id)
    formulario_prestamo = PrestamoForm(request.POST or None, request.FILES or None, instance = prestamo)
    if formulario_prestamo.is_valid() and request.POST:
        formulario_prestamo.save()
        return redirect('prestamo')
    return render(request, 'paginas/editar_prestamo.html', {'formulario_prestamo': formulario_prestamo})
def editar_tipo_prestamo(request,id):
    tipo_prestamo = TipoPrestamo.objects.get(id_tipo_prestamo=id)
    form_tipo_prestamo = TipoPrestamoForm(request.POST or None, request.FILES or None, instance = tipo_prestamo)
    if form_tipo_prestamo.is_valid() and request.POST:
        form_tipo_prestamo.save()
        return redirect('tipo_prestamo')
    return render(request, 'paginas/editar_tipo_prestamo.html', {'form_tipo_prestamo': form_tipo_prestamo})
def editar_usuario(request,id):
    usuarios = Usuario.objects.get(id_user=id)
    form_usuario = UsuarioForm(request.POST or None, request.FILES or None, instance = usuarios)
    if form_usuario.is_valid() and request.POST:
        form_usuario.save()
        return redirect('usuarios')
    return render(request, 'paginas/editar_usuario.html', {'form_usuario': form_usuario})
def editar_pago(request,id):
    pagos = Pago.objects.get(id_pagos=id)
    form_pago = PagoForm(request.POST or None, request.FILES or None, instance = pagos)
    if form_pago.is_valid() and request.POST:
        form_pago.save()
        return redirect('pagos')
    return render(request, 'paginas/editar_pago.html', {'form_pago': form_pago})
def editar_tipopago(request,id):
    tipopago = TipoPago.objects.get(id_tipo_pago=id)
    form_tipopago = TipoPagoForm(request.POST or None, request.FILES or None, instance = tipopago)
    if form_tipopago.is_valid() and request.POST:
        form_tipopago.save()
        return redirect('tipopago')
    return render(request, 'paginas/editar_tipopago.html', {'form_tipopago': form_tipopago})
def editar_retiro(request,id):
    retiros = Retiro.objects.get(id_retiro=id)
    form_retiro = RetiroForm(request.POST or None, request.FILES or None, instance = retiros)
    if form_retiro.is_valid() and request.POST:
        form_retiro.save()
        return redirect('retiros')
    return render(request, 'paginas/editar_retiro.html', {'form_retiro': form_retiro})
def eliminar(request,id):
    libro = Libro.objects.get(id=id)

def eliminar(request,id):
    libro = Libro.objects.get(id=id)
    libro.delete()
    return redirect('libros')
def eliminarusuario(request,id):
    usuario = Usuario.objects.get(id_user=id)
    usuario.delete()
    return redirect('usuarios')
def eliminarahorro(request,id):
    ahorro = Ahorro.objects.get(id_ahorro=id)
    ahorro.delete()
    return redirect('ahorro')
def eliminarprestamo(request,id):
    prestamo = Prestamo.objects.get(id_prestamo=id)
    prestamo.delete()
    return redirect('prestamo')
def eliminartipo_prestamo(request,id):
    tipo_prestamo = TipoPrestamo.objects.get(id_tipo_prestamo=id)
    tipo_prestamo.delete()
    return redirect('tipo_prestamo')
def eliminarpago(request,id):
    pago = Pago.objects.get(id_pagos=id)
    pago.delete()
    return redirect('pagos')
def eliminartipopago(request,id):
    tipopago = TipoPago.objects.get(id_tipo_pago=id)
    tipopago.delete()
    return redirect('tipopago')
def eliminarretiro(request,id):
    retiro = Retiro.objects.get(id_retiro=id)
    retiro.delete()
    return redirect('retiros')

def form(request):
    return render(request, 'paginas/form.html')
def form_usuario(request):
    return render(request, 'paginas/form_usuario.html')
def form_ahorro(request):
    return render(request, 'paginas/form_ahorro.html')
def form_prestamo(request):
    return render(request, 'paginas/form_prestamo.html')
def form_tipo_prestamo(request):
    return render(request, 'paginas/form_tipo_prestamo.html')
def form_pago(request):
    return render(request, 'paginas/form_pago.html')
def form_tipopago(request):
    return render(request, 'paginas/form_tipopago.html')
def form_retiro(request):
    return render(request, 'paginas/form_retiro.html')

# API

class LibroViewSet(viewsets.ModelViewSet):
    queryset = Libro.objects.all()
    serializer_class = LibroSerializer

class UsuarioViewSet(viewsets.ModelViewSet):
    queryset = Usuario.objects.all()
    serializer_class = UsuarioSerializer

class AhorroViewSet(viewsets.ModelViewSet):
    queryset = Ahorro.objects.all()
    serializer_class = AhorroSerializer

class RetiroViewSet(viewsets.ModelViewSet):
    queryset = Retiro.objects.all()
    serializer_class = RetiroSerializer

class TipoPrestamoViewSet(viewsets.ModelViewSet):
    queryset = TipoPrestamo.objects.all()
    serializer_class = TipoPrestamoSerializer

class PrestamoViewSet(viewsets.ModelViewSet):
    queryset = Prestamo.objects.all()
    serializer_class = PrestamoSerializer

class TipoPagoViewSet(viewsets.ModelViewSet):
    queryset = TipoPago.objects.all()
    serializer_class = TipoPagoSerializer

class PagoViewSet(viewsets.ModelViewSet):
    queryset = Pago.objects.all()
    serializer_class = PagoSerializer
