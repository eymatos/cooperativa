from django.urls import path
from .import views 

urlpatterns = [
    path('', views.inicio, name='inicio'),
    path('libros', views.libros, name='libros'),
    path('nosotros', views.nosotros, name='nosotros'),
    path('crear', views.crear, name='crear'),
    path('editar', views.editar, name='editar'),
    path('form', views.form, name='form'),
    ]
