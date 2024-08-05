from django.shortcuts import render
from rest_framework import viewsets, generics
from ...backend.api.serializer import UsuarioSerializer, AhorroSerializer, RetiroSerializer, TipoPrestamoSerializer, PrestamoSerializer, TipoPagoSerializer, PagoSerializer
from .models import Pago, Retiro, Prestamo, Usuario, Ahorro, TipoPago, TipoPrestamo
from rest_framework.permissions import IsAuthenticated, AllowAny
# Create your views here.

class CreateUserView(generics.CreateAPIView):
    queryset = Usuario.objects.all()
    serializer_class = Usuario
    permission_classes = [AllowAny]
    
class UsuarioViewSet(viewsets.ModelViewSet):
    permission_classes = [AllowAny]
    queryset = Usuario.objects.all()
    serializer_class = UsuarioSerializer

class AhorroViewSet(viewsets.ModelViewSet):
    permission_classes = [AllowAny]
    queryset = Ahorro.objects.all()
    serializer_class = AhorroSerializer

class RetiroViewSet(viewsets.ModelViewSet):
    permission_classes = [AllowAny]
    queryset = Retiro.objects.all()
    serializer_class = RetiroSerializer

class TipoPrestamoViewSet(viewsets.ModelViewSet):
    permission_classes = [AllowAny]
    queryset = TipoPrestamo.objects.all()
    serializer_class = TipoPrestamoSerializer

class PrestamoViewSet(viewsets.ModelViewSet):
    permission_classes = [AllowAny]
    queryset = Prestamo.objects.all()
    serializer_class = PrestamoSerializer

class TipoPagoViewSet(viewsets.ModelViewSet):
    permission_classes = [AllowAny]
    queryset = TipoPago.objects.all()
    serializer_class = TipoPagoSerializer

class PagoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Pago.objects.all()
    serializer_class = PagoSerializer
