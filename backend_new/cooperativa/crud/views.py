from django.shortcuts import render, redirect
from django.http import HttpResponse
from django.urls import reverse_lazy
from django.views.generic.edit import DeleteView
from .models import Libro, Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro,Retiro
from .forms import LibroForm, UsuarioForm

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


def crear(request):
    formulario = LibroForm(request.POST or None, request.FILES or None)
    if formulario.is_valid():
        formulario.save()
        return redirect('libros')
    return render(request, 'paginas/crear.html', {'formulario': formulario})
def editar(request,id):
    libro = Libro.objects.get(id=id)
    formulario = LibroForm(request.POST or None, request.FILES or None, instance = libro)
    if formulario.is_valid() and request.POST:
        formulario.save()
        return redirect('libros')
    return render(request, 'paginas/editar.html', {'formulario': formulario})
def eliminar(request,id):
    libro = Libro.objects.get(id=id)
    libro.delete()
    return redirect('libros')
def form(request):
    return render(request, 'paginas/form.html')
def form_usuario(request):
    return render(request, 'paginas/form_usuario.html')


def crear_usuario(request):
    formulario_usuario = UsuarioForm(request.POST or None, request.FILES or None)
    if formulario_usuario.is_valid():
        formulario_usuario.save()
        return redirect('usuarios')    
    return render(request, 'paginas/crear_usuario.html', {'formulario_usuario': formulario_usuario})
def editar_usuario(request):
    return render(request, 'paginas/editar_usuario.html')
def formulario_usuarios(request):
    return render(request, 'paginas/formulario_usuarios.html')

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

 
class UsuarioDeleteView(DeleteView):
    model = Usuario
    template_name = 'usuario_confirm_delete.html'
    success_url = reverse_lazy('usuarios:list')  # Asegúrate de tener una URL nombrada para la lista de usuarios

class AhorroDeleteView(DeleteView):
    model = Ahorro
    template_name = 'ahorro_confirm_delete.html'
    success_url = reverse_lazy('ahorros:list')

class RetiroDeleteView(DeleteView):
    model = Retiro
    template_name = 'retiro_confirm_delete.html'
    success_url = reverse_lazy('retiros:list')

class TipoPrestamoDeleteView(DeleteView):
    model = TipoPrestamo
    template_name = 'tipoprestamo_confirm_delete.html'
    success_url = reverse_lazy('tiposprestamos:list')

class PrestamoDeleteView(DeleteView):
    model = Prestamo
    template_name = 'prestamo_confirm_delete.html'
    success_url = reverse_lazy('prestamos:list')

class TipoPagoDeleteView(DeleteView):
    model = TipoPago
    template_name = 'tipopago_confirm_delete.html'
    success_url = reverse_lazy('tipospagos:list')

class PagoDeleteView(DeleteView):
    model = Pago
    template_name = 'pago_confirm_delete.html'
    success_url = reverse_lazy('pagos:list')