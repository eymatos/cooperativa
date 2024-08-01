from django.urls import path
from .import views



urlpatterns = [
    path('', views.inicio, name='inicio'),
    path('libros', views.libros, name='libros'),
    path('usuarios', views.usuarios, name='usuarios'),
    path('nosotros', views.nosotros, name='nosotros'),
    path('ahorro', views.ahorro, name='ahorro'),
    path('prestamo', views.prestamo, name='prestamo'),
    path('tipo_prestamo', views.tipo_prestamo, name='tipo_prestamo'),
    path('pagos', views.pagos, name='pagos'),
    path('tipopago', views.tipopago, name='tipopago'),

    path('crear', views.crear, name='crear'),
    path('crear_usuario', views.crear_usuario, name='crear_usuario'),
    path('crear_ahorro', views.crear_ahorro, name='crear_ahorro'),
    path('crear_prestamo', views.crear_prestamo, name='crear_prestamo'),
    path('crear_tipo_prestamo', views.crear_tipo_prestamo, name='crear_tipo_prestamo'),
    path('crear_pago', views.crear_pago, name='crear_pago'),
    path('crear_tipopago', views.crear_tipopago, name='crear_tipopago'),

    path('editar/<int:id>', views.editar, name='editar'),
    path('editar_ahorro/<int:id>', views.editar_ahorro, name='editar_ahorro'),
    path('editar_usuario/<int:id>', views.editar_usuario, name='editar_usuario'),
    path('editar_ahorro', views.editar_ahorro, name='editar_ahorro'),
    path('editar_prestamo/<int:id>', views.editar_prestamo, name='editar_prestamo'),
    path('editar_tipo_prestamo/<int:id>', views.editar_tipo_prestamo, name='editar_tipo_prestamo'),
    path('editar_pago/<int:id>', views.editar_pago, name='editar_pago'),
    path('editar_tipopago/<int:id>', views.editar_tipopago, name='editar_tipopago'),
   
    path('form', views.form, name='form'),
    path('form_usuario', views.form_usuario, name='form_usuario'),
    path('form_ahorro', views.form_ahorro, name='form_ahorro'),
    path('form_pago', views.form_pago, name='form_pago'),
    path('form_tipopago', views.form_tipopago, name='form_tipopago'),
    path('form_prestamo', views.form_prestamo, name='form_prestamo'),
    path('form_tipo_prestamo', views.form_tipo_prestamo, name='form_tipo_prestamo'),

    path('eliminar/<int:id>', views.eliminar, name='eliminar'),
    path('eliminarprestamo/<int:id>', views.eliminarprestamo, name='eliminarprestamo'),
    path('eliminartipo_prestamo/<int:id>', views.eliminartipo_prestamo, name='eliminartipo_prestamo'), 
    path('eliminarusuario/<int:id>', views.eliminarusuario, name='eliminarusuario'),
    path('eliminarpago/<int:id>', views.eliminarpago, name='eliminarpago'),
    path('eliminartipopago/<int:id>', views.eliminartipopago, name='eliminartipopago'),
    path('eliminarahorro/<int:id>', views.eliminarahorro, name='eliminarahorro'),
    
    ]
