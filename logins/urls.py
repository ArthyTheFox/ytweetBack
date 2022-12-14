from django.urls import re_path
from logins import views 
 
urlpatterns = [ 
    re_path('api/login$', views.login),
    # re_path(r'^api/posts/(?P[0-9]+)$', views.posts_detail),
    # re_path(r'^api/posts/published$', views.posts_list_published)
] 