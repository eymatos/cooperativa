from django.shortcuts import render, redirect
from django.contrib.auth.models import User
from rest_framework import viewsets, generics
from rest_framework.response import Response
from rest_framework import status
from rest_framework.permissions import IsAuthenticated, AllowAny
from .serializer import UserSerializer, UsuarioSerializer, TransaccionesSerializer, TipoPrestamoSerializer, PrestamoSerializer, TipoOperacionSerializer
from .models import Transacciones, Prestamo, Usuario, TipoPrestamo, TipoOperacion
from rest_framework.views import APIView



# API
class TransaccionPorCedulaView(generics.ListAPIView):
    serializer_class = TransaccionesSerializer

    def get_queryset(self):
        cedula = self.kwargs['cedula'] 
        id_tipo_operacion_id = self.kwargs['id_tipo_operacion_id']       
        if cedula:
           queryset = Transacciones.objects.filter(cedula=cedula)
        
        if id_tipo_operacion_id:
            queryset = queryset.filter(id_tipo_operacion_id=id_tipo_operacion_id)
        
            return queryset
        else:
            return Transacciones.objects.none()  # No retorna nada si no encuentra un usuario con esa cédula

    def get(self, request, *args, **kwargs):
        queryset = self.get_queryset()
        if not queryset:
            return Response({"detail": "No se encontraron transacciones para esta cédula."}, status=status.HTTP_404_NOT_FOUND)
        serializer = self.get_serializer(queryset, many=True)
        return Response(serializer.data)
    
class CreateUserView(generics.CreateAPIView):
    queryset = User.objects.all()
    serializer_class = UserSerializer
    permission_classes = [AllowAny]
    
class UsuarioViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Usuario.objects.filter(is_active=True)
    serializer_class = UsuarioSerializer

class UsuarioDesactivadosViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Usuario.objects.exclude(is_active=True)
    serializer_class = UsuarioSerializer

class TransaccionesViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Transacciones.objects.all()
    serializer_class = TransaccionesSerializer

class TipoPrestamoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = TipoPrestamo.objects.all()
    serializer_class = TipoPrestamoSerializer

class PrestamoViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Prestamo.objects.all()
    serializer_class = PrestamoSerializer

class TipoOperacionViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = TipoOperacion.objects.all()
    serializer_class = TipoOperacionSerializer

class DeactivateUsuario(APIView):
    def patch(self, request, pk):
        try:
            usuario = Usuario.objects.get(pk=pk)
            usuario.is_active = False
            usuario.save()
            return Response({'status': 'usuario desactivado'}, status=status.HTTP_200_OK)
        except Usuario.DoesNotExist:
            return Response({'error': 'Usuario no encontrado'}, status=status.HTTP_404_NOT_FOUND)

class ActivateUsuario(APIView):
    def patch(self, request, pk):
        try:
            usuario = Usuario.objects.get(pk=pk)
            usuario.is_active = True
            usuario.save()
            return Response({'status': 'usuario activado'}, status=status.HTTP_200_OK)
        except Usuario.DoesNotExist:
            return Response({'error': 'Usuario no encontrado'}, status=status.HTTP_404_NOT_FOUND)