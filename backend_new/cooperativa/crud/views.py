from django.shortcuts import render
from django.http import HttpResponse 
# Create your views here.
def inicio(request):
    return render(request, 'paginas/inicio.html')
def nosotros(request):
    return render(request, 'paginas/nosotros.html')
def crear(request):
    return render(request, 'paginas/crear.html')
def editar(request):
    return render(request, 'paginas/editar.html')
def form(request):
    return render(request, 'paginas/form.html')
