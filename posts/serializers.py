from rest_framework import serializers 
from posts.models import Posts
 
 
class PostsSerializer(serializers.ModelSerializer):
 
    class Meta:
        model = Posts
        fields = ('id',
                  'content',
                  'userId',
                  'publishDate',
                  'pathMedia')