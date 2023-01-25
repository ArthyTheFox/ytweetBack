from django.urls import re_path
from posts import views 
from django.conf import settings
from django.conf.urls.static import static
 
urlpatterns = [ 
    re_path(r'^api/posts$', views.post_list), 
    re_path(r'^api/posts/(?P<pk>[0-9]+)$', views.post_detail), 
    # re_path(r'^api/posts/published$', views.posts_list_published)

] 

if settings.DEBUG:
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)