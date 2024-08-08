from django.shortcuts import render, redirect
from django.contrib.auth.models import User
from rest_framework import viewsets, generics
from rest_framework.permissions import IsAuthenticated, AllowAny
from .serializer import UserSerializer, NoteSerializer, UsuarioSerializer, AhorroSerializer, RetiroSerializer, TipoPrestamoSerializer, PrestamoSerializer, TipoPagoSerializer, PagoSerializer
from .models import Note, Pago, Retiro, Prestamo, Usuario, Ahorro, TipoPago, TipoPrestamo


# API

class NoteListCreate(generics.ListCreateAPIView):
    serializer_class = NoteSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        user = self.request.user
        return Note.objects.filter(author=user)

    def perform_create(self, serializer):
        if serializer.is_valid():
            serializer.save(author=self.request.user)
        else:
            print(serializer.errors)
            
class NoteDelete(generics.DestroyAPIView):
    serializer_class = NoteSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        user = self.request.user
        return Note.objects.filter(author=user)


class CreateUserView(generics.CreateAPIView):
    queryset = User.objects.all()
    serializer_class = UserSerializer
    permission_classes = [AllowAny]
    
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
