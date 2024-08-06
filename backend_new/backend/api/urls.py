from django.urls import path,include
from .import views
from rest_framework import routers
from api import views


router=routers.DefaultRouter()
router.register(r'usuarios', views.UsuarioViewSet)
router.register(r'ahorros', views.AhorroViewSet)
router.register(r'retiros', views.RetiroViewSet)
router.register(r'tipoprestamos', views.TipoPrestamoViewSet)
router.register(r'prestamos', views.PrestamoViewSet)
router.register(r'tipopagos', views.TipoPagoViewSet)
router.register(r'pagos', views.PagoViewSet)



urlpatterns = [
    path('', include(router.urls)),      
    ]
