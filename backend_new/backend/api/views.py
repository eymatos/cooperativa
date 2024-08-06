from django.shortcuts import render, redirect
from django.http import HttpResponse
from django.urls import reverse_lazy
from rest_framework import viewsets
from rest_framework.permissions import IsAuthenticated
from .serializer import UsuarioSerializer, AhorroSerializer, RetiroSerializer, TipoPrestamoSerializer, PrestamoSerializer, TipoPagoSerializer, PagoSerializer
from .models import Pago, Retiro, Prestamo, Usuario, Ahorro, TipoPago, TipoPrestamo


# API


class UsuarioViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Usuario.objects.all()
    serializer_class = UsuarioSerializer

class AhorroViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Ahorro.objects.all()
    serializer_class = AhorroSerializer

class RetiroViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Retiro.objects.all()
    serializer_class = RetiroSerializer

class TipoPrestamoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = TipoPrestamo.objects.all()
    serializer_class = TipoPrestamoSerializer

class PrestamoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Prestamo.objects.all()
    serializer_class = PrestamoSerializer

class TipoPagoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = TipoPago.objects.all()
    serializer_class = TipoPagoSerializer

class PagoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Pago.objects.all()
    serializer_class = PagoSerializer
