from rest_framework import serializers
from api.models import Usuario, Ahorro, Retiro, TipoPrestamo, Prestamo, TipoPago, Pago

class UsuarioSerializer(serializers.ModelSerializer):
    class Meta:
        model = Usuario
        fields = '__all__'
        extra_kwargs = {'password':{'write_only':True}}
    def create(self, validated_data):
        user = Usuario.objects.create_user(**validated_data)
        return user

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