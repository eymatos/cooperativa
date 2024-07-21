from django import forms
from .models import Libro, Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro,Retiro

class LibroForm(forms.ModelForm):
        class Meta:
                model = Libro
                fields='__all__'