from django.urls import re_path
from users import views 
 
urlpatterns = [ 
    re_path('api/users/create$', views.create_user),
    # re_path(r'^api/posts/(?P[0-9]+)$', views.posts_detail),
    # re_path(r'^api/posts/published$', views.posts_list_published)
] 