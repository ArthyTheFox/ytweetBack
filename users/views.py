from django.shortcuts import render

from django.http.response import JsonResponse
from rest_framework.parsers import JSONParser 
from rest_framework import status
 
#from posts.models import Posts
from logins.models import Login
from rest_framework.decorators import api_view
from users.serializers import CreateUserSerializer
from django.contrib.auth.middleware import RemoteUserMiddleware
from django.contrib.auth import authenticate


@api_view(['GET', 'POST', 'DELETE'])
def create_user(request):
    # GET list of posts, POST a new tutorial, DELETE all tutorials
    # Retrieve all Tutorials/ find by title from MySQL database:

    if request.method == 'POST':
        posts_data = JSONParser().parse(request)
        posts_serializer = CreateUserSerializer(data=posts_data)
        if posts_serializer.is_valid():
            posts_serializer.save()
            return JsonResponse(posts_serializer.data, status=status.HTTP_201_CREATED) 
        return JsonResponse(posts_serializer.errors, status=status.HTTP_400_BAD_REQUEST)