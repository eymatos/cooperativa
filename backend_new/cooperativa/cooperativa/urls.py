
from django.contrib import admin
from django.urls import path
from django.urls import include
from django.conf import settings
from django.contrib.staticfiles.urls import static
from rest_framework.documentation import include_docs_urls
from rest_framework_simplejwt.views import (
    TokenObtainPairView,
    TokenRefreshView,
)

urlpatterns = [
    path('admin/', admin.site.urls),
    path('',include('crud.urls')),
    path('_debug_/', include('debug_toolbar.urls')),
    path('api/v1/', include('crud.urls')),
    path('docs/', include_docs_urls(title='Cooperativa API')),
    path('api/token/', TokenObtainPairView.as_view(), name='token_obtain_pair'),
    path('api/token/refresh/', TokenRefreshView.as_view(), name='token_refresh'),
    
]+static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)

