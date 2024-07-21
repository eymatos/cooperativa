from django.db import models

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
        self.imagen.delete()
        super().delete()

class Usuario(models.Model):
    id_user = models.AutoField(primary_key=True)
    cedula = models.CharField(max_length=20, unique=True)
    name = models.CharField(max_length=50)
    lastname = models.CharField(max_length=50)
    password = models.CharField(max_length=255)
    email = models.EmailField(max_length=100)
    telefono = models.CharField(max_length=20, blank=True, null=True)
    monto_ahorro = models.DecimalField(max_digits=10, decimal_places=2, blank=True, null=True)
    direccion = models.CharField(max_length=255, blank=True, null=True)
    lugar_trabajo = models.CharField(max_length=100, blank=True, null=True)
    salario = models.DecimalField(max_digits=10, decimal_places=2, blank=True, null=True)
    fecha_ingreso_trabajo = models.DateField(blank=True, null=True)
    direccion_trabajo = models.CharField(max_length=255, blank=True, null=True)
    telefono_trabajo = models.CharField(max_length=20, blank=True, null=True)
    fecha_ingreso = models.DateField(blank=True, null=True)
    fecha_salida = models.DateField(blank=True, null=True)
    estatus = models.CharField(max_length=20, blank=True, null=True)
    referido_por = models.CharField(max_length=50, blank=True, null=True)
    ultima_conexion = models.DateTimeField(blank=True, null=True)
    tipo_usuario = models.CharField(max_length=20, blank=True, null=True)

    def __str__(self):
        return f"{self.name} {self.lastname}"

class Ahorro(models.Model):
    id_ahorro = models.AutoField(primary_key=True)
    cedula = models.CharField(max_length=20)
    monto_ahorro = models.DecimalField(max_digits=10, decimal_places=2)
    fecha_ahorro = models.DateField()
    comentario = models.CharField(max_length=255, blank=True, null=True)

    def __str__(self):
        return f"Ahorro de {self.cedula} por {self.monto_ahorro}"

class Retiro(models.Model):
    id_retiro = models.AutoField(primary_key=True)
    cedula = models.CharField(max_length=20)
    monto_retiro = models.DecimalField(max_digits=10, decimal_places=2)
    fecha_retiro = models.DateField()
    comentario = models.CharField(max_length=255, blank=True, null=True)

    def __str__(self):
        return f"Retiro de {self.cedula} por {self.monto_retiro}"

class TipoPrestamo(models.Model):
    id_tipo_prestamo = models.AutoField(primary_key=True)
    tipo_prestamo = models.CharField(max_length=50)
    interes = models.DecimalField(max_digits=5, decimal_places=2)
    mora = models.DecimalField(max_digits=5, decimal_places=2, blank=True, null=True)

    def __str__(self):
        return self.tipo_prestamo

class Prestamo(models.Model):
    id_prestamo = models.AutoField(primary_key=True)
    cedula = models.CharField(max_length=20)
    id_tipo_prestamo = models.ForeignKey(TipoPrestamo, on_delete=models.CASCADE)
    monto_inicial = models.DecimalField(max_digits=10, decimal_places=2)
    plazo_meses = models.IntegerField()
    capital_pendiente = models.DecimalField(max_digits=10, decimal_places=2, blank=True, null=True)
    fecha_solicitud = models.DateField()
    fecha_primera_cuota = models.DateField(blank=True, null=True)
    fecha_final = models.DateField(blank=True, null=True)
    estatus_prestamo = models.CharField(max_length=20, blank=True, null=True)

    def __str__(self):
        return f"Prestamo {self.id_prestamo} de {self.cedula}"

class TipoPago(models.Model):
    id_tipo_pago = models.AutoField(primary_key=True)
    tipo_pago = models.CharField(max_length=50)

    def __str__(self):
        return self.tipo_pago

class Pago(models.Model):
    id_pagos = models.AutoField(primary_key=True)
    cedula = models.CharField(max_length=20)
    id_prestamo = models.ForeignKey(Prestamo, on_delete=models.CASCADE)
    monto_total = models.DecimalField(max_digits=10, decimal_places=2)
    monto_capital = models.DecimalField(max_digits=10, decimal_places=2)
    monto_interes = models.DecimalField(max_digits=10, decimal_places=2)
    fecha_pago = models.DateField()
    id_tipo_pago = models.ForeignKey(TipoPago, on_delete=models.CASCADE)

    def __str__(self):
        return f"Pago {self.id_pagos} de {self.cedula}"