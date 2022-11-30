from django.shortcuts import render

from django.http.response import JsonResponse
from rest_framework.parsers import JSONParser 
from rest_framework import status
 
from posts.models import Posts
from posts.serializers import PostsSerializer
from rest_framework.decorators import api_view


@api_view(['GET', 'POST', 'DELETE'])
def posts_list(request):
    # GET list of posts, POST a new tutorial, DELETE all tutorials
    # Retrieve all Tutorials/ find by title from MySQL database:
    if request.method == 'GET':
        posts = Posts.objects.all()
        
        content = request.GET.get('content', None)
        if content is not None:
            posts = posts.filter(content__icontains=content)
        
        posts_serializer = PostsSerializer(posts, many=True)
        return JsonResponse(posts_serializer.data, safe=False)
        #Create and Save a new Tutorial:
        # 'safe=False' for objects serialization
    elif request.method == 'POST':
        posts_data = JSONParser().parse(request)
        posts_serializer = PostsSerializer(data=posts_data)
        if posts_serializer.is_valid():
            posts_serializer.save()
            return JsonResponse(posts_serializer.data, status=status.HTTP_201_CREATED) 
        return JsonResponse(posts_serializer.errors, status=status.HTTP_400_BAD_REQUEST)