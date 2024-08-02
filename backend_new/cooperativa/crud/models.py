from django.db import models
from django.urls import reverse_lazy
from django.views.generic.edit import DeleteView
from django.urls import path


# Create your models here.
class Libro(models.Model):
    id = models.AutoField(primary_key=True)
    titulo = models.CharField(max_length=100, verbose_name='Titulo')
    imagen = models.ImageField(upload_to='imagenes/',null=True, verbose_name='Imagen')
    descripcion = models.TextField(null=True, verbose_name='Descripcion')

    def __str__(self):
        fila = "Titulo: " + self.titulo + " - " + " Descripcion: " + self.descripcion
        return fila
    def delete(self, using=None, keep_parents=False):
        self.imagen.storage.delete(self.imagen.name)
        super().delete()

class Usuario(models.Model):
    id_user = models.AutoField(primary_key=True, verbose_name='ID Usuario')
    cedula = models.CharField(max_length=20, unique=True, verbose_name='Cédula')
    name = models.CharField(max_length=50, verbose_name='Nombre')
    lastname = models.CharField(max_length=50, verbose_name='Apellido')
    password = models.CharField(max_length=255, verbose_name='Contraseña')
    email = models.EmailField(max_length=100, verbose_name='Correo Electrónico')
    telefono = models.CharField(max_length=20, blank=True, null=True, verbose_name='Teléfono')
    monto_ahorro = models.DecimalField(max_digits=10, decimal_places=2, blank=True, null=True, verbose_name='Monto de Ahorro')
    direccion = models.CharField(max_length=255, blank=True, null=True, verbose_name='Dirección')
    lugar_trabajo = models.CharField(max_length=100, blank=True, null=True, verbose_name='Lugar de Trabajo')
    salario = models.DecimalField(max_digits=10, decimal_places=2, blank=True, null=True, verbose_name='Salario')
    fecha_ingreso_trabajo = models.DateField(blank=True, null=True, verbose_name='Fecha de Ingreso al Trabajo')
    direccion_trabajo = models.CharField(max_length=255, blank=True, null=True, verbose_name='Dirección de Trabajo')
    telefono_trabajo = models.CharField(max_length=20, blank=True, null=True, verbose_name='Teléfono de Trabajo')
    fecha_ingreso = models.DateField(blank=True, null=True, verbose_name='Fecha de Ingreso a la Cooperativa')
    fecha_salida = models.DateField(blank=True, null=True, verbose_name='Fecha de Salida de la Cooperativa')
    estatus = models.CharField(max_length=20, blank=True, null=True, verbose_name='Estatus')
    referido_por = models.CharField(max_length=50, blank=True, null=True, verbose_name='Referido por')
    ultima_conexion = models.DateField(blank=True, null=True, verbose_name='Última Conexión')
    tipo_usuario = models.CharField(max_length=20, blank=True, null=True, verbose_name='Tipo de Usuario')

    def __str__(self):
        return f"{self.name} {self.lastname}"

class Ahorro(models.Model):
    id_ahorro = models.AutoField(primary_key=True, verbose_name='ID Ahorro')
    cedula = models.CharField(max_length=20, verbose_name='Cédula')
    monto_ahorro = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto de Ahorro')
    fecha_ahorro = models.DateField(verbose_name='Fecha de Ahorro')
    comentario = models.CharField(max_length=255, blank=True, null=True, verbose_name='Comentario')

    def __str__(self):
        return f"Ahorro de {self.cedula} por {self.monto_ahorro}"

class Retiro(models.Model):
    id_retiro = models.AutoField(primary_key=True, verbose_name='ID Retiro')
    cedula = models.CharField(max_length=20, verbose_name='Cédula')
    monto_retiro = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto de Retiro')
    fecha_retiro = models.DateField(verbose_name='Fecha de Retiro')
    comentario = models.CharField(max_length=255, blank=True, null=True, verbose_name='Comentario')

    def __str__(self):
        return f"Retiro de {self.cedula} por {self.monto_retiro}"

class TipoPrestamo(models.Model):
    id_tipo_prestamo = models.AutoField(primary_key=True, verbose_name='ID Tipo de Préstamo')
    tipo_prestamo = models.CharField(max_length=50, verbose_name='Tipo de Préstamo')
    interes = models.DecimalField(max_digits=5, decimal_places=2, verbose_name='Interés')
    mora = models.DecimalField(max_digits=5, decimal_places=2, blank=True, null=True, verbose_name='Mora')

    def __str__(self):
        return self.tipo_prestamo

class Prestamo(models.Model):
    id_prestamo = models.AutoField(primary_key=True, verbose_name='ID Préstamo')
    cedula = models.CharField(max_length=20, verbose_name='Cédula')
    id_tipo_prestamo = models.ForeignKey(TipoPrestamo, on_delete=models.CASCADE, verbose_name='Tipo de Préstamo')
    monto_inicial = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto Inicial')
    plazo_meses = models.IntegerField(verbose_name='Plazo en Meses')
    capital_pendiente = models.DecimalField(max_digits=10, decimal_places=2, blank=True, null=True, verbose_name='Capital Pendiente')
    fecha_solicitud = models.DateField(verbose_name='Fecha de Solicitud')
    fecha_primera_cuota = models.DateField(blank=True, null=True, verbose_name='Fecha de Primera Cuota')
    fecha_final = models.DateField(blank=True, null=True, verbose_name='Fecha Final')
    estatus_prestamo = models.CharField(max_length=20, blank=True, null=True, verbose_name='Estatus del Préstamo')

    def __str__(self):
        return f"Préstamo {self.id_prestamo} de {self.cedula}"

class TipoPago(models.Model):
    id_tipo_pago = models.AutoField(primary_key=True, verbose_name='ID Tipo de Pago')
    tipo_pago = models.CharField(max_length=50, verbose_name='Tipo de Pago')

    def __str__(self):
        return self.tipo_pago

class Pago(models.Model):
    id_pagos = models.AutoField(primary_key=True, verbose_name='ID Pago')
    cedula = models.CharField(max_length=20, verbose_name='Cédula')
    id_prestamo = models.ForeignKey(Prestamo, on_delete=models.CASCADE, verbose_name='Préstamo')
    monto_total = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto Total')
    monto_capital = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto Capital')
    monto_interes = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto Interés')
    fecha_pago = models.DateField(verbose_name='Fecha de Pago')
    id_tipo_pago = models.ForeignKey(TipoPago, on_delete=models.CASCADE, verbose_name='Tipo de Pago')

    def __str__(self):
        return f"Pago {self.id_pagos} de {self.cedula}"
   