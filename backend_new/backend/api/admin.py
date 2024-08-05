from django.contrib import admin
from .models import Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro, Retiro

# Register your models here.
myModels = [Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro, Retiro]
admin.site.register(myModels)