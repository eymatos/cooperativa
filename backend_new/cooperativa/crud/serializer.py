from rest_framework import serializers
from crud.models import Libro, Usuario, Ahorro, Retiro, TipoPrestamo, Prestamo, TipoPago, Pago

class LibroSerializer(serializers.ModelSerializer):
    class Meta:
        model = Libro
        fields = '__all__'

class UsuarioSerializer(serializers.ModelSerializer):
    class Meta:
        model = Usuario
        fields = '__all__'

class AhorroSerializer(serializers.ModelSerializer):
    class Meta:
        model = Ahorro
        fields = '__all__'

class RetiroSerializer(serializers.ModelSerializer):
    class Meta:
        model = Retiro
        fields = '__all__'

class TipoPrestamoSerializer(serializers.ModelSerializer):
    class Meta:
        model = TipoPrestamo
        fields = '__all__'

class PrestamoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Prestamo
        fields = '__all__'

class TipoPagoSerializer(serializers.ModelSerializer):
    class Meta:
        model = TipoPago
        fields = '__all__'

class PagoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Pago
        fields = '__all__'