from django.db import models
from django.contrib.auth.models import User

# Create your models here.
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
class TipoOperacion(models.Model):
    id_tipo_operacion = models.AutoField(primary_key=True, verbose_name='ID Tipo de Operacion')
    tipo_operacion = models.CharField(max_length=50, verbose_name='Tipo de Operacion')

    def __str__(self):
        return self.tipo_operacion
    
class Transacciones(models.Model):
    id_operacion = models.AutoField(primary_key=True, verbose_name='ID Operacion')
    cedula = models.CharField(max_length=20, verbose_name='Cédula')
    monto = models.DecimalField(max_digits=10, decimal_places=2, verbose_name='Monto')
    fecha_operacion = models.DateField(verbose_name='Fecha de operacion')
    comentario = models.CharField(max_length=255, blank=True, null=True, verbose_name='Comentario')
    id_tipo_operacion = models.ForeignKey(TipoOperacion, on_delete=models.CASCADE, verbose_name='Tipo de Operacion')
     
    def __str__(self):
        return f"Ahorro de {self.cedula} por {self.monto_ahorro}"

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


   