from django.shortcuts import render

from django.http.response import JsonResponse
from rest_framework.parsers import JSONParser 
from rest_framework import status
 
from posts.models import Post
from posts.serializers import PostsSerializer
from rest_framework.decorators import api_view


@api_view(['GET', 'POST', 'DELETE'])
def post_list(request):
    # GET list of posts, POST a new tutorial, DELETE all tutorials
    # Retrieve all Tutorials/ find by title from MySQL database:
    if request.method == 'GET':
        posts = Post.objects.all()
        
        content = request.GET.get('content', None)
        if content is not None:
            posts = posts.filter(content__icontains=content)
        
        posts_serializer = PostsSerializer(posts, many=True)
        return JsonResponse(posts_serializer.data, safe=False)
        #Create and Save a new Tutorial:
        # 'safe=False' for objects serialization
    elif request.method == 'POST':
         
        #recupere le fichier
        myFile = request.FILE["pathMedia"]
        print(myFile.name) 

        #envoie les parametres vers la base de donnees
        posts_data = JSONParser().parse(request)
        posts_serializer = PostsSerializer(data=posts_data)
        if posts_serializer.is_valid():
            posts_serializer.save()
            return JsonResponse(posts_serializer.data, status=status.HTTP_201_CREATED) 
        return JsonResponse(posts_serializer.errors, status=status.HTTP_400_BAD_REQUEST)

@api_view(['GET', 'DELETE'])
def post_detail(request, pk):
   # find posts by pk (id)
    try: 
        post = Post.objects.get(pk=pk) 
        #recuperer post
        if request.method == 'GET': 
            post_serializer = PostsSerializer(post) 
            return JsonResponse(post_serializer.data) 
        #supprime le post
        elif request.method == 'DELETE':
            post.delete() 
            return JsonResponse({'message': 'Post id = '+ pk +' was deleted successfully!'}, status=status.HTTP_204_NO_CONTENT)
        
    except Post.DoesNotExist: 
        return JsonResponse({'message': 'The post does not exist'}, status=status.HTTP_404_NOT_FOUND) 

