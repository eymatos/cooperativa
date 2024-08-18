from django.urls import path
from rest_framework.routers import DefaultRouter
from api.views import UsuarioViewSet, TransaccionesViewSet, TransaccionPorCedulaView, TipoPrestamoViewSet, PrestamoViewSet, TipoOperacionViewSet, ActualizarEstatusUsuario


router= DefaultRouter()
router.register('usuarios', UsuarioViewSet, basename='usuario')
router.register('transaccion', TransaccionesViewSet, basename='transaccion')
router.register('tipoprestamos', TipoPrestamoViewSet, basename='tipoprestamos')
router.register('prestamos', PrestamoViewSet, basename='prestamos')
router.register('tipooperacion', TipoOperacionViewSet, basename='tipooperacion')


urlpatterns = [
    path('transaccion/cedula/<str:cedula>/<int:id_tipo_operacion_id>/', TransaccionPorCedulaView.as_view(), name='ahorros-por-cedula'),
    path('actualizar-estatus/<int:id_user>/', ActualizarEstatusUsuario.as_view(), name='actualizar-estatus-usuario'),
]

# Extend urlpatterns with the router URLs
urlpatterns += router.urls