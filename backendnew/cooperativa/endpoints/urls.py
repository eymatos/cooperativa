from django.urls import path
from . import views

urlpatterns = [
    path('', views.index, name='index'),  # Ejemplo de una URL básica
    # Define más URLs según las vistas que tengas en endpoints.views
]