from django import forms
from .models import Libro, Pago, TipoPago, Prestamo, TipoPrestamo, Usuario, Ahorro,Retiro

class LibroForm(forms.ModelForm):
        class Meta:
                model = Libro
                fields='__all__'

class UsuarioForm(forms.ModelForm):
        class Meta:
                model = Usuario
                fields='__all__'

class AhorroForm(forms.ModelForm):
        class Meta:
                model = Ahorro
                fields='__all__'

class PrestamoForm(forms.ModelForm):
        class Meta:
                model = Prestamo
                fields='__all__'

class TipoPrestamoForm(forms.ModelForm):
         class Meta:
                model = TipoPrestamo
                fields='__all__'

class PagoForm(forms.ModelForm):
        class Meta:
                model = Pago
                fields='__all__'

class TipoPagoForm(forms.ModelForm):
        class Meta:
                model = TipoPago
                fields='__all__'