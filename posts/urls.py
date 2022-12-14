from django.urls import re_path
from posts import views 
 
urlpatterns = [ 
    re_path(r'^api/posts$', views.post_list),
    re_path(r'^api/posts/(?P<pk>[0-9]+)$', views.post_detail),
    # re_path(r'^api/posts/published$', views.posts_list_published)
]