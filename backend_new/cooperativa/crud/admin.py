from django.contrib import admin
from .models import Libro, Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro,Retiro

# Register your models here.
myModels = [Libro, Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro,Retiro]
admin.site.register(myModels)