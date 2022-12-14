from rest_framework import serializers 
from posts.models import Post
 
 
class PostsSerializer(serializers.ModelSerializer):
 
    class Meta:
        model = Post
        fields = ('id',
                  'content',
                  'userId',
                  'publishDate',
                  'pathMedia',
                  'published')