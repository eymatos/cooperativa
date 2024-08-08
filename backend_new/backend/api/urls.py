from django.urls import path
from rest_framework.routers import DefaultRouter
from api.views import UsuarioViewSet, AhorroViewSet, RetiroViewSet, TipoPrestamoViewSet, PrestamoViewSet, TipoPagoViewSet, PagoViewSet
from . import views

router= DefaultRouter()
router.register('usuarios', UsuarioViewSet, basename='usuario')
router.register('ahorros', AhorroViewSet, basename='ahorros')
router.register('retiros', RetiroViewSet, basename='retiros')
router.register('tipoprestamos', TipoPrestamoViewSet, basename='tipoprestamos')
router.register('prestamos', PrestamoViewSet, basename='prestamos')
router.register('tipopagos', TipoPagoViewSet, basename='tipopagos')
router.register('pagos', PagoViewSet, basename='pagos')


urlpatterns = [
    path("notes/", views.NoteListCreate.as_view(), name="note-list"),
    path("notes/delete/<int:pk>/", views.NoteDelete.as_view(), name="delete-note"),
]

# Extend urlpatterns with the router URLs
urlpatterns += router.urls