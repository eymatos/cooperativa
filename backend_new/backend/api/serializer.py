from django.contrib.auth.models import User
from rest_framework import serializers
from api.models import Transacciones, Usuario,  TipoPrestamo, Prestamo, TipoOperacion


class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = User
        fields = ["id", "username", "password"]
        extra_kwargs = {"password": {"write_only": True}}

    def create(self, validated_data):
        print(validated_data)
        user = User.objects.create_user(**validated_data)
        return user


class UsuarioSerializer(serializers.ModelSerializer):
    class Meta:
        model = Usuario
        fields = '__all__'
        extra_kwargs = {'password':{'write_only':True}}
    def create(self, validated_data):
        user = Usuario.objects.create_user(**validated_data)
        return user

class TransaccionesSerializer(serializers.ModelSerializer):
    class Meta:
        model = Transacciones
        fields = '__all__'

class TipoPrestamoSerializer(serializers.ModelSerializer):
    class Meta:
        model = TipoPrestamo
        fields = '__all__'

class PrestamoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Prestamo
        fields = '__all__'

class TipoOperacionSerializer(serializers.ModelSerializer):
    class Meta:
        model = TipoOperacion
        fields = '__all__'